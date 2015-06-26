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

use Communify\EAP\EAPFactory;

/**
 * @covers Communify\S2O\S2OFactory
 */
class EAPFactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var EAPFactory
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new EAPFactory();
  }

  /**
  * dataProvider getAllMethodsData
  */
  public function getAllMethodsData()
  {
    return array(
      array('connector', 'Communify\EAP\EAPConnector'),
      array('response', 'Communify\EAP\EAPResponse')
    );
  }

  /**
  * method: allMethods
  * when: called
  * with:
  * should: correctReturn
   * @dataProvider getAllMethodsData
  */
  public function test_allMethods_called__correctReturn($method, $class)
  {
    $actual = $this->sut->$method();
    $this->assertInstanceOf($class, $actual);
  }

}