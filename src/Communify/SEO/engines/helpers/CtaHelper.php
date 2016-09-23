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
 * Class CtaHelper
 * @package Communify\SEO\engines\helpers
 */
class CtaHelper extends AbstractPrintableObject implements IPrintableObject
{
  /**
   * CtaHelper constructor.
   */
  function __construct()
  {
    $this->partialTemplateName = 'cta_item';
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
      'element_class'         =>  $elementArray['attrs']['class'] ? $elementArray['attrs']['class'] : false,
      'element_style'         =>  $elementArray['attrs']['style'] ? $elementArray['attrs']['style'] : '',
      'element_html'          =>  $elementArray['attrs']['cta_html'] ? $elementArray['attrs']['cta_html'] : false,
      'element_text'          =>  $elementArray['attrs']['text'] ? htmlentities($elementArray['attrs']['text']) : false,
    ];

    $template = $this->getPartialFile();

    return $mustacheEngine->render($template, $valuesArray);
  }
}