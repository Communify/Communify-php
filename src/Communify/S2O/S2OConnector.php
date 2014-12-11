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

use Guzzle\Http\Client;

/**
 * Class S2OConnector
 * @package Communify\S2O
 */
class S2OConnector
{

  const SINGLE_SIGN_ON_API_METHOD = 'user/authentication/singleSignOnLogin';

  /**
   * @var S2OFactory
   */
  private $factory;

  /**
   * @var \Guzzle\Http\Client
   */
  private $client;

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
    if($client == null)
    {
      $client = $factory->httpClient();
    }
    $this->factory = $factory;
    $this->client = $client;
  }

  /**
   * Create a S2OConnector.
   *
   * @return S2OConnector
   */
  public static function factory()
  {
    return new S2OConnector();
  }

  /**
   * Login method. Call to Communify server and generate a response.
   *
   * @param S2OCredential $credential
   * @return S2OResponse
   */
  public function login(S2OCredential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest('POST', $url.'/'.self::SINGLE_SIGN_ON_API_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $s2OResponse = $this->factory->response();
    $s2OResponse->set($response);
    return $s2OResponse;
  }

}