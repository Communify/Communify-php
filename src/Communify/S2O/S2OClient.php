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

use Communify\C2\abstracts\C2AbstractClient;

/**
 * Class S2OClient
 * @package Communify\S2O
 * @method S2OClient static factory
 */
class S2OClient extends C2AbstractClient
{

  /**
   * Call without params on production purposes. Use factory static method.
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

    parent::__construct($factory, $connector);
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
    $url = null;
    if(isset($data['communify_url']))
    {
      $url = $data['communify_url'];
      unset($data['communify_url']);
    }

    $info = array(
      'info'  => $data,
      'communify_url' => $url
    );
    $credential = $this->factory->credential($ssid, $info);
    return $this->connector->login($credential);
  }

} 