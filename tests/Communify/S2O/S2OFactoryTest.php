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
  * method: credential
  * when: called
  * with: setInnerCallError
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage Data must be an array.
   * @expectedExceptionCode 101
  */
  public function test_credential_called_setInnerCallError_throwException()
  {
    $this->configureSut()->credential('dummy data');
  }

  /**
  * method: credential
  * when: called
  * with: validData
  * should: correctReturn
  */
  public function test_credential_called_validData_correctReturn()
  {
    $actual = $this->configureSut()->credential(array('name' => 'dummy name', 'surname' => 'dummy surname', 'email' => 'dummy surname', 'ssid' => 'dummy ssid'));
    $this->assertInstanceOf('Communify\S2O\S2OCredential', $actual);
  }

  /**
  * method: response
  * when: called
  * with:
  * should: correct
  */
  public function test_response_called__correct()
  {
    $json = 'dummy json';
    $actual = $this->configureSut()->response($json);
    $this->assertInstanceOf('Communify\S2O\S2OResponse', $actual);
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