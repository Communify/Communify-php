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
namespace Communify\C2\abstracts;

use Communify\C2\C2Validator;
use Communify\C2\interfaces\IC2Response;
use Guzzle\Http\Message\Response;

/**
 * Class C2AbstractResponse
 * @package Communify\C2\abstracts
 */
abstract class C2AbstractResponse extends C2AbstractFactorizable implements IC2Response
{

  /**
   * @var C2Validator
   */
  protected $validator;

  /**
   * Create S2OValidator.
   *
   * @param C2Validator $validator
   */
  function __construct(C2Validator $validator = null)
  {
    if($validator == null)
    {
      $validator = C2Validator::factory();
    }

    $this->validator = $validator;
  }

  /**
   * @param Response $response
   */
  abstract public function set(Response $response);

}