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
use Communify\SEO\SEOParser;

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
    $this->factory = $this->getMock('Communify\SEO\SEOFactory');
  }

  /**
   * @param $result
   * @param null $allowRatings
   * @return SEOParser
   * @throws \Communify\SEO\SEOException
   */
  protected function configureSut($result, $allowRatings = null)
  {
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
    $expected = 'dummy result value';
    $sut = new SEOParser($expected, $allowRatings);
    $this->assertAttributeEquals($expected, 'result', $sut);
    $this->assertAttributeEquals($allowRatings, 'allowRatings', $sut);
    $this->assertAttributeInstanceOf('Communify\SEO\SEOFactory', 'factory', $sut);
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
      array(true, $this->any(), $this->any()),
      array(true, $this->once(), $this->any()),
      array(true, $this->any(), $this->once()),

      array(false, $this->any(), $this->any()),
      array(false, $this->once(), $this->any()),
      array(false, $this->any(), $this->once()),
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
    $expectedArray = array('dummy' => 'data');
    $result = array(
      'data'  => array(
        'topic' => array(
          'public_configurations' => $expectedArray
        )
      )
    );
    $languageParser = $this->getMock('Communify\SEO\parsers\SEOLanguage');
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
      array(true, $this->any(), $this->any()),
      array(true, $this->once(), $this->any()),
      array(true, $this->any(), $this->once()),

      array(false, $this->any(), $this->any()),
      array(false, $this->once(), $this->any()),
      array(false, $this->any(), $this->once()),
    );
  }

  /**
  * method: Topic
  * when: called
  * with:
  * should: correct
   * @dataProvider getTopicData
  */
  public function test_Topic_called__correct($allowRatings, $timesFactory, $timesGet)
  {
    $expected = array('dummy expected value');
    $expectedArray = array('dummy' => 'data');
    $result = array(
      'data'  => array(
        'topic' => $expectedArray
      )
    );
    $topicParser = $this->getMock('Communify\SEO\parsers\SEOTopic');
    $this->configureFactoryMethod('topicParser', $topicParser, $timesFactory);
    $this->configureParserGet($timesGet, $topicParser, $expectedArray, $expected, $allowRatings);
    $actual = $this->configureSut($result, $allowRatings)->getTopic();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getOpinionsEmptyReturnData
  */
  public function getOpinionsEmptyReturnData()
  {
    return array(
      array(true, $this->any()),
      array(true, $this->once()),

      array(false, $this->any()),
      array(false, $this->once()),
    );
  }

  /**
  * method: getOpinions
  * when: called
  * with: noOpinions
  * should: emptyReturn
   * @dataProvider getOpinionsEmptyReturnData
  */
  public function test_getOpinions_called_noOpinions_emptyReturn($allowRatings, $timesFactory)
  {
    $expected = array('opinions'  => array());
    $result = array(
      'data'  => array(
        'opinions'  => array()
      )
    );
    $opinionParser = $this->getMock('Communify\SEO\parsers\SEOOpinion');
    $this->configureFactoryMethod('opinionParser', $opinionParser, $timesFactory);
    $opinionParser->expects($this->never())
      ->method('get');
    $actual = $this->configureSut($result, $allowRatings)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getOpinionsData
  */
  public function getOpinionsData()
  {
    return array(
      array(true, $this->any()),
      array(true, $this->once()),

      array(false, $this->any()),
      array(false, $this->once()),
    );
  }

  /**
  * method: getOpinions
  * when: called
  * with: opinions
  * should: correctReturn
   * @dataProvider getOpinionsData
  */
  public function test_getOpinions_called_opinions_correctReturn($allowRatings, $timesFactory)
  {
    $exOpinion1 = array('expected dummy opinion 1');
    $exOpinion2 = array('expected dummy opinion 2');
    $exOpinion3 = array('expected dummy opinion 3');
    $opinion1 = array('dummy opinion 1');
    $opinion2 = array('dummy opinion 2');
    $opinion3 = array('dummy opinion 3');
    $expected = array('opinions'  => array($exOpinion1, $exOpinion2, $exOpinion3));
    $result = array(
      'data'  => array(
        'opinions'  => array($opinion1, $opinion2, $opinion3)
      )
    );
    $opinionParser = $this->getMock('Communify\SEO\parsers\SEOOpinion');
    $this->configureFactoryMethod('opinionParser', $opinionParser, $timesFactory);
    $this->configureParserGet($this->at(0), $opinionParser, $opinion1, $exOpinion1, $allowRatings);
    $this->configureParserGet($this->at(1), $opinionParser, $opinion2, $exOpinion2, $allowRatings);
    $this->configureParserGet($this->at(2), $opinionParser, $opinion3, $exOpinion3, $allowRatings);
    $actual = $this->configureSut($result, $allowRatings)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $allowRatings
   * @return array
   */
  private function configureFactoryResult($allowRatings)
  {
    $result = array('data' => array(
      'topic' => array(
        'site' => array(
          'allow_ratings' => $allowRatings
        )
      ),
    ));
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