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

use Communify\C2\abstracts\C2AbstractConnector;
use Communify\C2\C2Credential;
use Guzzle\Http\Client;


class BCLLSConnector extends C2AbstractConnector
{
  const GET_AP_DATA_METHOD  = 'user/public/getAPData';
  const REGISTER_EVENT_METHOD = 'user/public/registerEvent';
  const GET_NUM_EVENTS_METHOD = 'user/public/getNumEvents';
  const GET_LAST_CONNECTION_METHOD = 'user/public/getLastConnection';
  const REGISTER_ACCESS_POINT = 'user/public/setAccessPoint';
  const GET_LEAD_BY_SITE_AND_LEAD_VALUE = 'backoffice/beecells/getLeadsBySiteAndLeadValue';
  const SEND_MAIL = 'backoffice/beecells/sendMail';
  const GET_LEADS_BY_CUSTOM_FILTERS = 'backoffice/beecells/getLeadsByCustomFilters';

  /**
   * Constructor with dependency injection.
   *
   * @param BCLLSFactory $factory
   * @param Client $client
   */
  function __construct(BCLLSFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = BCLLSFactory::factory();
    }

    parent::__construct($factory, $client);
  }

  /**
   * @param C2Credential $credential
   * @return BCLLSResponse
   */
  public function getAPData(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_AP_DATA_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $APDataResponse = $this->factory->response();
    $APDataResponse->set($response);
    return $APDataResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function registerEvent(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::REGISTER_EVENT_METHOD, null, $credential->get());
    $response = $this->client->send($request);

    $registerEventResponse = $this->factory->response();
    $registerEventResponse->set($response);

    return $registerEventResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getNumEvents(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_NUM_EVENTS_METHOD, null, $credential->get());
    $response = $this->client->send($request);

    $registerEventResponse = $this->factory->response();
    $registerEventResponse->set($response);

    return $registerEventResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getLastConnection(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_LAST_CONNECTION_METHOD, null, $credential->get());
    $response = $this->client->send($request);

    $registerEventResponse = $this->factory->response();
    $registerEventResponse->set($response);

    return $registerEventResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function registerAccessPoint(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::REGISTER_ACCESS_POINT, null, $credential->get());
    $response = $this->client->send($request);

    $registerEventResponse = $this->factory->response();
    $registerEventResponse->set($response);

    return $registerEventResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getLeadsBySiteAndLeadValue(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_LEAD_BY_SITE_AND_LEAD_VALUE, null, $credential->get());
    $response = $this->client->send($request);

    $registerEventResponse = $this->factory->response();
    $registerEventResponse->set($response);

    return $registerEventResponse;
  }


  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function sendMail(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::SEND_MAIL, null, $credential->get());
    $response = $this->client->send($request);

    $sendMail = $this->factory->response();
    $sendMail->set($response);

    return $sendMail;
  }

  /**
   * @param C2Credential $credential
   *
   * @return \Communify\C2\interfaces\IC2Response
   */
  public function getLeadsByCustomFilters(C2Credential $credential)
  {
    $url = $credential->getUrl();

    $request = $this->client->createRequest(self::POST_METHOD, $url.self::GET_LEADS_BY_CUSTOM_FILTERS, null, $credential->get());
    $response = $this->client->send($request);

    $leadsByCustomFilters = $this->factory->response();
    $leadsByCustomFilters->set($response);

    return $leadsByCustomFilters;
  }
}