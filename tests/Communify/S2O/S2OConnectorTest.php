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
    return new S2OConnector();//$this->factory);
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
  * method: login
  * when: called
  * with: correctInnerCalls
  * should: correctReturn
  */
  public function test_login_called_correctInnerCalls_correctReturn()
  {
    $expected = array('dummy expected value');
    $credential = $this->getMock('Communify\S2O\S2OCredential');
    $client = $this->getMock('Guzzle\Http\Client');
    $res = $this->getMockBuilder('Guzzle\Http\Message\EntityEnclosingRequest')
      ->disableOriginalConstructor()->getMock();

    $this->factory->expects($this->any())
      ->method('httpClient')
      ->will($this->returnValue($client));

    $credential->expects($this->any())
      ->method('get')
      ->will($this->returnValue($expected));

    $this->configureSut()->login($credential);
  }
  
}