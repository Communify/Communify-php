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

namespace Communify\SEO\engines\helpers;

use Communify\SEO\engines\helpers\abstracts\AbstractPrintableObject;
use Communify\SEO\engines\helpers\interfaces\IPrintableObject;

/**
 * Class VideoHelper
 * @package Communify\SEO\engines\helpers
 */
class VideoHelper extends AbstractPrintableObject implements IPrintableObject
{
  /**
   * VideoHelper constructor.
   */
  function __construct()
  {
    $this->partialTemplateName = 'video_item';
  }


  /**
   * @param $elementArray
   * @param \Mustache_Engine $mustacheEngine
   *
   * @return string
   */
  public function toHTML($elementArray, \Mustache_Engine $mustacheEngine)
  {

    $valuesArray = [
      'element_custom_styles' => (array_key_exists('customStyles', $elementArray['attrs']) && $elementArray['attrs']['customStyles']) ? $elementArray['attrs']['customStyles'] : '',
      'element_style'         => (array_key_exists('style', $elementArray['attrs']) && $elementArray['attrs']['style']) ? $elementArray['attrs']['style'] : '',
      'element_src'           => $elementArray['attrs']['src'] ? $elementArray['attrs']['src'] : false,
    ];

    if($valuesArray['element_src'])
    {
      if($valuesArray['element_src'] != str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $valuesArray['element_src']))
      {
        $valuesArray['element_src'] = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $valuesArray['element_src']);
      }
      else if($valuesArray['element_src'] != str_replace('https://vimeo.com/', 'https://player.vimeo.com/video/', $valuesArray['element_src']))
      {
        $valuesArray['element_src'] = str_replace('https://vimeo.com/', 'https://player.vimeo.com/video/', $valuesArray['element_src']);
      }
    }

    $template = $this->getPartialFile();

    return $mustacheEngine->render($template, $valuesArray);
  }
}