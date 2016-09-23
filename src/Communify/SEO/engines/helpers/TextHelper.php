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

use Communify\SEO\engines\helpers\interfaces\IPrintableObject;
use Communify\SEO\engines\helpers\abstracts\AbstractPrintableObject;

/**
 * Class TextHelper
 * @package Communify\SEO\engines\helpers
 */
class TextHelper extends AbstractPrintableObject implements IPrintableObject
{

  function __construct()
  {
    $this->partialTemplateName = 'text_item';
  }


  /**
   * @param $elementArray
   * @param \Mustache_Engine $mustacheEngine
   *
   * @return string
   */
  public function toHTML($elementArray, \Mustache_Engine $mustacheEngine)
  {
    $elementType = $elementArray['attrs']['type'] ? $elementArray['attrs']['type'] : 'default';

    $valuesArray = [
      $elementType    => true,
      'element_value' => htmlentities($elementArray['attrs']['value']),
      'element_class' => $elementArray['attrs']['class'] ? $elementArray['attrs']['class'] : '',
      'element_style' => ($elementArray['attrs']['customStyles'] ? $elementArray['attrs']['customStyles'] : '').' '.($elementArray['attrs']['styles'] ? $elementArray['attrs']['styles'] : '')
    ];

    $template = $this->getPartialFile();
    return $mustacheEngine->render($template, $valuesArray);
  }
}