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

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Credential;
use Guzzle\Http\Client;

/**
 * Class S2OConnector
 * @package Communify\S2O
 * @property S2OFactory $factory
 */
class S2OConnector extends C2AbstractConnector
{

  const SINGLE_SIGN_ON_API_METHOD = 'user/authentication/singleSignOnLogin';

  /**
   * Constructor with dependency injection.
   *
   * @param S2OFactory $factory
   * @param Client $client
   */
  function __construct(S2OFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }

    parent::__construct($factory, $client);
  }

  /**
   * Login method. Call to Communify server and generate a response.
   *
   * @param C2Credential $credential
   * @return S2OResponse
   */
  public function login(C2Credential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest('POST', $url.'/'.self::SINGLE_SIGN_ON_API_METHOD, null, $credential->get());
    $response = $this->client->send($request);

    $s2OResponse = $this->factory->response();
    $s2OResponse->set($response);
    return $s2OResponse;
  }

}