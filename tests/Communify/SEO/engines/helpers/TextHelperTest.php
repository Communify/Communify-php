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

namespace tests\Communify\SE\engines\helpers;

use Communify\SEO\engines\helpers\TextHelper;


class TextHelperTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var TextHelper
   */
  private $sut;

  /**
   *
   */
  public function setUp()
  {
    $this->sut = new TextHelper();
  }


  /**
  * dataProvider getToHTMLCorrectData
  */
  public function getToHTMLCorrectData()
  {
    return array(
      array($this->any()),
      array($this->once())
    );
  }

  /**
  * method: toHTML
  * when: called
  * with:
  * should: correct
   * @dataProvider getToHTMLCorrectData
  */
  public function test_toHTML_called__correct($timesRenderHTML)
  {
    $mustacheEngine = $this->getMock(\Mustache_Engine::class);
    $elementsArray = ['attrs' => [
      'class'         => 'dummy',
      'styles'        => 'dummy',
      'customStyles'  => 'dummy',
      'value'         => 'dummy',
      'type'          => 'dummy'
    ]];

    $expected = 'dummy html code';

    $mustacheEngine->expects($timesRenderHTML)
      ->method('render')
      ->will($this->returnValue($expected));

    $result = $this->sut->toHTML($elementsArray, $mustacheEngine);
    $this->assertEquals($expected, $result);

  }
}