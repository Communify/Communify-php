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

namespace tests\Communify\S2O;

use Communify\S2O\S2OConnector;

/**
 * @covers Communify\S2O\S2OConnector
 */
class S2OConnectorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $client;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
    $this->client = $this->getMock('Guzzle\Http\Client');
  }

  /**
   * @return S2OConnector
   */
  private function configureSut()
  {
    return new S2OConnector($this->factory, $this->client);
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OConnector::factory();
    $this->assertInstanceOf('Communify\S2O\S2OConnector', $actual);
  }

  /**
  * dataProvider getLoginData
  */
  public function getLoginData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: login
  * when: called
  * with:
  * should: correctInnerCalls
   * @dataProvider getLoginData
  */
  public function test_login_called__correctInnerCalls($timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet, $timesGetUrl)
  {
    $s2OResponse = $this->getMock('Communify\S2O\S2OResponse');
    $this->configureAndExecuteLogin($timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet, $timesGetUrl, $s2OResponse);
  }

  /**
  * method: login
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_login_called__correctReturn()
  {
    $s2OResponse = $this->getMock('Communify\S2O\S2OResponse');
    $actual = $this->configureAndExecuteLogin($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $s2OResponse);
    $this->assertEquals($s2OResponse, $actual);
  }

  /**
   * @param $timesGet
   * @param $timesCreateRequest
   * @param $timesSend
   * @param $timesResponse
   * @param $timesSet
   * @param $s2OResponse
   * @param $timesGetUrl
   * @return \Communify\S2O\S2OResponse
   */
  private function configureAndExecuteLogin($timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet, $timesGetUrl, $s2OResponse)
  {
    $url = 'dummy url value';
    $request = 'dummy request object';
    $credentialData = array('dummy credential data');
    $credential = $this->getMock('Communify\S2O\S2OCredential');
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $credential->expects($timesGetUrl)
      ->method('getUrl')
      ->will($this->returnValue($url));
    $credential->expects($timesGet)
      ->method('get')
      ->will($this->returnValue($credentialData));
    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with('POST', $url.'/'.S2OConnector::SINGLE_SIGN_ON_API_METHOD, null, $credentialData)
      ->will($this->returnValue($request));
    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));
    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($s2OResponse));
    $s2OResponse->expects($timesSet)
      ->method('set')
      ->with($response);
    return $this->configureSut()->login($credential);
  }


}