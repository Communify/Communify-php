<?php

namespace tests\Communify\LG;


use Communify\LG\LGConnector;
use Communify\LG\LGFactory;
use Communify\LG\LGResponse;

class LGFactoryTest extends \PHPUnit_Framework_TestCase
{

  public function setUp()
  {
  }

  public function configureSut()
  {
    return new LGFactory();
  }

  /**
   * dataProvider getAllMethodsData
   */
  public function getAllMethodsData()
  {
    return array(
      array('connector', LGConnector::class),
      array('response', LGResponse::class)
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