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

use Communify\C2\abstracts\C2AbstractClient;

/**
 * Class SEOClient
 *
 * @package Communify\SEO
 * @method SEOClient static factory
 */
class SEOClient extends C2AbstractClient
{

  /**
   * Call without params on production purposes. Use factory static method.
   *
   * @param SEOFactory $factory
   * @param SEOConnector $connector
   */
  function __construct(SEOFactory $factory = null, SEOConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = SEOConnector::factory();
    }

    if($factory == null)
    {
      $factory = SEOFactory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * Get widget information to improve SEO with Communify.
   *
   * @param $ssid
   * @param $data
   * @return SEOResponse
   */
  public function widget($ssid, $data)
  {
    $data['url']  = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $credential = $this->factory->credential($ssid, $data);
    return $this->connector->getTopicInfo($credential);
  }

}