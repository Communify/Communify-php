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
use Communify\SEO\SEOFactory;

/**
 * Class SEOLeadsEngine
 * @package Communify\SEO\engines
 */
class SEOLeadsEngine extends C2AbstractFactorizable
{

  /**
   * @var \Mustache_Engine
   */
  private $mustache;

  /**
   * @var SEOFactory
   */
  private $factory;


  /**
   * SEOLeadsEngine constructor.
   *
   * @param \Mustache_Engine|null $mustache
   * @param SEOFactory|null       $factory
   */
  function __construct(\Mustache_Engine $mustache = null, SEOFactory $factory = null)
  {
    if($mustache == null)
    {
      $mustache = new \Mustache_Engine();
    }

    if($factory == null)
    {
      $factory = new SEOFactory();
    }

    $this->mustache = $mustache;
    $this->factory = $factory;
  }

  /**
   * Render HTML from template to improve SEO.
   *
   * @param $array
   *
   * @return string
   */
  public function render($array)
  {
    $pages = $array['pages'];

    $finalHtml = '<noscript>';

    foreach($pages as $page)
    {
      $pageContent = $page['content'];
      foreach ($pageContent as $content)
      {
        try
        {
          $helperName = '\Communify\SEO\engines\helpers\\'.ucfirst($content['type']).'Helper';

          if(class_exists($helperName))
          {
            /** @var IPrintableObject $helper */
            $helper = $this->factory->createHelper($helperName);

            $finalHtml .= $helper->toHTML($content, $this->mustache);
          }
        }
        catch (\Exception $e)
        {
        }
      }
    }

    $finalHtml .= '</noscript>';

    return $finalHtml;
  }

}