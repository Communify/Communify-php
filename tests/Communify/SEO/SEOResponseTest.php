<?php
/**
 * Copyright 2014 Communify.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://dev.communify.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace tests\Communify\SEO;

use Communify\C2\C2Exception;
use Communify\SEO\SEOResponse;

/**
 * @covers Communify\SEO\SEOResponse
 */
class SEOResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $validator;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $mustache;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \Communify\SEO\SEOResponse
   */
  private $sut;

  public function setUp()
  {
    $this->validator = $this->getMock('Communify\C2\C2Validator');
    $this->mustache = $this->getMock('\Mustache_Engine');
    $this->factory = $this->getMock('Communify\SEO\SEOFactory');
    $this->sut = new SEOResponse($this->validator, $this->mustache, $this->factory);
  }

  /**
   * method: constructor
   * when: called
   * with: noParameters
   * should: defaultAttrObject
   */
  public function test_constructor_called_noParameters_defaultAttrObject()
  {
    $sut = new SEOResponse();
    $this->assertAttributeInstanceOf('Communify\C2\C2Validator', 'validator', $sut);
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('\Mustache_Engine', 'mustache', $sut);
  }

  /**
  * dataProvider getSetCheckDataThrowExeptionData
  */
  public function getSetCheckDataThrowExeptionData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with: checkDataThrowException
  * should: correct
   * @dataProvider getSetCheckDataThrowExeptionData
  */
  public function test_set_called_checkDataThrowException_correct($timesJson, $timesCheckData)
  {
    $result = 'dummy result';
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureJson($timesJson, $response, $result);
    $this->validator->expects($timesCheckData)
      ->method('checkData')
      ->with($result)
      ->will($this->throwException(new C2Exception()));
    $this->factory->expects($this->never())
      ->method('parser');
    $this->sut->set($response);
    $this->assertAttributeEquals(null, 'context', $this->sut);
  }

  /**
  * dataProvider getSetData
  */
  public function getSetData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with:
  * should: correct
   * @dataProvider getSetData
  */
  public function test_set_called__correct($timesJson, $timesCheckData, $timesParser, $timesGetTopic, $timesGetOpinions)
  {
    $result = 'dummy result';
    $topic = array('topic'  => 'dummy topic');
    $opinions = array('opinions'  => 'dummy opinions');
    $expected = array_merge($topic, $opinions);
    $parser = $this->getMockBuilder('Communify\SEO\SEOParser')->disableOriginalConstructor()->getMock();
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureJson($timesJson, $response, $result);
    $this->validator->expects($timesCheckData)
      ->method('checkData')
      ->with($result);
    $this->factory->expects($timesParser)
      ->method('parser')
      ->with($result)
      ->will($this->returnValue($parser));
    $parser->expects($timesGetTopic)
      ->method('getTopic')
      ->will($this->returnValue($topic));
    $parser->expects($timesGetOpinions)
      ->method('getOpinions')
      ->will($this->returnValue($opinions));
    $this->sut->set($response);
    $this->assertAttributeEquals($expected, 'context', $this->sut);
  }

  /**
   * @param $timesJson
   * @param $response
   * @param $result
   */
  protected function configureJson($timesJson, $response, $result)
  {
    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($result));
  }

  /**
  * method: html
  * when: called
  * with: nullContext
  * should: emptyString
  */
  public function test_html_called_nullContext_emptyString()
  {
    $this->sut->setContext(null);
    $this->mustache->expects($this->never())
      ->method('render');
    $actual = $this->sut->html();
    $this->assertEquals('', $actual);
  }

  /**
  * dataProvider getHtmlData
  */
  public function getHtmlData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
  * method: html
  * when: called
  * with:
  * should: correct
   * @dataProvider getHtmlData
  */
  public function test_html_called__correct($timesRender)
  {
    $html = file_get_contents(dirname(__FILE__).'/../../../src/Communify/SEO/html/template.html');
    $expected = 'dummy expected value';
    $context = 'dummy context';
    $this->mustache->expects($timesRender)
      ->method('render')
      ->with($html, $context)
      ->will($this->returnValue($expected));
    $this->sut->setContext($context);
    $actual = $this->sut->html();
    $this->assertEquals($expected, $actual);
  }

}