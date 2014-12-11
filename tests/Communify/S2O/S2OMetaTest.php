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

namespace tests\Communify\S2O;

use Communify\S2O\S2OMeta;

/**
 * @covers Communify\S2O\S2OMeta
 */
class S2OMetaTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @param $name
   * @param $content
   * @return S2OMeta
   */
  private function configureSut($name, $content)
  {
    return new S2OMeta($name, $content);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OMeta::factory('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\S2O\S2OMeta', $actual);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: checkName
  */
  public function test_factory_called__checkName()
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $actual = S2OMeta::factory($name, $content);
    $this->assertEquals($name, $actual->getName());
  }

  /**
   * method: factory
   * when: called
   * with:
   * should: checkContent
   */
  public function test_factory_called__checkContent()
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $actual = S2OMeta::factory($name, $content);
    $this->assertEquals($content, $actual->getContent());
  }

  /**
  * method: getHtml
  * when: called
  * with:
  * should: correct
  */
  public function test_getHtml_called__correct()
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $expected = '<meta name="'.$name.'" content="'.$content.'">';
    $actual = $this->configureSut($name, $content)->getHtml();
    $this->assertEquals($expected, $actual);
  }
  
}