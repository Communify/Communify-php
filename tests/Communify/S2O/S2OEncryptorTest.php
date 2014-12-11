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

use Communify\S2O\S2OEncryptor;

/**
 * @covers Communify\S2O\S2OEncryptor
 */
class S2OEncryptorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var S2OEncryptor
   */
  private $sut;

  public function setUp()
  {
    $this->sut = S2OEncryptor::factory();
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OEncryptor::factory();
    $this->assertInstanceOf('Communify\S2O\S2OEncryptor', $actual);
  }

  /**
  * dataProvider getExecuteData
  */
  public function getExecuteData()
  {
    return array(
      array(true, 'dHJ1ZQ=='),
      array(123, 'MTIz'),
      array(array(1,2,3), 'WzEsMiwzXQ=='),
      array(array('dummy1' => 'value 1', 'dummy2' => 'value 2'), 'eyJkdW1teTEiOiJ2YWx1ZSAxIiwiZHVtbXkyIjoidmFsdWUgMiJ9'),
    );
  }

  /**
  * method: execute
  * when: called
  * with:
  * should: correct
   * @dataProvider getExecuteData
  */
  public function test_execute_called__correct($value, $expected)
  {
    $actual = $this->sut->execute($value);
    $this->assertSame($expected, $actual);
  }
  
}