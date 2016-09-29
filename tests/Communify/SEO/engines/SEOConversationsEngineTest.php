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

use Communify\SEO\engines\SEOConversationsEngine;

/**
 * @covers Communify\SEO\SEOEngine
 */
class SEOConversationsEngineTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $mustache;

  /**
   * @var SEOConversationsEngine
   */
  private $sut;

  public function setUp()
  {
    $this->mustache = $this->getMock(\Mustache_Engine::class);
    $this->sut = new SEOConversationsEngine($this->mustache);
  }

  /**
  * method: constructor
  * when: called
  * with:
  * should: correct
  */
  public function test_constructor_called__correct()
  {
    $sut = new SEOConversationsEngine();
    $this->assertAttributeInstanceOf(\Mustache_Engine::class, 'mustache', $sut);
  }

  /**
  * dataProvider getRenderData
  */
  public function getRenderData()
  {
    return array(
      array('en'),
      array('es'),
      array('cat'),
    );
  }

  /**
  * method: render
  * when: called
  * with:
  * should: correct
   * @dataProvider getRenderData
  */
  public function test_render_called__correct($lang)
  {
    $html = 'dummy html';
    $expected = 'dummy expected';
    $context = array('dummy'  => 'value', 'language' => $lang);
    $lang = include(dirname(__FILE__).'/../../../../src/Communify/SEO/lang/'.$lang.'.php');
    $contextLang = array_merge($lang, $context);
    $template = file_get_contents(dirname(__FILE__).'/../../../../src/Communify/SEO/html/template.html');
    $this->configureRender($this->at(0), $template, $contextLang, $html);
    $this->configureRender($this->at(1), $html, $context, $expected);
    $actual = $this->sut->render($context);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $times1
   * @param $template
   * @param $context
   * @param $html
   */
  protected function configureRender($times1, $template, $context, $html)
  {
    $this->mustache->expects($times1)
      ->method('render')
      ->with($template, $context)
      ->will($this->returnValue($html));
  }


}