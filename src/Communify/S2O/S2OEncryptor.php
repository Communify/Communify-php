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
 * Class S2OEncryptor
 * @package Communify\S2O
 */
class S2OEncryptor
{

  /**
   * Create S2OEncryptor
   *
   * @return S2OEncryptor
   */
  public static function factory()
  {
    return new S2OEncryptor();
  }

  /**
   * Return a base64 encoded from a json encoded value.
   *
   * @param $value
   * @return string
   */
  public function execute($value)
  {
    return base64_encode(json_encode($value));
  }

} 