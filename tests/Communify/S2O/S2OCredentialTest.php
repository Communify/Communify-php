<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OCredential;

class S2OCredentialTest extends \PHPUnit_Framework_TestCase
{

  private function configureSut()
  {
    return new S2OCredential();
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OCredential::factory();
    $this->assertInstanceOf('Communify\S2O\S2OCredential', $actual);
  }

  /**
  * method: set
  * when: called
  * with:
  * should: correctData
  */
  public function test_set_called__correctData()
  {
    $ssid = 'dummy ssid';
    $data = array('dummy' => 'value');
    $expected = array(
      'ssid'  => $ssid,
      'info'  => $data
    );
    $sut = $this->configureSut();
    $sut->set($ssid, $data);
    $this->assertEquals($expected, $sut->getData());
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
  */
  public function test_get_called__correct()
  {
    $ssid = 'dummy ssid';
    $data = array('dummy' => 'value');
    $expected = array(
      'ssid'  => $ssid,
      'info'  => $data
    );
    $sut = $this->configureSut();
    $sut->set($ssid, $data);
    $this->assertEquals(json_encode($expected), $sut->get());
  }

}