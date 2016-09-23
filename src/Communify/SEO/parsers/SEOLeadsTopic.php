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
use Communify\SEO\engines\SEOLeadsEngine;
use Communify\SEO\parsers\interfaces\ISEOParser;

/**
 * Class SEOLeadsTopic
 * @package Communify\SEO\parsers
 */
class SEOLeadsTopic extends C2AbstractFactorizable implements ISEOParser
{

  /**
   * @var SEOLeadsEngine
   */
  private $engine;


  /**
   * SEOLeadsTopic constructor.
   *
   * @param SEOLeadsEngine|null $engine
   */
  function __construct(SEOLeadsEngine $engine = null)
  {
    if($engine == null)
    {
      $engine = SEOLeadsEngine::factory();
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
    return $this->engine->render($topic['json']['json']);
  }

}