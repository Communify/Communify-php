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

use Communify\C2\abstracts\C2AbstractClient;

/**
 * Class EAPClient
 * @package Communify\EAP
 */
class EAPClient extends C2AbstractClient
{

  /**
   *
   * @param EAPFactory $factory
   * @param EAPConnector $connector
   */
  function __construct(EAPFactory $factory = null, EAPConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = EAPConnector::factory();
    }

    if($factory == null)
    {
      $factory = EAPFactory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * @param $ssid
   * @param $data
   * @return mixed
   */
  public function setOrder($ssid, $data)
  {
    $credential = $this->factory->credential($ssid, $data);
    return $this->connector->setOrder($credential);
  }

} 