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

use Communify\SEO\engines\SEOLeadsEngine;
use Communify\SEO\engines\helpers\TextHelper;
use Communify\SEO\engines\helpers\GmapsHelper;
use Communify\SEO\engines\helpers\ImageHelper;
use Communify\SEO\engines\helpers\FormHelper;
use Communify\SEO\SEOFactory;

class SEOLeadsEngineTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $mustache;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var SEOLeadsEngine
   */
  private $sut;


  /**
   *
   */
  public function setUp()
  {
    $this->mustache = $this->getMock(\Mustache_Engine::class);
    $this->factory = $this->getMock(SEOFactory::class);
    $this->sut = new SEOLeadsEngine($this->mustache, $this->factory);
  }

  /**
   * method: constructor
   * when: called
   * with:
   * should: correct
   */
  public function test_constructor_called__correct()
  {
    $sut = new SEOLeadsEngine();
    $this->assertAttributeInstanceOf(\Mustache_Engine::class, 'mustache', $sut);
    $this->assertAttributeInstanceOf(SEOFactory::class, 'factory', $sut);
  }

  /**
   * dataProvider getRenderData
   */
  public function getRenderData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
   * method: render
   * when: called
   * with:
   * should: correct
   * @dataProvider getRenderData
   */
  public function test_render_called__correct($timesTextToHTML, $timesGmapsToHTML, $timesImageToHTML, $timesFormToHTML)
  {
    $textHelper = $this->getMock(TextHelper::class);
    $gmapsHelper = $this->getMock(GmapsHelper::class);
    $formHelper = $this->getMock(FormHelper::class);
    $imageHelper = $this->getMock(ImageHelper::class);

    $array = [
      'pages' => [
        ['content' => [
           ['type' => 'text'],
           ['type' => 'gmaps']
          ]
        ],
        ['content' => [
          ['type' => 'dummy'],
          ['type' => 'image'],
          ['type' => 'form'],
          ]
        ]
      ]
    ];

    $expectedText = 'dummy text';
    $expectedGmaps = 'dummy gmaps';
    $expectedImage = 'dummyImage';
    $expectedForm = 'expected form';
    $expected = $expectedText.$expectedGmaps.$expectedImage.$expectedForm;
    $expectedWithNoScript = '<noscript>'.$expected.'</noscript>';


    $this->configureFactoryHelperCreation($this->at(0), '\Communify\SEO\engines\helpers\TextHelper', $textHelper);
    $this->configureToHTML($textHelper, $timesTextToHTML, ['type' => 'text'], $this->mustache, $expectedText);

    $this->configureFactoryHelperCreation($this->at(1), '\Communify\SEO\engines\helpers\GmapsHelper', $gmapsHelper);
    $this->configureToHTML($gmapsHelper, $timesGmapsToHTML, ['type' => 'gmaps'], $this->mustache, $expectedGmaps);

    $this->configureFactoryHelperCreation($this->at(2), '\Communify\SEO\engines\helpers\ImageHelper', $imageHelper);
    $this->configureToHTML($imageHelper, $timesImageToHTML, ['type' => 'image'], $this->mustache, $expectedImage);

    $this->configureFactoryHelperCreation($this->at(3), '\Communify\SEO\engines\helpers\FormHelper', $formHelper);
    $this->configureToHTML($formHelper, $timesFormToHTML, ['type' => 'form'], $this->mustache, $expectedForm);

    $actual = $this->sut->render($array);
    $this->assertEquals($expectedWithNoScript, $actual);
  }


  /**
   * @param $timesCreateHelper
   * @param $class
   * @param $helper
   */
  private function configureFactoryHelperCreation($timesCreateHelper, $class, $helper)
  {
    $this->factory->expects($timesCreateHelper)
      ->method('createHelper')
      ->with($class)
      ->will($this->returnValue($helper));
  }

  /**
   * @param $helper
   * @param $times
   * @param $content
   * @param $mustache
   * @param $result
   */
  private function configureToHTML($helper, $times, $content, $mustache, $result)
  {
    $helper->expects($times)
      ->method('toHTML')
      ->with($content, $mustache)
      ->will($this->returnValue($result));
  }

}