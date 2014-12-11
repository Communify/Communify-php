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

use Communify\C2\C2MetasIterator;

/**
 * @covers Communify\C2\C2MetasIterator
 */
class C2MetasIteratorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var C2MetasIterator
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\C2\C2Factory');
    $this->sut = new C2MetasIterator($this->factory);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = C2MetasIterator::factory();
    $this->assertInstanceOf('Communify\C2\C2MetasIterator', $actual);
  }

  /**
  * dataProvider getPushData
  */
  public function getPushData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
  * method: push
  * when: called
  * with:
  * should: correct
   * @dataProvider getPushData
  */
  public function test_push_called__correct($times)
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $meta = $this->getMockBuilder('Communify\C2\C2Meta')->disableOriginalConstructor()->getMock();
    $this->factory->expects($times)
      ->method('meta')
      ->with($name, $content)
      ->will($this->returnValue($meta));
    $this->sut->push($name, $content);
    $this->assertEquals($this->sut->current(), $meta);
  }

  /**
  * method: rewindAndNext
  * when: called
  * with:
  * should: correct
  */
  public function test_rewindAndNext_called__correct()
  {
    $this->assertSame(0, $this->sut->key());
    $this->sut->next();
    $this->assertSame(1, $this->sut->key());
    $this->sut->rewind();
    $this->assertSame(0, $this->sut->key());
  }

  /**
  * method: valid
  * when: called
  * with: noElements
  * should: correct
  */
  public function test_valid_called_noElements_correct()
  {
    $this->assertSame(false, $this->sut->valid());
  }

  /**
  * method: valid
  * when: called
  * with: oneElement
  * should: correct
  */
  public function test_valid_called_oneElement_correct()
  {
    $this->sut->setArray(array('dummy array'));
    $this->assertSame(true, $this->sut->valid());
  }
  
}