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

namespace Communify\C3;

use Communify\C2\abstracts\C2AbstractClient;
use Communify\C2\C2Exception;

/**
 * Class C3Client
 * @package Communify\C3
 * @property C3Factory $factory
 */
class C3Client extends C2AbstractClient
{

  const CREATE_NEW_INSTANCE_ERROR_MSG   = 'C3 Error: Can\'t create this community.';
  const CREATE_NEW_INSTANCE_ERROR_CODE  = 104;

  /**
   * Call without params on production purposes. Use factory static method.
   *
   * @param C3Factory $factory
   * @param C3Connector $connector
   */
  function __construct(C3Factory $factory = null, C3Connector $connector = null)
  {
    if($connector == null)
    {
      $connector = C3Connector::factory();
    }

    if($factory == null)
    {
      $factory = C3Factory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * @param $accountId
   * @param $data
   * @return C3Response
   * @throws C2Exception
   */
  public function createNewInstance($accountId, $data)
  {
    $credential = $this->factory->credential(self::ENV_SSID, $accountId, $data);

    /** @var C3Response $checkResponse */
    $checkResponse = $this->connector->call(C3Connector::POST_METHOD, C3Connector::CHECK_NEW_ENVIRONMENT_API_METHOD, $credential, $this->factory);
    if(!$checkResponse->getValue())
    {
      throw new C2Exception(self::CREATE_NEW_INSTANCE_ERROR_MSG, self::CREATE_NEW_INSTANCE_ERROR_CODE);
    }

    return $this->connector->call(C3Connector::POST_METHOD, C3Connector::CREATE_NEW_ENVIRONMENT_API_METHOD, $credential, $this->factory);
  }

} 