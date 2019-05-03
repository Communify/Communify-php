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

namespace Communify\BCLLS;

use Communify\C2\abstracts\C2AbstractClient;


class BCLLSClient extends C2AbstractClient
{

  const IMPRESSION_EVENT    = 'get_site';
  const CLICK_CTA_EVENT     = 'click_cta';
  const INTERACTION_EVENT   = 'interaction';
  const IMPRESSION          = 'impression';
  const CONNECTION          = 'connection';
  const SESSION             = 'session';
  const EMAIL_CLICK         = 'email_click';
  const EMAIL_OPEN          = 'email_open';
  const EMAIL_REDEMPTION    = 'email_redemption';
  const EMAIL_SEND          = 'email_send';

  /**
   * @var BCLLSConnector
   */
  protected $connector;

  /**
   * LGClient constructor.
   *
   * @param BCLLSFactory|null   $factory
   * @param BCLLSConnector|null $connector
   */
  function __construct(BCLLSFactory $factory = null, BCLLSConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = BCLLSConnector::factory();
    }

    if($factory == null)
    {
      $factory = BCLLSFactory::factory();
    }

    parent::__construct($factory, $connector);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return BCLLSResponse
   */
  public function getAPData($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getAPData($credential);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function registerEvent($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->registerEvent($credential);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getNumEvents($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getNumEvents($credential);
  }

  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getLastConnection($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->getLastConnection($credential);
  }


  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function registerAccessPoint($accountId, $data)
  {
    $credential = $this->factory->credential(self::WEB_SSID, $accountId, $data);
    return $this->connector->registerAccessPoint($credential);
  }


  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getLeadsBySiteAndLeadValue($accountId, $data)
  {
    $credential = $this->factory->credential(self::BACKOFFICE_SSID, $accountId, $data);
    return $this->connector->getLeadsBySiteAndLeadValue($credential);
  }


  /**
   * @param $accountId
   * @param $data
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function sendMail($accountId, $data)
  {
    $credential = $this->factory->credential(self::BACKOFFICE_SSID, $accountId, $data);
    return $this->connector->sendMail($credential);
  }

}