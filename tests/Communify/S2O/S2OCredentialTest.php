<?php
/**
 * Copyright 2014 Communify.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://dev.communify.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace tests\Communify\S2O;

use Communify\S2O\S2OCredential;

/**
 * @covers Communify\S2O\S2OCredential
 */
class S2OCredentialTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var S2OCredential
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new S2OCredential();
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
    $this->configureAndExecuteSetWithDataAssert($expectedData, $data);
    $this->assertEquals($this->sut->getUrl(), $url);
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
    $expected = $this->generateExpectedData($ssid, $data);
    $this->sut->set($ssid, $data);
    $this->assertEquals(json_encode($expected), $this->sut->get());
  }

  /**
   * @param $expectedData
   * @param $data
   * @return S2OCredential
   */
  private function configureAndExecuteSetWithDataAssert($expectedData, $data)
  {
    $ssid = 'dummy ssid';
    $expected = $this->generateExpectedData($ssid, $expectedData);
    $this->sut->set($ssid, $data);
    $this->assertEquals($expected, $this->sut->getData());
  }

  /**
   * @param $ssid
   * @param $data
   * @return array
   */
  private function generateExpectedData($ssid, $data)
  {
    $expected = array(
      'ssid' => $ssid,
      'info' => $data
    );
    return $expected;
  }

}