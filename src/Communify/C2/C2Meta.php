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
use Communify\C2\interfaces\IC2Exception;

/**
 * Class C2Meta
 * @package Communify\C2
 */
class C2Meta
{

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $content;

  const OK_BASE_NAME = 'communify-';

  /**
   * @var array
   */
  public static $MESSAGES = array(
    IC2Exception::STATUS_ERROR_NAME         => IC2Exception::STATUS_ERROR_MSG,
    IC2Exception::STATUS_VALUE_ERROR_NAME   => IC2Exception::STATUS_VALUE_ERROR_MSG,
    IC2Exception::DATA_ERROR_NAME           => IC2Exception::DATA_ERROR_MSG,
    IC2Exception::MSG_ERROR_NAME            => IC2Exception::MSG_ERROR_MSG,
  );

  /**
   * Create C2Meta. Name and content are needed.
   *
   * @param $name
   * @param $content
   */
  function __construct($name, $content)
  {
    $this->name = $name;
    $this->content = $content;
  }

  /**
   * Create C2Meta.
   *
   * @param $name
   * @param $content
   * @return C2Meta
   */
  public static function factory($name, $content)
  {
    return new C2Meta($name, $content);
  }

  /**
   * Return HTML string value with name and content values.
   *
   * @return string
   */
  public function getHtml()
  {
    return '<meta name="'.$this->name.'" content="'.$this->content.'">';
  }

  /**
   * Get content string.
   *
   * @return mixed
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * Get name string.
   *
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

} 