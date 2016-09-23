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

namespace tests\Communify\SEO\parsers;


use Communify\SEO\engines\SEOLeadsEngine;
use Communify\SEO\parsers\SEOLeadsTopic;

/**
 * Class SEOLeadsTopicTest
 * @package tests\Communify\SEO\parsers
 */
class SEOLeadsTopicTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @var SEOLeadsTopic
   */
  private $sut;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $engine;


  public function setUp()
  {
    $this->engine = $this->getMock(SEOLeadsEngine::class);
    $this->sut = new SEOLeadsTopic($this->engine);
  }

  /**
  * dataProvider getCorrectData
  */
  public function getCorrectData()
  {
    return array(
      array($this->any()),
      array($this->once())
    );
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
   * @dataProvider getCorrectData
  */
  public function test_get_called__correct($timesRender)
  {
    $topic = [
      'dummy' => 'dummy',
      'json'  =>  [
        'json'  => ['dummy json array']
      ]
    ];
    $expectedArray = ['dummy json array'];
    $expectedResult = 'dummy html code';

    $this->engine->expects($timesRender)
      ->method('render')
      ->with($expectedArray)
      ->will($this->returnValue($expectedResult));

    $result = $this->sut->get($topic);
    $this->assertEquals($expectedResult, $result);
  }
}