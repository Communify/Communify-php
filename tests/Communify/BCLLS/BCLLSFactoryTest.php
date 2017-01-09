<?php

namespace tests\Communify\BCLLS;


use Communify\BCLLS\BCLLSConnector;
use Communify\BCLLS\BCLLSFactory;
use Communify\BCLLS\BCLLSResponse;

class BCLLSFactoryTest extends \PHPUnit_Framework_TestCase
{

  public function setUp()
  {
  }

  public function configureSut()
  {
    return new BCLLSFactory();
  }

  /**
   * dataProvider getAllMethodsData
   */
  public function getAllMethodsData()
  {
    return array(
      array('connector', BCLLSConnector::class),
      array('response', BCLLSResponse::class)
    );
  }

  /**
   * method: allMethods
   * when: called
   * with:
   * should: correctReturn
   * @dataProvider getAllMethodsData
   */
  public function test_allMethods_called__correctReturn($method, $class)
  {
    $actual = $this->configureSut()->$method();
    $this->assertInstanceOf($class, $actual);
  }
}