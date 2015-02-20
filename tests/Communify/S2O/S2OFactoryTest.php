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

use Communify\S2O\S2OFactory;

/**
 * @covers Communify\S2O\S2OFactory
 */
class S2OFactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var S2OFactory
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new S2OFactory();
  }

  /**
  * dataProvider getS2OMethodsData
  */
  public function getS2OMethodsData()
  {
    return array(
      array('connector', 'S2OConnector'),
      array('response', 'S2OResponse'),
    );
  }

  /**
  * method: s2OMethods
  * when: called
  * with:
  * should: correctReturn
   * @dataProvider getS2OMethodsData
  */
  public function test_s2OMethods_called__correctReturn($method, $class)
  {
    $actual = $this->sut->$method();
    $this->assertInstanceOf('Communify\S2O\\'.$class, $actual);
  }

  /**
  * method: httpClient
  * when: called
  * with:
  * should: correct
  */
  public function test_httpClient_called__correct()
  {
    $actual = $this->sut->httpClient();
    $this->assertInstanceOf('Guzzle\Http\Client', $actual);
  }
  
}