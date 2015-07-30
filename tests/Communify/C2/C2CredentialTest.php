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
    $accountId = 'dummy account id';
    $url = 'https://communify.com/api';
    $data = array('dummy' => 'value');
    $expected = $this->generateExpectedData($ssid, $accountId, $data);
    $this->executeAndAssertSet($ssid, $accountId, $data, $expected, $url);
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
    $accountId = 'dummy account id';
    $url = 'dummy url';
    $data = array('dummy' => 'value', 'communify_url' => $url);
    $usedData = array('dummy' => 'value');
    $expected = $this->generateExpectedData($ssid, $accountId, $usedData);
    $this->executeAndAssertSet($ssid, $accountId, $data, $expected, $url);
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
    $accountId = 'dummy account id';
    $data = array('dummy' => 'value');
    $expected = $this->generateExpectedData($ssid, $accountId, $data);
    $this->sut->set($ssid, $accountId, $data);
    $this->assertEquals(json_encode($expected), $this->sut->get());
  }

  /**
   * @param $ssid
   * @param $data
   * @return array
   */
  protected function generateExpectedData($ssid, $accountId, $data)
  {
    return array_merge(array('account_id' => $accountId, 'ssid' => $ssid), $data);
  }

  /**
   * @param $ssid
   * @param $accountId
   * @param $data
   * @param $expectedData
   * @param $url
   */
  protected function executeAndAssertSet($ssid, $accountId, $data, $expectedData, $url)
  {
    $this->sut->set($ssid, $accountId, $data);
    $this->assertAttributeEquals($expectedData, 'data', $this->sut);
    $this->assertAttributeEquals($url, 'url', $this->sut);
  }

}