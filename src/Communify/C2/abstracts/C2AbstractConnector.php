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

use Communify\C2\interfaces\IC2Factory;
use Guzzle\Http\Client;

abstract class C2AbstractConnector extends C2AbstractFactorizable
{

  /**
   * @var IC2Factory
   */
  protected $factory;

  /**
   * @var \Guzzle\Http\Client
   */
  protected $client;

  /**
   * Constructor with dependency injection.
   *
   * @param IC2Factory $factory
   * @param Client $client
   */
  function __construct(IC2Factory $factory, Client $client = null)
  {
    if($client == null)
    {
      $client = $factory->httpClient();
    }
    $this->factory = $factory;
    $this->client = $client;
  }

}