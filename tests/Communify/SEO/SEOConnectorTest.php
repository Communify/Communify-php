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

use Communify\SEO\SEOConnector;

/**
 * @covers Communify\SEO\SEOConnector
 */
class SEOConnectorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $client;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var SEOConnector
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\SEO\SEOFactory');
    $this->client = $this->getMock('Guzzle\Http\Client');
    $this->sut = new SEOConnector($this->factory, $this->client);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultObjectAttrs
  */
  public function test_constructor_called_noParameters_defaultObjectAttrs()
  {
    $sut = new SEOConnector();
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Guzzle\Http\Client', 'client', $sut);
  }
  
  /**
  * dataProvider getTopicInfoData
  */
  public function getTopicInfoData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }
  
  /**
  * method: getTopicInfo
  * when: called
  * with:
  * should: correct
   * @dataProvider getTopicInfoData
  */
  public function test_getTopicInfo_called__correct($timesGetUrl, $timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet)
  {
    $url = 'dummy url';
    $expectedData = 'dummy expected data';
    $request = 'dummy request';
    $credential = $this->getMock('Communify\C2\C2Credential');
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $seoResponse = $this->getMock('Communify\SEO\SEOResponse');

    $credential->expects($timesGetUrl)
      ->method('getUrl')
      ->will($this->returnValue($url));

    $credential->expects($timesGet)
      ->method('get')
      ->will($this->returnValue($expectedData));

    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with(SEOConnector::POST_METHOD, $url.'/'.SEOConnector::GET_SITE_INFO_API_METHOD, null, $expectedData)
      ->will($this->returnValue($request));

    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));

    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($seoResponse));

    $seoResponse->expects($timesSet)
      ->method('set')
      ->with($response);

    $actual = $this->sut->getTopicInfo($credential);

    $this->assertEquals($seoResponse, $actual);
  }

}