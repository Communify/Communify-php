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


class FormHelper extends AbstractPrintableObject implements IPrintableObject
{

  /**
   * FormHelper constructor.
   */
  function __construct()
  {
    $this->partialTemplateName = 'form_item';
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
      'element_elements_distance'   => $elementArray['attrs']['form']['elementsDistance'] ? $elementArray['attrs']['form']['elementsDistance'] : false,
      'element_name_label'          => $elementArray['attrs']['form']['name']['label'] ? htmlentities($elementArray['attrs']['form']['name']['label'])  : false,
      'element_name_placeholder'    => $elementArray['attrs']['form']['name']['placeholder'] ? htmlentities($elementArray['attrs']['form']['name']['placeholder'])  : false,
      'element_surname_label'       => $elementArray['attrs']['form']['surname']['label'] ? htmlentities($elementArray['attrs']['form']['surname']['label'])  : false,
      'element_surname_placeholder' => $elementArray['attrs']['form']['surname']['placeholder'] ? htmlentities($elementArray['attrs']['form']['surname']['placeholder'])  : false,
      'element_email_label'         => $elementArray['attrs']['form']['email']['label'] ? htmlentities($elementArray['attrs']['form']['email']['label'])  : false,
      'element_email_placeholder'   => $elementArray['attrs']['form']['email']['placeholder'] ? htmlentities($elementArray['attrs']['form']['email']['placeholder'])  : false,
    ];

    $template = $this->getPartialFile();

    return $mustacheEngine->render($template, $valuesArray);
  }
}