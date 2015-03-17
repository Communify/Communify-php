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

namespace tests\Communify\C3;
use Communify\C3\C3Factory;

/**
 * @covers Communify\C3\C3Factory
 */
class C3FactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Communify\C3\C3Factory
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new C3Factory();
  }

  /**
  * dataProvider getMethodData
  */
  public function getMethodData()
  {
    return array(
      array('connector', 'Communify\C3\C3Connector'),
      array('response', 'Communify\C3\C3Response'),
    );
  }

  /**
  * method: method
  * when: called
  * with:
  * should: correct
   * @dataProvider getMethodData
  */
  public function test_method_called__correct($method, $class)
  {
    $actual = $this->sut->$method();
    $this->assertInstanceOf($class, $actual);
  }

}