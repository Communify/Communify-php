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

namespace tests\Communify\SEO\parsers;

use Communify\SEO\parsers\SEOLanguage;

/**
 * @covers Communify\SEO\parsers\SEOLanguage
 */
class SEOLanguageTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @return SEOLanguage
   */
  public function configureSut()
  {
    return new SEOLanguage();
  }

  /**
  * dataProvider getNoLanguageIdReturnDefaultLangData
  */
  public function getNoLanguageIdReturnDefaultLangData()
  {
    return array(
      array(array()),
      array(array(array('id' => 'dummy 1'), array('id'  => 'dummy 2')))
    );
  }

  /**
  * method: get
  * when: called
  * with: noLanguageId
  * should: returnDefaultLang
   * @dataProvider getNoLanguageIdReturnDefaultLangData
  */
  public function test_get_called_noLanguageId_returnDefaultLang($publicConfigurations)
  {
    $expected = $this->configureExpected(SEOLanguage::defaultLang);
    $actual =  $this->configureSut()->get($publicConfigurations);
    $this->assertEquals($expected, $actual);
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
  */
  public function test_get_called__correct()
  {
    $lang = 'dummy lang';
    $publicConfigurations = array(
      array('id'  => 'dummy'),
      array('id'  => 'language_id', 'value' => $lang)
    );
    $expected = $this->configureExpected($lang);
    $actual =  $this->configureSut()->get($publicConfigurations);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $lang
   * @return array
   */
  protected function configureExpected($lang)
  {
    $expected = array(
      'language' => $lang
    );
    return $expected;
  }

}