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

namespace Communify\SEO;

use Communify\C2\C2Factory;
use Communify\SEO\parsers\SEOLanguage;
use Communify\SEO\parsers\SEOOpinion;
use Communify\SEO\parsers\SEOTopic;

/**
 * Class SEOFactory
 * @package Communify\SEO
 */
class SEOFactory extends C2Factory
{

  /**
   * Create SEOResponse.
   *
   * @return SEOResponse
   */
  public function response()
  {
    return SEOResponse::factory();
  }

  /**
   * Create SEOParser object.
   *
   * @param $result
   * @return SEOParser
   * @throws SEOException
   */
  public function parser($result)
  {
    return SEOParser::factory($result);
  }

  /**
   * @return SEOLanguage
   */
  public function languageParser()
  {
    return SEOLanguage::factory();
  }

  /**
   * @return SEOTopic
   */
  public function topicParser()
  {
    return SEOTopic::factory();
  }

  /**
   * @return SEOOpinion
   */
  public function opinionParser()
  {
    return SEOOpinion::factory();
  }

}