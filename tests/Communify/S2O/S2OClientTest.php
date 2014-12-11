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
   * method: factory
   * when: called
   * with: noDependencyInjection
   * should: correctReturn
   */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OClient::factory();
    $this->assertInstanceOf('Communify\S2O\S2OClient', $actual);
  }

  /**
  * dataProvider getLoginData
  */
  public function getLoginData()
  {
    return array(
      array($this->once(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: login
  * when: called
  * with:
  * should: correctInnerCalls
   * @dataProvider getLoginData
  */
  public function test_login_called__correctInnerCalls($timesCreate, $timesSet, $timesLogin)
  {
    $this->configureAndExecuteLogin($timesCreate, $timesSet, $timesLogin, 'dummy expected response');
  }

  /**
   * method: login
   * when: called
   * with:
   * should: correctReturn
   */
  public function test_login_called__correctReturn()
  {
    $expected = 'dummy expected response';
    $actual = $this->configureAndExecuteLogin($this->any(), $this->any(), $this->any(), $expected);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $timesCreate
   * @param $timesSet
   * @param $timesLogin
   * @param $expected
   * @return \Communify\S2O\S2OResponse
   */
  private function configureAndExecuteLogin($timesCreate, $timesSet, $timesLogin, $expected)
  {
    $ssid = 'dummy ssid';
    $data = array('dummy data');
    $credential = $this->getMock('Communify\S2O\S2OCredential');


    $this->factory->expects($timesCreate)
      ->method('credential')
      ->will($this->returnValue($credential));

    $credential->expects($timesSet)
      ->method('set')
      ->with($ssid, $data);

    $this->connector->expects($timesLogin)
      ->method('login')
      ->with($credential)
      ->will($this->returnValue($expected));

    return $this->sut->login($ssid, $data);
  }

}