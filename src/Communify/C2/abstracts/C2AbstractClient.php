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
namespace Communify\C2\abstracts;

use Communify\C2\C2Factory;
use Communify\C2\interfaces\IC2Factory;

/**
 * Class C2AbstractClient
 * @package Communify\C2\abstracts
 */
abstract class C2AbstractClient extends C2AbstractFactorizable
{

  const ENV_SSID = 'x5dc03571714zwtkbn8c09r29h19ac11';
  const WEB_SSID = '0e54f6bb4c0be6dc9c492b52b4748272';
  const BACKOFFICE_SSID = 'b52b0e9c492454f6bb4c0be68272dc74';

  /**
   * @var C2AbstractConnector
   */
  protected $connector;

  /**
   * @var C2Factory
   */
  protected $factory;

  /**
   * @param IC2Factory $factory
   * @param C2AbstractConnector $connector
   */
  function __construct(IC2Factory $factory, C2AbstractConnector $connector)
  {
    $this->factory = $factory;
    $this->connector = $connector;
  }

}