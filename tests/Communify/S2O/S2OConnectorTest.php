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

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
  }

  private function configureSut()
  {
    return new S2OConnector($this->factory);
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
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: login
  * when: called
  * with: correctInnerCalls
  * should: correctReturn
   * @dataProvider getLoginData
  */
  public function test_login_called_correctInnerCalls_correctReturn($timesHttpClient, $timesCredentialGet, $timesPost, $timesGetJson, $timesResponse)
  {
    $json = '{"dummy": "value"}';
    $expected = 'dummy expected value';
    $credentialData = array('dummy credential data');
    $credential = $this->getMock('Communify\S2O\S2OCredential');
    $client = $this->getMock('Guzzle\Http\Client');
    $res = $this->getMockBuilder('Guzzle\Http\Message\EntityEnclosingRequest')
      ->disableOriginalConstructor()->getMock();

    $this->factory->expects($timesHttpClient)
      ->method('httpClient')
      ->will($this->returnValue($client));

    $credential->expects($timesCredentialGet)
      ->method('get')
      ->will($this->returnValue($credentialData));

    $client->expects($timesPost)
      ->method('post')
      ->with('http://communify.com', $credentialData)
      ->will($this->returnValue($res));

    $res->expects($timesGetJson)
      ->method('getBody')
      ->will($this->returnValue($json));

    $this->factory->expects($timesResponse)
      ->method('response')
      ->with($json)
      ->will($this->returnValue($expected));

    $actual = $this->configureSut()->login($credential);
    $this->assertEquals($expected, $actual);
  }
  
}