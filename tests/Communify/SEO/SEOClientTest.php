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

namespace tests\Communify\SEO;

use Communify\SEO\SEOClient;

/**
 * @covers Communify\SEO\SEOClient
 */
class SEOClientTest extends \PHPUnit_Framework_TestCase
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
   * @var SEOClient
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\SEO\SEOFactory');
    $this->connector = $this->getMock('Communify\SEO\SEOConnector');
    $this->sut = new SEOClient($this->factory, $this->connector);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultObjectAttrs
  */
  public function test_constructor_called_noParameters_defaultObjectAttrs()
  {
    $sut = new SEOClient();
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Communify\SEO\SEOConnector', 'connector', $sut);
  }

  /**
  * dataProvider getWidgetData
  */
  public function getWidgetData()
  {
    return array(
      array($this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: widget
  * when: called
  * with:
  * should: correct
   * @dataProvider getWidgetData
  */
  public function test_widget_called__correct($timesCredential, $timesSet, $timesGetSite)
  {
    $_SERVER['HTTP_HOST'] = 'dummy host';
    $_SERVER['REQUEST_URI'] = 'dummy uri';

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ssid = 'dummy ssid';
    $expected = 'dummy expected value';
    $data = array('dummy' => 'value');
    $expectedData = array('dummy' => 'value', 'url' => $url);
    $credential = $this->getMock('Communify\C2\C2Credential');

    $this->factory->expects($timesCredential)
      ->method('credential')
      ->will($this->returnValue($credential));
    $credential->expects($timesSet)
      ->method('set')
      ->with($ssid, $expectedData);
    $this->connector->expects($timesGetSite)
      ->method('getTopicInfo')
      ->with($credential)
      ->will($this->returnValue($expected));
    $actual = $this->sut->widget($ssid, $data);
    $this->assertEquals($expected, $actual);
  }

}