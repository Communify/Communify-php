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

namespace Communify\SEO\engines\helpers\abstracts;
use Communify\C2\abstracts\C2AbstractFactorizable;

/**
 * Class AbstractPrintableObject
 * @package Communify\SEO\engines\helpers\abstracts
 */
abstract class AbstractPrintableObject extends C2AbstractFactorizable
{

  /**
   * @var string
   */
  protected $partialTemplateName;

  /**
   * AbstractPrintableObject constructor.
   */
  function __construct()
  {
    $this->partialTemplateName = '';
  }


  /**
   * @return string
   */
  public function getPartialFile()
  {
    return file_get_contents(dirname(__FILE__).'/../../../html/partials/'.$this->partialTemplateName.'.html');
  }

}