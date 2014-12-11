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
   * @return S2OFactory
   */
  private function configureSut()
  {
    return new S2OFactory();
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OFactory::factory();
    $this->assertInstanceOf('Communify\S2O\S2OFactory', $actual);
  }

  /**
  * dataProvider getS2OMethodsData
  */
  public function getS2OMethodsData()
  {
    return array(
      array('connector', 'S2OConnector'),
      array('credential', 'S2OCredential'),
      array('response', 'S2OResponse'),
      array('metasArray', 'S2OMetasArray'),
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
    $actual = $this->configureSut()->$method();
    $this->assertInstanceOf('Communify\S2O\\'.$class, $actual);
  }

  /**
  * method: meta
  * when: called
  * with:
  * should: correct
  */
  public function test_meta_called__correct()
  {
    $actual = $this->configureSut()->meta('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\S2O\S2OMeta', $actual);
  }

  /**
  * method: httpClient
  * when: called
  * with:
  * should: correct
  */
  public function test_httpClient_called__correct()
  {
    $actual = $this->configureSut()->httpClient();
    $this->assertInstanceOf('Guzzle\Http\Client', $actual);
  }
  
}