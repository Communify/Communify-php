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

use Communify\EAP\EAPConnector;

/**
 * @covers Communify\S2O\S2OConnector
 */
class EAPConnectorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $client;

  /**
   * @var EAPConnector
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\EAP\EAPFactory');
    $this->client = $this->getMock('Guzzle\Http\Client');
    $this->sut = new EAPConnector($this->factory, $this->client);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultAttrObjects
  */
  public function test_constructor_called_noParameters_defaultAttrObjects()
  {
    $sut = new EAPConnector();
    $this->assertAttributeInstanceOf('Communify\EAP\EAPFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Guzzle\Http\Client', 'client', $sut);
  }

  /**
  * dataProvider getSetOrderData
  */
  public function getSetOrderData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: setOrder
  * when: called
  * with:
  * should: correct
   * @dataProvider getSetOrderData
  */
  public function test_setOrder_called__correct($timesGetUrl, $timesCreateRequest, $timesSend, $timesResponse, $timesSet)
  {
    $url = 'dummy url';
    $request = 'dummy request';
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $credential = $this->getMock('Communify\C2\C2Credential');
    $eapResponse = $this->getMock('Communify\EAP\EAPResponse');

    $credential->expects($timesGetUrl)
      ->method('getUrl')
      ->will($this->returnValue($url));
    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with()
      ->will($this->returnValue($request));
    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));
    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($eapResponse));
    $eapResponse->expects($timesSet)
      ->method('set')
      ->with($response);
    $actual = $this->sut->setOrder($credential);
    $this->assertEquals($eapResponse, $actual);
  }

}