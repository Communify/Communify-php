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

namespace tests\Communify\EAP;

use Communify\EAP\EAPClient;


/**
 * @covers Communify\EAP\EAPClient
 */
class EAPClientTest extends \PHPUnit_Framework_TestCase
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
   * @var EAPClient
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\EAP\EAPFactory');
    $this->connector = $this->getMock('Communify\EAP\EAPConnector');
    $this->sut = new EAPClient($this->factory, $this->connector);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultObjectAttrs
  */
  public function test_constructor_called_noParameters_defaultObjectAttrs()
  {
    $sut = new EAPClient();
    $this->assertAttributeInstanceOf('Communify\EAP\EAPFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Communify\EAP\EAPConnector', 'connector', $sut);
  }

  /**
  * dataProvider getSetOrderData
  */
  public function getSetOrderData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: setOrder
  * when: called
  * with:
  * should: correct
   * @dataProvider getSetOrderData
  */
  public function test_setOrder_called__correct($timesCredential, $timesSetOrder)
  {
    $accountId = 'dummy account id';
    $data = 'dummy data value';
    $expected = 'dummy expected value';
    $credential = $this->getMock('Communify\C2\C2Credential');
    $this->factory->expects($timesCredential)
      ->method('credential')
      ->with(EAPClient::WEB_SSID, $accountId, $data)
      ->will($this->returnValue($credential));
    $this->connector->expects($timesSetOrder)
      ->method('setOrder')
      ->with($credential)
      ->will($this->returnValue($expected));
    $actual = $this->sut->setOrder($accountId, $data);
    $this->assertEquals($expected, $actual);
  }

}