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
  * with: isNotArray
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage Data must be an array.
   * @expectedExceptionCode 101
   * @dataProvider getSetSSIDExceptionData
  */
  public function test_set_called_isNotArray_throwException()
  {
    $this->configureSut()->set('dummy data value');
  }

  /**
  * dataProvider getSetSSIDExceptionData
  */
  public function getSetSSIDExceptionData()
  {
    return array(
      array(array('dummy data')),
      array(array('dummy' => 'data')),
    );
  }

  /**
  * method: set
  * when: called
  * with: withoutSSID
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage SSID must be included on data array.
   * @expectedExceptionCode 102
   * @dataProvider getSetSSIDExceptionData
  */
  public function test_set_called_withoutSSID_throwException($data)
  {
      $this->configureSut()->set($data);
  }

  /**
  * method: set
  * when: called
  * with: withoutName
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage Name must be included on data array.
   * @expectedExceptionCode 102
  */
  public function test_set_called_withoutName_throwException()
  {
    $data = array('ssid' => 'dummy ssid');
    $this->configureSut()->set($data);
  }

  /**
  * method: set
  * when: called
  * with: withoutSurname
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage Surname must be included on data array.
   * @expectedExceptionCode 102
  */
  public function test_set_called_withoutSurname_throwException()
  {
    $data = array('ssid' => 'dummy ssid', 'name' => 'dummy name');
    $this->configureSut()->set($data);
  }

  /**
  * method: set
  * when: called
  * with: withoutEmail
  * should: throwException
   * @expectedException \Communify\S2O\S2OException
   * @expectedExceptionMessage Email must be included on data array.
   * @expectedExceptionCode 102
  */
  public function test_set_called_withoutEmail_throwException()
  {
    $data = array('ssid' => 'dummy ssid', 'name' => 'dummy name', 'surname' => 'dummy surname');
    $this->configureSut()->set($data);
  }

  /**
  * method: set
  * when: called
  * with: correctData
  * should: correctAssignData
  */
  public function test_set_called_correctData_correctAssignData()
  {
    $data = array('ssid' => 'dummy ssid', 'name' => 'dummy name', 'surname' => 'dummy surname', 'email' => 'dummy email');
    $sut = $this->configureSut();
    $sut->set($data);
    $this->assertEquals($sut->get(), $data);
  }
  
}