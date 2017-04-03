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

namespace Communify\BCLLS;

use Communify\C2\abstracts\C2AbstractClient;


class BCLLSClient extends C2AbstractClient
{

  /**
   * LGClient constructor.
   *
   * @param BCLLSFactory|null   $factory
   * @param BCLLSConnector|null $connector
   */
  function __construct(BCLLSFactory $factory = null, BCLLSConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = BCLLSConnector::factory();
    }

    if($factory == null)
    {
      $factory = BCLLSFactory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * @param $accountId
   * @param $data
   * @return mixed
   */
  public function getAPData($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getAPData($credential);
  }

}