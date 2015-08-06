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

use Communify\C2\abstracts\C2AbstractConnector;
use Guzzle\Http\Client;

/**
 * Class C3Connector
 * @package Communify\C3
 * @property C3Factory $factory
 */
class C3Connector extends C2AbstractConnector
{

  const CHECK_NEW_ENVIRONMENT_API_METHOD  = 'environment/environment/checkEnvironmentAvailability';
  const CREATE_NEW_ENVIRONMENT_API_METHOD = 'environment/environment/createNewEnvironment';
  const UNINSTALL_PLATFORM_INTEGRATION    = 'backoffice/backoffice/uninstallIntegration';

  /**
   * Constructor with dependency injection.
   *
   * @param C3Factory $factory
   * @param Client $client
   */
  function __construct(C3Factory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = C3Factory::factory();
    }

    parent::__construct($factory, $client);
  }

}