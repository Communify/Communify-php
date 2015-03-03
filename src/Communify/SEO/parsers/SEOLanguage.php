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

namespace Communify\SEO\parsers;


use Communify\C2\abstracts\C2AbstractFactorizable;
use Communify\SEO\parsers\interfaces\ISEOParser;

class SEOLanguage extends C2AbstractFactorizable implements ISEOParser
{

  const langKey = 'language_id';
  const defaultLang = 'en';

  /**
   * Return Language value from public configurations.
   * English as default language.
   *
   * @param $publicConfiguration
   * @return array
   */
  public function get($publicConfiguration)
  {
    $lang = self::defaultLang;

    foreach($publicConfiguration as $config)
    {
      if($config['id'] == self::langKey)
      {
        $lang = $config['value'];
        break;
      }
    }

    return array(
      'language'  => $lang
    );
  }

}