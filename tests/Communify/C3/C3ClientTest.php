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
use Communify\C3\C3Client;
use Communify\C3\C3Connector;

/**
 * @covers Communify\C3\C3Client
 */
class C3ClientTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Communify\C3\C3Client
   */
  private $sut;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $connector;


  public function setUp()
  {
    $this->factory = $this->getMock('Communify\C3\C3Factory');
    $this->connector = $this->getMock('Communify\C3\C3Connector');
    $this->sut = new C3Client($this->factory, $this->connector);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultAttrObject
  */
  public function test_constructor_called_noParameters_defaultAttrObject()
  {
    $sut = new C3Client();
    $this->assertAttributeInstanceOf('Communify\C3\C3Factory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Communify\C3\C3Connector', 'connector', $sut);
  }

   /**
   * dataProvider getCreateNewInstanceNoAvailableInstanceThrowExceptionData
   */
   public function getCreateNewInstanceNoAvailableInstanceThrowExceptionData()
   {
     return array(
       array($this->any(), $this->any(), $this->any()),
       array($this->once(), $this->any(), $this->any()),
       array($this->any(), $this->once(), $this->any()),
       array($this->any(), $this->any(), $this->once()),
     );
   }
   
   /**
   * method: createNewInstance
   * when: called
   * with: noAvailableInstance
   * should: throwException
    * @dataProvider getCreateNewInstanceNoAvailableInstanceThrowExceptionData
    * @expectedException \Communify\C2\C2Exception
    * @expectedExceptionMessage C3 Error: Can't create this community.
    * @expectedExceptionCode 104
   */
   public function test_createNewInstance_called_noAvailableInstance_throwException($timesCredential, $timesCall, $timesGetValue)
   {
     $accountId = 'dummy account id';
     $data = array('dummy data');
     $this->configureCommonCreateNewInstance($timesCredential, $timesCall, $timesGetValue, $accountId, $data, false);
     $this->sut->createNewInstance($accountId, $data);
   }

  /**
  * dataProvider getCreateNewInstanceData
  */
  public function getCreateNewInstanceData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: createNewInstance
  * when: called
  * with:
  * should: correct
   * @dataProvider getCreateNewInstanceData
  */
  public function test_createNewInstance_called__correct($timesCredential, $timesGetValue)
  {
    $accountId = 'dummy account id';
    $data = array('dummy data');
    $expected = 'dummy expected value';
    $credential = $this->configureCommonCreateNewInstance($timesCredential, $this->at(0), $timesGetValue, $accountId, $data, true);
    $this->configureConnectorCall($this->at(1), C3Connector::CREATE_NEW_ENVIRONMENT_API_METHOD, $credential, $expected);
    $actual = $this->sut->createNewInstance($accountId, $data);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $timesCredential
   * @param $timesCall
   * @param $timesGetValue
   * @param $accountId
   * @param $data
   * @param $value
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function configureCommonCreateNewInstance($timesCredential, $timesCall, $timesGetValue, $accountId, $data, $value)
  {
    $credential = $this->getMock('Communify\C2\C2Credential');
    $checkResponse = $this->getMock('Communify\C3\C3Response');

    $this->factory->expects($timesCredential)
      ->method('credential')
      ->with(C3Client::ENV_SSID, $accountId, $data)
      ->will($this->returnValue($credential));
    $this->configureConnectorCall($timesCall, C3Connector::CHECK_NEW_ENVIRONMENT_API_METHOD, $credential, $checkResponse);
    $checkResponse->expects($timesGetValue)
      ->method('getValue')
      ->will($this->returnValue($value));

    return $credential;
  }

  /**
   * @param $timesCall
   * @param $apiMethod
   * @param $credential
   * @param $checkResponse
   */
  private function configureConnectorCall($timesCall, $apiMethod, $credential, $checkResponse)
  {
    $this->connector->expects($timesCall)
      ->method('call')
      ->with(C3Connector::POST_METHOD, $apiMethod, $credential, $this->factory)
      ->will($this->returnValue($checkResponse));
  }

}