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

/**
 * Class S2OCredential
 * @package Communify\S2O
 */
class S2OCredential
{

  /**
   * @var array
   */
  private $data;

  /**
   * @var string
   */
  private $url;

  function __construct()
  {
    $this->url = 'https://communify.com/api';
  }


  /**
   * @return S2OCredential
   */
  public static function factory()
  {
    return new S2OCredential();
  }

  /**
   * @param array $data
   * @throws S2OException
   */
  public function set($ssid, $data)
  {
    if( isset($data['communify_url']) )
    {
      $this->url = $data['communify_url'];
      unset($data['communify_url']);
    }
    $this->data = array(
      'ssid'  => $ssid,
      'info'  => $data
    );
  }

  /**
   * @return string
   */
  public function get()
  {
    return json_encode($this->data);
  }

  /**
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }

}