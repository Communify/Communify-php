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

namespace tests\Communify\EAP;
use Communify\EAP\EAPResponse;

/**
 * @covers Communify\S2O\S2OResponse
 */
class S2OResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $validator;

  /**
   * @var \Communify\S2O\S2OResponse
   */
  private $sut;

  public function setUp()
  {
    $this->validator = $this->getMock('Communify\C2\C2Validator');
    $this->sut = new EAPResponse($this->validator);
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
    $data = 'dummy data';
    $response = $this->configureSet($timesJson, $timesCheckData, $data);
    $this->sut->set($response);
    $this->assertAttributeEquals($data, 'data', $this->sut);
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
  */
  public function test_get_called__correct()
  {
    $expected = 'dummy data';
    $response = $this->configureSet($this->any(), $this->any(), $expected);
    $this->sut->set($response);
    $actual = $this->sut->get();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $timesJson
   * @param $timesCheckData
   * @param $data
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function configureSet($timesJson, $timesCheckData, $data)
  {
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($data));
    $this->validator->expects($timesCheckData)
      ->method('checkData')
      ->with($data);
    return $response;
  }

}