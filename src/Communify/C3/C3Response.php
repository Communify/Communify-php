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

namespace Communify\C3;

use Communify\C2\abstracts\C2AbstractResponse;
use Communify\C2\C2Exception;
use Guzzle\Http\Message\Response;

/**
 * Class C3Response
 * @package Communify\C3
 */
class C3Response extends C2AbstractResponse
{

  private $value;

  /**
   * @param Response $response
   */
  public function set(Response $response)
  {
    try
    {
      $result = $response->json();
      $this->validator->checkData($result);
      $this->value = $result['data'];
    }
    catch(C2Exception $e)
    {
      $this->value = null;
    }
  }

  /**
   * @return mixed
   */
  public function getValue()
  {
    return $this->value;
  }

} 