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

use Communify\SEO\engines\SEOConversationsEngine;
use Communify\SEO\parsers\SEOUserConversationTopic;

/**
 * @covers Communify\SEO\parsers\SEOTopic
 */
class SEOUserConversationTopicTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var SEOUserConversationTopic
   */
  private $sut;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $engine;


  public function setUp()
  {
    $this->engine = $this->getMock(SEOConversationsEngine::class);
    $this->sut = new SEOUserConversationTopic($this->engine);
  }

  /**
  * dataProvider getCorrectData
  */
  public function getCorrectData()
  {
    return array(
      array($this->any()),
      array($this->once())
    );
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
   * @dataProvider getCorrectData
  */
  public function test_get_called__correct($timesRender)
  {
    $ideas = 12345678;
    $name = 'dummy name';
    $surname = 'dummy surname';
    $description = 'dummy description';
    $fileUrl = 'dummy file url';
    $title = 'dummy title';
    $topicName = 'dummy topic name';
    $language = 'dummy language';
    $topic = $this->configureTopic($ideas, $name, $surname, $description, $fileUrl, $title, $topicName, $language);
    $expectedResult = 'dummy html';

    $this->configureExpectedArrayAndRender($ideas, $name, $surname, $description, $fileUrl, $title, $topicName,
      $language, $timesRender, $expectedResult);

    $result = $this->sut->get($topic);
    $this->assertEquals($expectedResult, $result);
  }


  /**
   * @param $ideas
   * @param $name
   * @param $surname
   * @param $description
   * @param $fileUrl
   * @param $title
   * @param $topicName
   * @param $language
   * @param $timesRender
   * @param $expectedResult
   */
  private function configureExpectedArrayAndRender($ideas, $name, $surname, $description, $fileUrl,
                                                   $title, $topicName, $language, $timesRender, $expectedResult)
  {
    $expectedArray = array(
      'num_ideas' => $ideas,
      'topic_author' => $name . ' ' . $surname,
      'topic_description' => $description,
      'topic_img' => $fileUrl,
      'topic_title' => $title,
      'topic_name'  => $topicName,
      'language'    => $language
    );

    $this->engine->expects($timesRender)
      ->method('render')
      ->with($expectedArray)
      ->will($this->returnValue($expectedResult));
  }

  /**
   * @param      $ideas
   * @param      $name
   * @param      $surname
   * @param      $description
   * @param      $fileUrl
   * @param      $title
   * @param      $topicName
   * @param      $language
   * @param null $avgRatings
   *
   * @return array
   */
  private function configureTopic($ideas, $name, $surname, $description, $fileUrl, $title, $topicName, $language, $avgRatings = null)
  {
    $topic = array(
      'num_ideas' => $ideas,
      'user' => array(
        'name' => $name,
        'surname' => $surname,
      ),
      'description' => $description,
      'file_url' => $fileUrl,
      'title' => $title,
      'name' => $topicName,
      'language' => $language
    );

    if($avgRatings)
    {
      $topic['average_ratings'] = $avgRatings;
    }

    return $topic;
  }


}