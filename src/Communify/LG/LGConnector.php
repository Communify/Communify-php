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
namespace Communify\LG;

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Credential;
use Guzzle\Http\Client;


class LGConnector extends C2AbstractConnector
{
  const LEAD_GENERATION_METHOD = 'user/authentication/generateLead';
  const GET_LEAD_INFO_METHOD = 'user/authentication/getLeadInfo';

  /**
   * Constructor with dependency injection.
   *
   * @param LGFactory $factory
   * @param Client $client
   */
  function __construct(LGFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = LGFactory::factory();
    }

    parent::__construct($factory, $client);
  }

  /**
   * @param C2Credential $credential
   * @return LGResponse
   */
  public function generateLead(C2Credential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest(self::POST_METHOD, $url.self::LEAD_GENERATION_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $leadGenerationResponse = $this->factory->response();
    $leadGenerationResponse->set($response);
    return $leadGenerationResponse;
  }

  /**
   * @param C2Credential $credential
   *
   * @return LGResponse
   */
  public function getLeadInfo(C2Credential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_LEAD_INFO_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $leadInfoResponse = $this->factory->response();
    $leadInfoResponse->set($response);
    return $leadInfoResponse;
  }
}