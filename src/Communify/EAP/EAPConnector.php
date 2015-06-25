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

namespace Communify\EAP;

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Credential;
use Guzzle\Http\Client;


class EAPConnector extends C2AbstractConnector
{

  const SET_NEW_ORDER_API_METHOD = 'user/public/setNewOrder';

  /**
   * Constructor with dependency injection.
   *
   * @param EAPFactory $factory
   * @param Client $client
   */
  function __construct(EAPFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = EAPFactory::factory();
    }

    parent::__construct($factory, $client);
  }

  /**
   * @param C2Credential $credential
   * @return EAPResponse
   */
  public function setOrder(C2Credential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest(self::POST_METHOD, $url.'/'.self::SET_NEW_ORDER_API_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $eapResponse = $this->factory->response();
    $eapResponse->set($response);
    return $eapResponse;
  }

}