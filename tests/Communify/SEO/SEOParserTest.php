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

use Communify\SEO\parsers\SEOEnrichedTopic;
use Communify\SEO\parsers\SEOLanguage;
use Communify\SEO\parsers\SEOLeadsTopic;
use Communify\SEO\parsers\SEOUserConversationTopic;
use Communify\SEO\SEOFactory;
use Communify\SEO\SEOParser;
use Communify\SEO\parsers\SEOTopic;

/**
 * @covers Communify\SEO\SEOParser
 */
class SEOParserTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  public function setUp()
  {
    $this->factory = $this->getMock(SEOFactory::class);
  }

  /**
   * @param $result
   * @param null $allowRatings
   * @return SEOParser
   * @throws \Communify\SEO\SEOException
   */
  protected function configureSut($result, $allowRatings = null)
  {
    $languageParser = $this->getMock(SEOLanguage::class);
    $this->configureFactoryMethod('languageParser', $languageParser, $this->at(0));

    $languageParser->expects($this->any())
      ->method('get')
      ->will($this->returnValue(array('language_id' => 'ca')));

    return SEOParser::factory($result, $allowRatings, $this->factory);
  }

  /**
  * dataProvider getConstructorData
  */
  public function getConstructorData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: constructor
  * when: called
  * with:
  * should: correct
   * @dataProvider getConstructorData
  */
  public function test_constructor_called__correct($allowRatings)
  {
    $result = [
      'data'  => [
        'sites' => [
          ['site'  => [
            'allow_ratings' => $allowRatings,
            'type_configuration' => ['id' => 'dummy']
          ]
          ]
        ],
        'public_configurations' => [
          ['id' => 'language_id' , 'value' => 'ca']
        ]
      ]
    ];
    $sut = new SEOParser($result, $allowRatings);
    $this->assertAttributeEquals($result, 'result', $sut);
    $this->assertAttributeEquals($allowRatings, 'allowRatings', $sut);
    $this->assertAttributeInstanceOf(SEOFactory::class, 'factory', $sut);
  }

  /**
  * method: factory
  * when: called
  * with: noParam
  * should: throwException
   * @expectedException \Communify\SEO\SEOException
   * @expectedExceptionMessage Invalid result: null value is not allowed
  */
  public function test_factory_called_noParam_throwException()
  {
    SEOParser::factory();
  }

  /**
   * method: factory
   * when: called
   * with: nullResult
   * should: throwException
   * @expectedException \Communify\SEO\SEOException
   * @expectedExceptionMessage Invalid result: null value is not allowed
   */
  public function test_factory_called_nullResult_throwException()
  {
    SEOParser::factory(null);
  }

  /**
  * dataProvider getFactoryNotAllowRatingsParamData
  */
  public function getFactoryNotAllowRatingsParamData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: factory
  * when: called
  * with: notAllowRatingsParam
  * should: correct
   * @dataProvider getFactoryNotAllowRatingsParamData
  */
  public function test_factory_called_notAllowRatingsParam_correct($allowRatings)
  {
    $result = $this->configureFactoryResult($allowRatings);
    $actual = SEOParser::factory($result);
    $this->assertFactory($allowRatings, $actual, $result);
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $actual);
  }

  /**
  * dataProvider getFactoryData
  */
  public function getFactoryData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correct
   * @dataProvider getFactoryData
  */
  public function test_factory_called__correct($allowRatings)
  {
    $result = $this->configureFactoryResult('dummy allow ratings');
    $actual = SEOParser::factory($result, $allowRatings);
    $this->assertFactory($allowRatings, $actual, $result);
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $actual);
  }

  /**
  * dataProvider getFactoryInjectedFactoryData
  */
  public function getFactoryInjectedFactoryData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: factory
  * when: called
  * with: injectedFactory
  * should: correct
   * @dataProvider getFactoryInjectedFactoryData
  */
  public function test_factory_called_injectedFactory_correct($allowRatings)
  {
    $factory = SEOFactory::factory();
    $result = $this->configureFactoryResult('dummy allow ratings');
    $actual = SEOParser::factory($result, $allowRatings, $factory);
    $this->assertFactory($allowRatings, $actual, $result);
    $this->assertAttributeEquals($factory, 'factory', $actual);
  }

  /**
  * dataProvider getLangData
  */
  public function getLangData()
  {
    return array(
      array(true, $this->any(), $this->any())
    );
  }

  /**
  * method: getLang
  * when: called
  * with:
  * should: correct
   * @dataProvider getLangData
  */
  public function test_getLang_called__correct($allowRatings, $timesFactory, $timesGet)
  {
    $expected = array('dummy expected value');
    $expectedArray = [
      ['id' => 'language_id' , 'value' => 'ca']
    ];
    $result = [
      'data'  => [
        'sites' => [
          ['site'  => [
            'allow_ratings' => $allowRatings,
            'type_configuration' => ['id' => 'dummy']
          ]
          ]
        ],
        'public_configurations' => [
          ['id' => 'language_id' , 'value' => 'ca']
        ]
      ]
    ];
    $languageParser = $this->getMock(SEOLanguage::class);

    $this->configureFactoryMethod('languageParser', $languageParser, $timesFactory);
    $this->configureParserGet($timesGet, $languageParser, $expectedArray, $expected);

    $actual = $this->configureSut($result, $allowRatings)->getLang();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getTopicData
  */
  public function getTopicData()
  {
    return array(
      array(2, 'userConversationTopicParser', SEOUserConversationTopic::class, $this->any(), $this->any()),
      array(2, 'userConversationTopicParser', SEOUserConversationTopic::class, $this->once(), $this->any()),
      array(2, 'userConversationTopicParser', SEOUserConversationTopic::class, $this->any(), $this->once()),

      array(3, 'leadsTopicParser', SEOLeadsTopic::class, $this->any(), $this->any()),
      array(3, 'leadsTopicParser', SEOLeadsTopic::class, $this->once(), $this->any()),
      array(3, 'leadsTopicParser', SEOLeadsTopic::class, $this->any(), $this->once()),

      array(5, 'enrichedTopicParser', SEOEnrichedTopic::class, $this->any(), $this->any()),
      array(5, 'enrichedTopicParser', SEOEnrichedTopic::class, $this->once(), $this->any()),
      array(5, 'enrichedTopicParser', SEOEnrichedTopic::class, $this->any(), $this->once()),
    );
  }

  /**
  * method: getTopic
  * when: called
  * with:
  * should: correct
   * @dataProvider getTopicData
  */
  public function test_getTopic_called__correct($topicType, $topicParserInvocationName, $expectedTopicParserClass, $timesFactory, $timesGet)
  {
    $expected = array('dummy expected value');
    $result = [
      'data'  => [
        'sites' => [
          ['site'  => [
            'allow_ratings' => false,
            'type_configuration' => ['id' => $topicType]
          ]
          ]
        ],
        'public_configurations' => [
          ['id' => 'language_id' , 'value' => 'ca']
        ]
      ]
    ];

    $expectedArray = array_merge(['language_id' => 'ca'], ['allow_ratings' => false, 'type_configuration' => ['id' => $topicType]]);
    $topicParser = $this->getMock($expectedTopicParserClass);

    $this->configureFactoryMethod($topicParserInvocationName, $topicParser, $timesFactory);
    $this->configureParserGet($timesGet, $topicParser, $expectedArray, $expected, false);

    $actual = $this->configureSut($result, false)->getTopic();
    $this->assertEquals($expected, $actual);
  }


  /**
   * @param $allowRatings
   * @return array
   */
  private function configureFactoryResult($allowRatings)
  {
    $result = [
      'data'  => [
        'sites' => [
          ['site'  => [
            'allow_ratings' => $allowRatings,
            'type_configuration' => ['id' => 'dummy']
          ]
          ]
        ],
        'public_configurations' => [
          ['id' => 'language_id' , 'value' => 'ca']
        ]
      ]
    ];
    return $result;
  }

  /**
   * @param $allowRatings
   * @param $actual
   * @param $result
   */
  private function assertFactory($allowRatings, $actual, $result)
  {
    $this->assertInstanceOf('Communify\SEO\SEOParser', $actual);
    $this->assertAttributeEquals($result, 'result', $actual);
    $this->assertAttributeEquals($allowRatings, 'allowRatings', $actual);
  }

  /**
   * @param $method
   * @param $objectParser
   * @param $timesFactory
   */
  private function configureFactoryMethod($method, $objectParser, $timesFactory)
  {
    $this->factory->expects($timesFactory)
      ->method($method)
      ->will($this->returnValue($objectParser));
  }

  /**
   * @param $timesGet
   * @param $objectParser
   * @param $expectedArray
   * @param $expected
   * @param null $allowRatings
   */
  private function configureParserGet($timesGet, $objectParser, $expectedArray, $expected, $allowRatings = null)
  {
    if($allowRatings === null)
    {
      $objectParser->expects($timesGet)
        ->method('get')
        ->with($expectedArray)
        ->will($this->returnValue($expected));
    }
    else
    {
      $objectParser->expects($timesGet)
        ->method('get')
        ->with($expectedArray, $allowRatings)
        ->will($this->returnValue($expected));
    }

  }


}