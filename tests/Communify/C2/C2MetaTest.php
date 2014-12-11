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

namespace tests\Communify\C2;

use Communify\C2\C2Meta;

/**
 * @covers Communify\C2\C2Meta
 */
class C2MetaTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @param $name
   * @param $content
   * @return C2Meta
   */
  private function configureSut($name, $content)
  {
    return new C2Meta($name, $content);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = C2Meta::factory('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\C2\C2Meta', $actual);
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
    $actual = C2Meta::factory($name, $content);
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
    $actual = C2Meta::factory($name, $content);
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