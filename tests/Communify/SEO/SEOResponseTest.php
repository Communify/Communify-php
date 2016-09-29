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
use Communify\C2\C2Validator;
use Communify\SEO\SEOFactory;
use Communify\SEO\SEOParser;
use Communify\SEO\SEOResponse;
use Guzzle\Http\Message\Response as GuzzleResponse;

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
  private $factory;

  /**
   * @var \Communify\SEO\SEOResponse
   */
  private $sut;



  public function setUp()
  {
    $this->validator = $this->getMock(C2Validator::class);
    $this->factory = $this->getMock(SEOFactory::class);
    $this->sut = new SEOResponse($this->validator, $this->factory);
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
    $this->assertAttributeInstanceOf(C2Validator::class, 'validator', $sut);
    $this->assertAttributeInstanceOf(SEOFactory::class, 'factory', $sut);
  }

  /**
  * dataProvider getSetCheckDataThrowExceptionData
  */
  public function getSetCheckDataThrowExceptionData()
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
   * @dataProvider getSetCheckDataThrowExceptionData
  */
  public function test_set_called_checkDataThrowException_correct($timesJson, $timesCheckData)
  {
    $result = 'dummy result';
    $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();
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
      array($this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once())
    );
  }

  /**
  * method: set
  * when: called
  * with:
  * should: correct
   * @dataProvider getSetData
  */
  public function test_set_called__correct($timesJson, $timesCheckData, $timesParser, $timesGetTopic)
  {
    $result = 'dummy result';
    $html = 'dummy html code';
    $parser = $this->getMockBuilder(SEOParser::class)->disableOriginalConstructor()->getMock();
    $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();

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
      ->will($this->returnValue($html));

    $result = $this->sut->set($response);
    $this->assertEquals($html, $result);
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

}