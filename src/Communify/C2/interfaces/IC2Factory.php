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

namespace Communify\C2\interfaces;

/**
 * Interface IC2Factory
 * @package Communify\C2\interfaces
 */
interface IC2Factory
{

  const INVALID_IMPL_CODE  = 103;
  const INVALID_IMPL_MSG    = 'C2Factory not implements this method. Extend it.';

  /**
   * @return mixed
   */
  public function httpClient();

  /**
   * @return IC2Connector
   */
  public function connector();

  /**
   * @return IC2Response
   */
  public function response();

}