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

use Communify\C2\C2Factory;

/**
 * @covers Communify\C2\C2Factory
 */
class C2FactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var C2Factory
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new C2Factory();
  }

  /**
  * dataProvider getCredentialData
  */
  public function getCredentialData()
  {
    return array(
      array(array('dummy' => 'value'), C2Factory::COMMUNIFY_API_URL),
      array(array('dummy' => 'value', 'communify_url' => 'dummy communify url'), 'dummy communify url'),
    );
  }

  /**
  * method: credential
  * when: called
  * with: communifyUrlCases
  * should: correct
   * @dataProvider getCredentialData
  */
  public function test_credential_called_communifyUrlCases_correct($data, $url)
  {
    $ssid = 'dummy ssid';
    $accountId = 'dummy account id';
    $expectedData = array(
      'account_id'  => $accountId,
      'dummy'       => 'value',
      'ssid'        => $ssid
    );
    $actual = $this->sut->credential($ssid, $accountId, $data);
    $this->assertInstanceOf('Communify\C2\C2Credential', $actual);
    $this->assertEquals($actual->getData(), $expectedData);
    $this->assertEquals($actual->getUrl(), $url);
  }

  /**
  * method: credential
  * when: called
  * with:
  * should: correct
  */
  public function test_credential_called__correct()
  {

  }

  /**
  * dataProvider getC2MethodsData
  */
  public function getC2MethodsData()
  {
    return array(
      array('encryptor', 'C2Encryptor'),
      array('metaIterator', 'C2MetaIterator'),
    );
  }

  /**
  * method: C2Methods
  * when: called
  * with:
  * should: correctReturn
   * @dataProvider getC2MethodsData
  */
  public function test_C2Methods_called__correctReturn($method, $class)
  {
    $actual = $this->sut->$method();
    $this->assertInstanceOf('Communify\C2\\'.$class, $actual);
  }

  /**
  * method: meta
  * when: called
  * with:
  * should: correct
  */
  public function test_meta_called__correct()
  {
    $actual = $this->sut->meta('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\C2\C2Meta', $actual);
  }

  /**
  * dataProvider getInvalidMethodsData
  */
  public function getInvalidMethodsData()
  {
    return array(
      array('connector'),
      array('response'),
    );
  }

  /**
  * method: invalidMethods
  * when: called
  * with:
  * should: throwExceptions
   * @dataProvider getInvalidMethodsData
   * @expectedException \Communify\C2\C2Exception
   * @expectedExceptionCode 103
   * @expectedExceptionMessage C2Factory not implements this method. Extend it.
  */
  public function test_invalidMethods_called__throwExceptions($method)
  {
    $this->sut->$method();
  }

}