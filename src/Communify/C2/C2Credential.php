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

namespace Communify\C2;
use Communify\C2\abstracts\C2AbstractFactorizable;

/**
 * Class C2Credential
 * @package Communify\C2
 */
class C2Credential extends C2AbstractFactorizable
{

  /**
   * @var array
   */
  private $data;

  /**
   * @var string
   */
  private $url;

  /**
   * Init url with production server. To test on develop add communify_url option.
   */
  function __construct()
  {
    $this->url = 'https://communify.com/api';
  }

  /**
   * Create credential from option. On develop use communify_url and remove it from credential.
   *
   * @param $ssid
   * @param $data
   */
  public function set($ssid, $data)
  {
    if( isset($data['communify_url']) )
    {
      $this->url = $data['communify_url'];
      unset($data['communify_url']);
    }

    $basic = array(
      'ssid'  => $ssid
    );

    $this->data = array_merge($basic, $data);
  }

  /**
   * Get json encoded data array.
   *
   * @return string
   */
  public function get()
  {
    return json_encode($this->data);
  }

  /**
   * Get data array.
   *
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   * Get url string.
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }

}