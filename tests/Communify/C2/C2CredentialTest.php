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

namespace tests\Communify\C2;

use Communify\C2\C2Credential;

/**
 * @covers Communify\C2\C2Credential
 */
class C2CredentialTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var C2Credential
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new C2Credential();
  }

  /**
  * method: set
  * when: called
  * with: withoutCommunifyUrl
  * should: correct
  */
  public function test_set_called_withoutCommunifyUrl_correct()
  {
    $ssid = 'dummy ssid';
    $url = 'https://communify.com/api';
    $data = array('dummy' => 'value');
    $expectedData = $this->generateExpectedData($ssid, $data);
    $this->executeAndAssertSet($ssid, $data, $expectedData, $url);
  }

  /**
  * method: set
  * when: called
  * with: witCommunifyUrl
  * should: correct
  */
  public function test_set_called_witCommunifyUrl_correct()
  {
    $ssid = 'dummy ssid';
    $url = 'dummy url';
    $data = array('dummy' => 'value', 'communify_url' => $url);
    $usedData = array('dummy' => 'value');
    $expected = $this->generateExpectedData($ssid, $usedData);
    $this->executeAndAssertSet($ssid, $data, $expected, $url);
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
   * @param $ssid
   * @param $data
   * @return array
   */
  protected function generateExpectedData($ssid, $data)
  {
    return array_merge(array('ssid' => $ssid), $data);
  }

  /**
   * @param $ssid
   * @param $data
   * @param $expectedData
   * @param $url
   */
  protected function executeAndAssertSet($ssid, $data, $expectedData, $url)
  {
    $this->sut->set($ssid, $data);
    $this->assertAttributeEquals($expectedData, 'data', $this->sut);
    $this->assertAttributeEquals($url, 'url', $this->sut);
  }

}