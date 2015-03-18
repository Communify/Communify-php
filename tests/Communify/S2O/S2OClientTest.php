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

use Communify\S2O\S2OClient;

/**
 * @covers Communify\S2O\S2OClient
 */
class S2OClientTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $connector;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var S2OClient
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
    $this->connector = $this->getMock('Communify\S2O\S2OConnector');
    $this->sut = new S2OClient($this->factory, $this->connector);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultObjectAttrs
  */
  public function test_constructor_called_noParameters_defaultObjectAttrs()
  {
    $sut = new S2OClient();
    $this->assertAttributeInstanceOf('Communify\S2O\S2OFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Communify\S2O\S2OConnector', 'connector', $sut);
  }

  /**
  * dataProvider getLoginData
  */
  public function getLoginData()
  {
    return array(
      array(array('dummy' => 'value'), array('dummy' => 'value'), null, $this->any(), $this->any()),
      array(array('dummy' => 'value'), array('dummy' => 'value'), null, $this->once(), $this->any()),
      array(array('dummy' => 'value'), array('dummy' => 'value'), null, $this->any(), $this->once()),

      array(array('dummy' => 'value', 'communify_url' => 'dummy url'), array('dummy' => 'value'), 'dummy url', $this->any(), $this->any()),
      array(array('dummy' => 'value', 'communify_url' => 'dummy url'), array('dummy' => 'value'), 'dummy url', $this->once(), $this->any()),
      array(array('dummy' => 'value', 'communify_url' => 'dummy url'), array('dummy' => 'value'), 'dummy url', $this->any(), $this->once()),
    );
  }

  /**
  * method: login
  * when: called
  * with:
  * should: correct
   * @dataProvider getLoginData
  */
  public function test_login_called__correct($data, $expectedData, $url, $timesCredential, $timesLogin)
  {

    $ssid = 'dummy ssid';
    $info = array(
      'info'          => $expectedData,
      'communify_url' => $url
    );
    $expected = array('dummy expected value');

    $credential = $this->getMock('Communify\C2\C2Credential');
    $this->factory->expects($timesCredential)
      ->method('credential')
      ->with($ssid, $info)
      ->will($this->returnValue($credential));
    $this->connector->expects($timesLogin)
      ->method('login')
      ->with($credential)
      ->will($this->returnValue($expected));
    $actual = $this->sut->login($ssid, $data);
    $this->assertEquals($expected, $actual);
  }

}