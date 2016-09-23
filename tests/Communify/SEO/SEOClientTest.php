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
use Communify\SEO\SEOFactory;
use Communify\SEO\SEOConnector;
use Communify\C2\C2Credential;

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
    $this->factory = $this->getMock(SEOFactory::class);
    $this->connector = $this->getMock(SEOConnector::class);
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
    $this->assertAttributeInstanceOf(SEOFactory::class, 'factory', $sut);
    $this->assertAttributeInstanceOf(SEOConnector::class, 'connector', $sut);
  }

  /**
  * dataProvider getWidgetData
  */
  public function getWidgetData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: widget
  * when: called
  * with:
  * should: correct
   * @dataProvider getWidgetData
  */
  public function test_widget_called__correct($timesCredential, $timesGetSite)
  {
    $_SERVER['HTTP_HOST'] = 'dummy host';
    $_SERVER['REQUEST_URI'] = 'dummy uri';

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $accountId = 'dummy account id';
    $expected = 'dummy expected value';
    $data = array('content_id' => 'dummy');
    $expectedData = array('content_id' => 'dummy', 'url' => $url);
    $credential = $this->getMock(C2Credential::class);

    $this->factory->expects($timesCredential)
      ->method('credential')
      ->with(SEOClient::WEB_SSID, $accountId, $expectedData)
      ->will($this->returnValue($credential));

    $this->connector->expects($timesGetSite)
      ->method('getTopicInfo')
      ->with($credential)
      ->will($this->returnValue($expected));

    $actual = $this->sut->widget($accountId, $data);
    $this->assertEquals($expected, $actual);
  }

}