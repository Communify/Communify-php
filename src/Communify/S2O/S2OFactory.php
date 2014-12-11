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
   * @return S2OFactory
   */
  public static function factory()
  {
    return new S2OFactory();
  }

  /**
   * @return S2OConnector
   */
  public function connector()
  {
    return S2OConnector::factory();
  }

  /**
   * @return S2OCredential
   * @throws S2OException
   */
  public function credential()
  {
    return S2OCredential::factory();
  }

  /**
   * @return S2OResponse
   */
  public function response()
  {
    return S2OResponse::factory();
  }

  /**
   * @return S2OMetasArray
   */
  public function metasArray()
  {
    return S2OMetasArray::factory();
  }

  /**
   * @param $name
   * @param $content
   * @return S2OResponse
   */
  public function meta($name, $content)
  {
    return S2OMeta::factory($name, $content);
  }

  /**
   * @return Client
   */
  public function httpClient()
  {
    return new Client();
  }

}