<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OConnector;
use Communify\S2O\S2OFactory;

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
  public function test_login_called__correctInnerCalls($timesGet, $timesCreateRequest, $timesSend, $timesJson, $timesResponse, $timesSet)
  {
    $s2OResponse = $this->getMock('Communify\S2O\S2OResponse');
    $this->configureAndExecuteLogin($timesGet, $timesCreateRequest, $timesSend, $timesJson, $timesResponse, $timesSet, $s2OResponse);
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
   * @param $timesJson
   * @param $timesResponse
   * @param $timesSet
   * @param $s2OResponse
   * @return \Communify\S2O\S2OResponse
   */
  private function configureAndExecuteLogin($timesGet, $timesCreateRequest, $timesSend, $timesJson, $timesResponse, $timesSet, $s2OResponse)
  {
    $data = array('dummy response data');
    $credentialData = array('dummy credential data');
    $request = 'dummy request object';
    $credential = $this->getMock('Communify\S2O\S2OCredential');
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();

    $credential->expects($timesGet)
      ->method('get')
      ->will($this->returnValue($credentialData));
    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with('POST', 'http://10.0.1.126:80/api/user/authentication/login', null, $credentialData)
      ->will($this->returnValue($request));
    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));
    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($data));
    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($s2OResponse));
    $s2OResponse->expects($timesSet)
      ->method('set')
      ->with($data);
    return $this->configureSut()->login($credential);
  }


}