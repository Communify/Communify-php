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
 * Class S2OFactory
 * @package Communify\S2O
 */
class S2OFactory
{

  /**
   * Create S2OFactory.
   *
   * @return S2OFactory
   */
  public static function factory()
  {
    return new S2OFactory();
  }

  /**
   * Create S2OConnector.
   *
   * @return S2OConnector
   */
  public function connector()
  {
    return S2OConnector::factory();
  }

  /**
   * Create S2OCredential.
   *
   * @return S2OCredential
   * @throws S2OException
   */
  public function credential()
  {
    return S2OCredential::factory();
  }

  /**
   * Create S2OResponse.
   *
   * @return S2OResponse
   */
  public function response()
  {
    return S2OResponse::factory();
  }

  /**
   * Create S2OMetasIterator.
   *
   * @return S2OMetasIterator
   */
  public function metasIterator()
  {
    return S2OMetasIterator::factory();
  }

  /**
   * Create S2OMeta.
   *
   * @param $name
   * @param $content
   * @return S2OResponse
   */
  public function meta($name, $content)
  {
    return S2OMeta::factory($name, $content);
  }

  /**
   * Create a Guzzle Http Client.
   *
   * @return Client
   */
  public function httpClient()
  {
    return new Client();
  }

}