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

use Communify\SEO\engines\SEOEnrichedEngine;

/**
 * Class SEOEnrichedEngineTest
 * @package tests\Communify\SEO
 */
class SEOEnrichedEngineTest  extends \PHPUnit_Framework_TestCase
{
  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $mustache;

  /**
   * @var SEOEnrichedEngine
   */
  private $sut;

  public function setUp()
  {
    $this->mustache = $this->getMock(\Mustache_Engine::class);
    $this->sut = new SEOEnrichedEngine($this->mustache);
  }

  /**
   * method: constructor
   * when: called
   * with:
   * should: correct
   */
  public function test_constructor_called__correct()
  {
    $sut = new SEOEnrichedEngine();
    $this->assertAttributeInstanceOf(\Mustache_Engine::class, 'mustache', $sut);
  }

  /**
   * dataProvider getRenderData
   */
  public function getRenderData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
   * method: render
   * when: called
   * with:
   * should: correct
   * @dataProvider getRenderData
   */
  public function test_render_called__correct($timesRender)
  {
    $link = 'dummy link';
    $topic = [
      'dummy'   =>  'dummy value',
      'cta_link'=>  $link
    ];

    $renderArray = [
      'enriched_link' => $link
    ];
    $expected = 'dummy expected';
    $expectedWithNoScript = '<noscript>dummy expected</noscript>';

    $template = file_get_contents(dirname(__FILE__).'/../../../../src/Communify/SEO/html/enriched_template.html');

    $this->mustache->expects($timesRender)
      ->method('render')
      ->with($template, $renderArray)
      ->will($this->returnValue($expected));

    $actual = $this->sut->render($topic);
    $this->assertEquals($expectedWithNoScript, $actual);
  }

}