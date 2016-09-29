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
use Communify\SEO\engines\SEOEnrichedEngine;
use Communify\SEO\parsers\interfaces\ISEOParser;

/**
 * Class SEOEnrichedTopic
 * @package Communify\SEO\parsers
 */
class SEOEnrichedTopic extends C2AbstractFactorizable implements ISEOParser
{

  /**
   * @var SEOEnrichedEngine
   */
  private $engine;


  /**
   * SEOLeadsTopic constructor.
   *
   * @param SEOEnrichedEngine|null $engine
   */
  function __construct(SEOEnrichedEngine $engine = null)
  {
    if($engine == null)
    {
      $engine = SEOEnrichedEngine::factory();
    }

    $this->engine = $engine;

  }



  /**
   * Get topic information from array result.
   *
   * @param $topic
   * @return array
   */
  public function get($topic)
  {
    return $this->engine->render($topic);
  }

}