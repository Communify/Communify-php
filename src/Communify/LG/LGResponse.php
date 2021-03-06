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

use Communify\C2\abstracts\C2AbstractResponse;
use Guzzle\Http\Message\Response;


class LGResponse extends C2AbstractResponse
{
  private $data;

  /**
   * @param Response $response
   * @throws \Communify\C2\C2Exception
   */
  public function set(Response $response)
  {
    $this->data = $response->json();
    $this->validator->checkData($this->data);
  }

  /**
   * @return mixed
   */
  public function get()
  {
    return $this->data;
  }
}