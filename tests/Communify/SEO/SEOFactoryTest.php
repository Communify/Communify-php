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

namespace tests\Communify\SEO;

use Communify\SEO\SEOFactory;

/**
 * @covers Communify\SEO\SEOFactory
 */
class SEOFactoryTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var SEOFactory
   */
  private $sut;

  public function setUp()
  {
    $this->sut = new SEOFactory();
  }

  /**
  * dataProvider getS2OMethodsData
  */
  public function getS2OMethodsData()
  {
    return array(
      array('response', 'SEOResponse'),
    );
  }

  /**
  * method: s2OMethods
  * when: called
  * with:
  * should: correctReturn
   * @dataProvider getS2OMethodsData
  */
  public function test_s2OMethods_called__correctReturn($method, $class)
  {
    $actual = $this->sut->$method();
    $this->assert($class, $actual);
  }

  /**
  * dataProvider getParserData
  */
  public function getParserData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: parser
  * when: called
  * with:
  * should: correct
   * @dataProvider getParserData
  */
  public function test_parser_called__correct($allowRatings)
  {
    $result = array(
      'data'  => array(
        'topic' => array(
          'site'  => array(
            'allow_ratings' => $allowRatings
          )
        )
      )
    );
    $actual = $this->sut->parser($result);
    $this->assert('SEOParser', $actual);
    $this->assertAttributeEquals($result, 'result', $actual);
    $this->assertAttributeEquals($allowRatings, 'allowRatings', $actual);
  }

  /**
   * @param $class
   * @param $actual
   */
  protected function assert($class, $actual)
  {
    $this->assertInstanceOf('Communify\SEO\\' . $class, $actual);
  }

}