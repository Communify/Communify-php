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
use Communify\C3\C3Connector;

/**
 * @covers Communify\C3\C3Connector
 */
class C3ConnectorTest extends \PHPUnit_Framework_TestCase
{

  /**
  * method: constructor
  * when: called
  * with: noInjection
  * should: correct
  */
  public function test_constructor_called_noInjection_correct()
  {
    $sut = new C3Connector();
    $this->assertAttributeInstanceOf('Communify\C3\C3Factory', 'factory', $sut);
    $this->assertAttributeInstanceOf('Guzzle\Http\Client', 'client', $sut);
  }

}