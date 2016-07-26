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


use Communify\C2\C2Factory;


class LGFactory extends C2Factory
{

  /**
   * @return \Communify\C2\interfaces\IC2Factorizable
   */
  public function connector()
  {
    return LGConnector::factory();
  }

  /**
   * Create LGResponse.
   *
   * @return LGResponse
   */
  public function response()
  {
    return LGResponse::factory();
  }

}