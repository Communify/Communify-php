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

namespace tests\Communify\C3;
use Communify\C3\C3Response;
use Communify\C2\C2Exception;

/**
 * @covers Communify\C3\C3Response
 */
class C3ResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Communify\S2O\S2OResponse
   */
  private $sut;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $validator;

  public function setUp()
  {
    $this->validator = $this->getMock('Communify\C2\C2Validator');
    $this->sut = new C3Response($this->validator);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultAttrObject
  */
  public function test_constructor_called_noParameters_defaultAttrObject()
  {
    $sut = new C3Response();
    $this->assertAttributeInstanceOf('Communify\C2\C2Validator', 'validator', $sut);
  }

  /**
  * dataProvider getSetCheckDataWithExceptionData
  */
  public function getSetCheckDataWithExceptionData()
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
  * should: valueIsNull
   * @dataProvider getSetCheckDataWithExceptionData
  */
  public function test_set_called_checkDataThrowException_valueIsNull($timesJson, $timesCheckData)
  {
    $result = array('dummy result');
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureJson($timesJson, $response, $result);
    $this->configureCheckData($timesCheckData, $result, $this->throwException(new C2Exception('Dummy msg', 123)));
    $this->sut->set($response);
    $this->assertAttributeEquals(null, 'value', $this->sut);
  }

  /**
  * dataProvider getSetData
  */
  public function getSetData()
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
  * with:
  * should: correct
   * @dataProvider getSetData
  */
  public function test_set_called__correct($timesJson, $timesCheckData)
  {
    $expected = 'dummy expected value';
    $result = array('data'  => $expected);
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureJson($timesJson, $response, $result);
    $this->configureCheckData($timesCheckData, $result, $this->returnValue(true));
    $this->sut->set($response);
    $this->assertAttributeEquals($expected, 'value', $this->sut);
  }

  /**
   * @param $timesJson
   * @param $response
   * @param $result
   */
  private function configureJson($timesJson, $response, $result)
  {
    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($result));
  }

  /**
   * @param $times
   * @param $with
   */
  private function configureCheckData($times, $with, $will)
  {
    $this->validator->expects($times)
      ->method('checkData')
      ->with($with)
      ->will($will);
  }

}