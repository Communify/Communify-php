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
namespace tests\Communify\C2\abstracts;

use Communify\C2\abstracts\C2AbstractClient;
use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Factory;

class DummyClient extends C2AbstractClient
{

}

class DummyConnectorForTesting extends C2AbstractConnector
{

}

/**
 * @covers \Communify\C2\abstracts\C2AbstractResponse
 */
class C2AbstractClientTest extends \PHPUnit_Framework_TestCase
{

  /**
  * method: constructor
  * when: called
  * with:
  * should: correct
  */
  public function test_constructor_called__correct()
  {
    $factory = $this->getMock('Communify\C2\C2Factory');
    $connector = $this->getMockBuilder('tests\Communify\C2\abstracts\DummyConnectorForTesting')->disableOriginalConstructor()->getMock();

    $sut = new DummyClient($factory, $connector);
    $this->assertAttributeEquals($factory, 'factory', $sut);
    $this->assertAttributeEquals($connector, 'connector', $sut);
  }

}