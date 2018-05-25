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

use Communify\C2\abstracts\C2AbstractClient;


class LGClient extends C2AbstractClient
{

  /**
   * LGClient constructor.
   *
   * @param LGFactory|null   $factory
   * @param LGConnector|null $connector
   */
  function __construct(LGFactory $factory = null, LGConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = LGConnector::factory();
    }

    if($factory == null)
    {
      $factory = LGFactory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * @param $accountId
   * @param $data
   * @return mixed
   */
  public function generateLead($accountId, $data)
  {
    $paramsToJson = [
      'Client_ip' => $this->getPublicClientIP()
    ];

    $data['json'] = $this->addParamsToJson($data['json'], $paramsToJson);
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->generateLead($credential);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return mixed
   */
  public function getLeadInfo($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getLeadInfo($credential);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return mixed
   */
  public function getUserInfo($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getUserInfo($credential);
  }

  /**
   * @return mixed
   */
  private function getPublicClientIP()
  {
    $publicClientIP = $_SERVER['HTTP_CLIENT_IP'];

    if($this->checkPublicClientIP($publicClientIP))
    {
      $publicClientIP = $_SERVER['REMOTE_ADDR'];
    }

    if($this->checkPublicClientIP($publicClientIP))
    {
      $publicClientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $publicClientIP;
  }

  /**
   * @param $dataJson
   * @param $params
   *
   * @return string
   */
  private function addParamsToJson($dataJson, $params)
  {
    if(!empty($dataJson) && $dataJson != null)
    {
      $dataJson = json_decode($dataJson, true);
    }

    foreach($params as $key => $param)
    {
      $dataJson[$key] = $param;
    }

    return json_encode($dataJson, JSON_UNESCAPED_UNICODE);
  }

  /**
   * @param $publicClientIP
   *
   * @return bool
   */
  private function checkPublicClientIP($publicClientIP)
  {
    $return = true;

    if(empty($publicClientIP) || $publicClientIP == false || $publicClientIP == null)
    {
      $publicClientIP = false;
    }

    return $return;
  }
}