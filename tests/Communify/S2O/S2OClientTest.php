<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OClient;

class S2OClientTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $connector;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  public function setUp()
  {

    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
    $this->connector = $this->getMock('Communify\S2O\S2OConnector');
  }

  private function configureSut()
  {
    return new S2OClient($this->connector, $this->factory);
  }

  /**
   * method: factory
   * when: called
   * with: noDependencyInjection
   * should: correctReturn
   */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OClient::factory();
    $this->assertInstanceOf('Communify\S2O\S2OClient', $actual);
  }

  /**
  * dataProvider getLoginData
  */
  public function getLoginData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: login
  * when: called
  * with: correctInnerCalls
  * should: correctReturn
   * @dataProvider getLoginData
  */
  public function test_login_called_correctInnerCalls_correctReturn($timesCreate, $timesLogin)
  {
    $data = array('dummy data');
    $credential = $this->getMock('Communify\S2O\S2OCredential');
    $expected = 'dummy expected response';

    $this->factory->expects($timesCreate)
      ->method('credential')
      ->with($data)
      ->will($this->returnValue($credential));

    $this->connector->expects($timesLogin)
      ->method('login')
      ->with($credential)
      ->will($this->returnValue($expected));

    $actual = $this->configureSut()->login($data);
    $this->assertEquals($expected, $actual);
  }
  
}