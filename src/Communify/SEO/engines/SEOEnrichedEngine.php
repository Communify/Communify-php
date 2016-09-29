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

namespace Communify\SEO\engines;

use Communify\C2\abstracts\C2AbstractFactorizable;
use Communify\SEO\engines\helpers\interfaces\IPrintableObject;

/**
 * Class SEOEnrichedEngine
 * @package Communify\SEO\engines
 */
class SEOEnrichedEngine extends C2AbstractFactorizable
{

  /**
   * @var \Mustache_Engine
   */
  private $mustache;

  /**
   * @param \Mustache_Engine $mustache
   */
  function __construct(\Mustache_Engine $mustache = null)
  {
    if($mustache == null)
    {
      $mustache = new \Mustache_Engine();
    }

    $this->mustache = $mustache;
  }

  /**
   * Render HTML from template to improve SEO.
   *
   * @param $topic
   *
   * @return string
   */
  public function render($topic)
  {
    $varsArray = [
      'enriched_link' => $topic['cta_link']
    ];
    $template = file_get_contents(dirname(__FILE__).'/../html/enriched_template.html');

    $finalHtml = '<noscript>';
    $finalHtml .= $this->mustache->render($template, $varsArray);
    $finalHtml .= '</noscript>';

    return $finalHtml;
  }

}