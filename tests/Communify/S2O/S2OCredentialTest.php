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
  * with: noCommunifyUrl
  * should: correctData
  */
  public function test_set_called_noCommunifyUrl_correctData()
  {
    $data = array('dummy' => 'value');
    $this->configureAndExecuteSetWithDataAssert($data, $data);
  }

  /**
  * method: set
  * when: called
  * with: communifyUrl
  * should: correctDataAndUrlAttr
  */
  public function test_set_called_communifyUrl_correctDataAndUrlAttr()
  {
    $url = 'dummy communify url';
    $data = array('dummy' => 'value', 'communify_url' => $url);
    $expectedData = array('dummy' => 'value');
    $sut = $this->configureAndExecuteSetWithDataAssert($expectedData, $data);
    $this->assertEquals($sut->getUrl(), $url);
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

  /**
   * @param $expectedData
   * @param $data
   * @return S2OCredential
   */
  private function configureAndExecuteSetWithDataAssert($expectedData, $data)
  {
    $ssid = 'dummy ssid';
    $expected = array(
      'ssid' => $ssid,
      'info' => $expectedData
    );
    $sut = $this->configureSut();
    $sut->set($ssid, $data);
    $this->assertEquals($expected, $sut->getData());
    return $sut;
  }

}