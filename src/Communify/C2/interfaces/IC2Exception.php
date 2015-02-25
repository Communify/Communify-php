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
 * Interface IC2Factorizable
 * @package Communify\C2\interfaces
 */
interface IC2Exception
{

  const KO_ERROR = 101;
  const PARAM_ERROR = 102;

  const STATUS_ERROR_NAME         = 'communify-error-json-status';
  const STATUS_ERROR_MSG          = 'Invalid response structure. Status needed.';

  const STATUS_VALUE_ERROR_NAME   = 'communify-error-status-value';
  const STATUS_VALUE_ERROR_MSG    = 'Invalid status value';

  const DATA_ERROR_NAME           = 'communify-error-json-data';
  const DATA_ERROR_MSG            = 'Invalid response structure. Data needed.';

  const MSG_ERROR_NAME            = 'communify-error-json-msg';
  const MSG_ERROR_MSG             = 'Invalid response structure. Message needed.';

  const KO_ERROR_NAME             = 'communify-error';
  const KO_ERROR_MSG              = 'Result is a KO.';

}