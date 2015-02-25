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
use Communify\C2\interfaces\IC2Exception;
use Communify\C2\interfaces\IC2Response;


class C2Validator extends C2AbstractFactorizable
{

  /**
   * Check response data is valid and with all needed information.
   * Throw exception with all no valid cases and with KO status.
   *
   * @param $data
   * @return mixed
   * @throws C2Exception
   */
  public function checkData($data)
  {
    if( !isset($data['status']) )
    {
      throw new C2Exception(IC2Exception::STATUS_ERROR_NAME, IC2Exception::PARAM_ERROR);
    }

    if( $data['status'] != IC2Response::STATUS_KO && $data['status'] != IC2Response::STATUS_OK )
    {
      throw new C2Exception(IC2Exception::STATUS_VALUE_ERROR_NAME, IC2Exception::PARAM_ERROR);
    }

    if( !isset($data['data']) )
    {
      throw new C2Exception(IC2Exception::DATA_ERROR_NAME, IC2Exception::PARAM_ERROR);
    }

    if( $data['status'] == IC2Response::STATUS_KO && !isset($data['data']['message']) )
    {
      throw new C2Exception(IC2Exception::MSG_ERROR_NAME, IC2Exception::PARAM_ERROR);
    }

    if($data['status'] == IC2Response::STATUS_KO)
    {
      throw new C2Exception(IC2Exception::KO_ERROR_NAME, IC2Exception::KO_ERROR);
    }

    return $data['status'];
  }

}