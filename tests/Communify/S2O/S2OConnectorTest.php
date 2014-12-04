<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OConnector;

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


  
}