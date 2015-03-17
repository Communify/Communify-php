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

use Communify\C2\abstracts\C2AbstractFactory;

class DummyFactory extends C2AbstractFactory
{
  public function connector(){}
  public function response(){}
  public function credential($ssid, $data){}
}

/**
 * @covers \Communify\C2\abstracts\C2AbstractFactory
 */
class C2AbstractFactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
  * method: httpClient
  * when: called
  * with:
  * should: correct
  */
  public function test_httpClient_called__correct()
  {
    $sut = new DummyFactory();
    $actual = $sut->httpClient();
    $this->assertEquals(get_class($actual), 'Guzzle\Http\Client');
  }

}