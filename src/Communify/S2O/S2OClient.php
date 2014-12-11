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

namespace Communify\S2O;

/**
 * Class S2OClient
 * @package Communify\S2O
 */
class S2OClient
{

  /**
   * @var S2OConnector
   */
  private $connector;

  /**
   * @var S2OFactory
   */
  private $factory;


  /**
   * Call without params on production purposes. Can use factory static method.
   *
   * @param S2OFactory $factory
   * @param S2OConnector $connector
   */
  function __construct(S2OFactory $factory = null, S2OConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = S2OConnector::factory();
    }

    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }

    $this->factory = $factory;
    $this->connector = $connector;
  }

  /**
   * Create a S2OClient.
   *
   * @return S2OClient
   */
  public static function factory()
  {
    return new S2OClient();
  }

  /**
   * Makes single sign on possible.
   *
   * @param $ssid
   * @param $data
   * @return S2OResponse
   */
  public function login($ssid, $data)
  {
    $credential = $this->factory->credential();
    $credential->set($ssid, $data);
    return $this->connector->login($credential);
  }


} 