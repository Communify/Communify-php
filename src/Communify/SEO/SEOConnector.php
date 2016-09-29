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

namespace Communify\SEO;

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Credential;
use Guzzle\Http\Client;

/**
 * Class SEOConnector
 * @package Communify\SEO
 */
class SEOConnector extends C2AbstractConnector
{

  const GET_SITE_API_METHOD = 'user/public/getCfyInfo';

  /**
   * Constructor with dependency injection.
   *
   * @param SEOFactory $factory
   * @param Client $client
   */
  function __construct(SEOFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = SEOFactory::factory();
    }

    parent::__construct($factory, $client);
  }

  /**
   * Get all topic information to return a SEOResponse.
   *
   * @param C2Credential $credential
   * @return SEOResponse
   */
  public function getTopicInfo(C2Credential $credential)
  {
    $url = $credential->getUrl();
    $request = $this->client->createRequest(self::POST_METHOD, $url.'/'.self::GET_SITE_API_METHOD, null, $credential->get());
    $response = $this->client->send($request);

    /** @var SEOResponse $seoResponse */
    $seoResponse = $this->factory->response();
    return  $seoResponse->set($response);
  }

}