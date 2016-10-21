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
 * Class ImageHelper
 * @package Communify\SEO\engines\helpers
 */
class ImageHelper extends AbstractPrintableObject implements IPrintableObject
{
  /**
   * ImageHelper constructor.
   */
  function __construct()
  {
    $this->partialTemplateName = 'image_item';
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
      'element_styles'        =>  (array_key_exists('styles', $elementArray['attrs']) && $elementArray['attrs']['styles']) ? $elementArray['attrs']['styles'] : '',
      'element_width'         =>  (array_key_exists('width', $elementArray['attrs']) && $elementArray['attrs']['width']) ? $elementArray['attrs']['width'] : '',
      'element_height'        =>  (array_key_exists('height', $elementArray['attrs']) && $elementArray['attrs']['height']) ? $elementArray['attrs']['height'] : '',
      'element_class'         =>  (array_key_exists('class', $elementArray['attrs']) && $elementArray['attrs']['class']) ? $elementArray['attrs']['class'] : 'img-responsive',
      'element_src'           =>  (array_key_exists('src', $elementArray['attrs']) && $elementArray['attrs']['src']) ? $elementArray['attrs']['src'] : '/assets/images/placeholder.png',
    ];

    $template = $this->getPartialFile();

    return $mustacheEngine->render($template, $valuesArray);
  }
}