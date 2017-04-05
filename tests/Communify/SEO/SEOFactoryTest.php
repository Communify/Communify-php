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

use Communify\SEO\engines\helpers\AmazonHelper;
use Communify\SEO\engines\helpers\CtaHelper;
use Communify\SEO\engines\helpers\FormHelper;
use Communify\SEO\engines\helpers\GmapsHelper;
use Communify\SEO\engines\helpers\HtmlHelper;
use Communify\SEO\engines\helpers\ImageHelper;
use Communify\SEO\engines\helpers\PaypalHelper;
use Communify\SEO\engines\helpers\TextHelper;
use Communify\SEO\engines\helpers\VideoHelper;
use Communify\SEO\SEOFactory;

use Communify\SEO\SEOResponse;
use Communify\SEO\parsers\SEOLanguage;
use Communify\SEO\parsers\SEOUserConversationTopic;
use Communify\SEO\parsers\SEOLeadsTopic;
use Communify\SEO\parsers\SEOEnrichedTopic;


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
      array('response', SEOResponse::class),
      array('languageParser', SEOLanguage::class),
//      array('userConversationTopicParser', SEOUserConversationTopic::class),
      array('leadsTopicParser', SEOLeadsTopic::class),
      array('enrichedTopicParser', SEOEnrichedTopic::class),
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
		$actualClass = get_class($actual);
    $this->assertEquals($class, $actualClass);
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
  public function test_parser_called__correct()
  {
    $result = [
      'data'  => [
        'sites' => [
            ['site'  => [
              'type_configuration' => ['id' => 'dummy']
            ]
          ]
        ],
        'public_configurations' => [
          ['id' => 'language_id' , 'value' => 'ca']
        ]
      ]
    ];
    $actual = $this->sut->parser($result);
    $this->assert('SEOParser', $actual);
    $this->assertAttributeEquals($result, 'result', $actual);
  }

  /**
   * @param $class
   * @param $actual
   */
  protected function assert($class, $actual)
  {
    $this->assertInstanceOf('Communify\SEO\\' . $class, $actual);
  }


  /**
  * method: createHelper
  * when: called
  * with: invalidClass
  * should: throw
   * @expectedException \Exception
   * @expectedExceptionCode 201
   * @expectedExceptionMessage Cannot create helper: Invalid class
  */
  public function test_createHelper_called_invalidClass_throw()
  {
    $class = 'nonExistingClass';

    $this->sut->createHelper($class);
  }


  /**
  * dataProvider getCreateHelperCorrectData
  */
  public function getCreateHelperCorrectData()
  {
    return array(
      array(TextHelper::class),
      array(AmazonHelper::class),
      array(CtaHelper::class),
      array(FormHelper::class),
      array(GmapsHelper::class),
      array(HtmlHelper::class),
      array(ImageHelper::class),
      array(PaypalHelper::class),
      array(VideoHelper::class),
    );
  }

  /**
  * method: createHelper
  * when: called
  * with:
  * should: correct
   * @dataProvider getCreateHelperCorrectData
  */
  public function test_createHelper_called__correct($class)
  {
    $result = $this->sut->createHelper($class);

    $this->assertInstanceOf($class, $result);
  }

}