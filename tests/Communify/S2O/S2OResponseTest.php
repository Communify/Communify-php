<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OResponse;

class S2OResponseTest extends \PHPUnit_Framework_TestCase
{

  private function configureSut()
  {
    return new S2OResponse();
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OResponse::factory();
    $this->assertInstanceOf('Communify\S2O\S2OResponse', $actual);
  }


  
}