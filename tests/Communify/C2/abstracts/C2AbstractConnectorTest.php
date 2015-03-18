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
namespace tests\Communify\C2\abstracts;

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\abstracts\C2AbstractFactory;
use Communify\C2\interfaces\IC2Response;
use Guzzle\Http\Message\Response;

class DummyConnector extends C2AbstractConnector
{

}

class DummyFactoryImpl extends C2AbstractFactory
{
  public function connector(){}
  public function response(){}
  public function credential($ssid, $data){}
}

class DummyResponseImpl implements IC2Response
{
  public function set(Response $response){}
}

/**
 * @covers \Communify\C2\abstracts\C2AbstractConnector
 */
class C2AbstractConnectorTest extends \PHPUnit_Framework_TestCase
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
    $this->factory = $this->getMock('tests\Communify\C2\abstracts\DummyFactoryImpl');
    $this->client = $this->getMock('Guzzle\Http\Client');
  }

  public function configureSut()
  {
    return new DummyConnector($this->factory, $this->client);
  }

  /**
  * dataProvider getConstructorDefaultClientData
  */
  public function getConstructorDefaultClientData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
  * method: constructor
  * when: called
  * with: defaultClient
  * should: correct
   * @dataProvider getConstructorDefaultClientData
  */
  public function test_constructor_called_defaultClient_correct($timesHttpClient)
  {
    $this->factory->expects($timesHttpClient)
      ->method('httpClient')
      ->will($this->returnValue($this->client));
    $sut = new DummyConnector($this->factory);
    $this->assertConstructor($sut);
  }

  /**
  * method: constructor
  * when: called
  * with: injectedAttrs
  * should: correct
  */
  public function test_constructor_called_injectedAttrs_correct()
  {
    $this->factory->expects($this->never())
      ->method('httpClient');
    $sut = new DummyConnector($this->factory, $this->client);
    $this->assertConstructor($sut);
  }

  /**
   * @param $sut
   */
  protected function assertConstructor($sut)
  {
    $this->assertAttributeEquals($this->client, 'client', $sut);
    $this->assertAttributeEquals($this->factory, 'factory', $sut);
  }

  /**
  * dataProvider getCallData
  */
  public function getCallData()
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
  * method: call
  * when: called
  * with:
  * should: correct
   * @dataProvider getCallData
  */
  public function test_call_called__correct($timesGetUrl, $timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet)
  {
    $url = 'dummy url';
    $method = 'dummy method';
    $apiMethod = 'dummy api method';
    $credentialGet = array('dummy credential array');
    $credential = $this->getMock('Communify\C2\C2Credential');
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')->disableOriginalConstructor()->getMock();
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $c2Response = $this->getMock('tests\Communify\C2\abstracts\DummyResponseImpl');

    $credential->expects($timesGetUrl)
      ->method('getUrl')
      ->will($this->returnValue($url));

    $credential->expects($timesGet)
      ->method('get')
      ->will($this->returnValue($credentialGet));

    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with($method, $url.'/'.$apiMethod, null, $credentialGet)
      ->will($this->returnValue($request));

    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));

    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($c2Response));

    $c2Response->expects($timesSet)
      ->method('set')
      ->with($response);

    $actual = $this->configureSut()->call($method, $apiMethod, $credential);
    $this->assertEquals($c2Response, $actual);
  }

}