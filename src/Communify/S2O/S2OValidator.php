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
use Communify\C2\abstracts\C2AbstractFactorizable;
use Communify\C2\C2Meta;

/**
 * Class S2OMeta
 * @package Communify\S2O
 */
class S2OValidator extends C2AbstractFactorizable
{

  /**
   * Check response data is valid and with all needed information.
   * Throw exception with all no valid cases and with KO status.
   *
   * @param $data
   * @return mixed
   * @throws S2OException
   */
  public function checkData($data)
  {
    if( !isset($data['status']) )
    {
      throw new S2OException(C2Meta::STATUS_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] != S2OResponse::STATUS_KO && $data['status'] != S2OResponse::STATUS_OK )
    {
      throw new S2OException(C2Meta::STATUS_VALUE_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( !isset($data['data']) )
    {
      throw new S2OException(C2Meta::DATA_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] == S2OResponse::STATUS_KO && !isset($data['data']['message']) )
    {
      throw new S2OException(C2Meta::MSG_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if($data['status'] == S2OResponse::STATUS_KO)
    {
      throw new S2OException(C2Meta::KO_ERROR_NAME, S2OException::KO_ERROR);
    }

    return $data['status'];
  }

}