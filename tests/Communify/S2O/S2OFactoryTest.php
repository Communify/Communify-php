<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OFactory;

class S2OFactoryTest extends \PHPUnit_Framework_TestCase
{

  private function configureSut()
  {
    return new S2OFactory();
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OFactory::factory();
    $this->assertInstanceOf('Communify\S2O\S2OFactory', $actual);
  }

  /**
  * dataProvider getS2OMethodsData
  */
  public function getS2OMethodsData()
  {
    return array(
      array('connector', 'S2OConnector'),
      array('credential', 'S2OCredential'),
      array('response', 'S2OResponse'),
      array('metasArray', 'S2OMetasArray'),
    );
  }

  /**
  * method: s2OMethods
  * when: called
  * with:
  * should: correctReturn
   * @dataProvider getS2OMethodsData
  */
  public function test_s2OMethods_called__correctReturn($method, $class)
  {
    $actual = $this->configureSut()->$method();
    $this->assertInstanceOf('Communify\S2O\\'.$class, $actual);
  }

  /**
  * method: meta
  * when: called
  * with:
  * should: correct
  */
  public function test_meta_called__correct()
  {
    $actual = $this->configureSut()->meta('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\S2O\S2OMeta', $actual);
  }

  /**
  * method: httpClient
  * when: called
  * with:
  * should: correct
  */
  public function test_httpClient_called__correct()
  {
    $actual = $this->configureSut()->httpClient();
    $this->assertInstanceOf('Guzzle\Http\Client', $actual);
  }
  
}