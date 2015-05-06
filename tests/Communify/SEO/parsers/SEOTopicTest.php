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

use Communify\SEO\parsers\SEOTopic;

/**
 * @covers Communify\SEO\parsers\SEOTopic
 */
class SEOTopicTest extends \PHPUnit_Framework_TestCase
{

  /**
  * method: get
  * when: called
  * with: allowRatingsIsFalse
  * should: correct
  */
  public function test_get_called_allowRatingsIsFalse_correct()
  {
    $ideas = 12345678;
    $name = 'dummy name';
    $surname = 'dummy surname';
    $description = 'dummy description';
    $fileUrl = 'dummy file url';
    $title = 'dummy title';
    $allowRatings = false;
    $topic = $this->configureTopic($ideas, $name, $surname, $description, $fileUrl, $title);
    $expected = $this->configureExpectedGet($allowRatings, $ideas, '', $name, $surname, $description, $fileUrl, $title);
    $this->executeGetAndAssertResult($topic, $allowRatings, $expected);
  }

  /**
  * method: get
  * when: called
  * with: allowRatingsIsTrue
  * should: correct
  */
  public function test_get_called_allowRatingsIsTrue_correct()
  {
    $ideas = 12345678;
    $name = 'dummy name';
    $surname = 'dummy surname';
    $description = 'dummy description';
    $fileUrl = 'dummy file url';
    $title = 'dummy title';
    $averageRatings = 'dummy average ratings';
    $allowRatings = true;
    $topic = $this->configureTopic($ideas, $name, $surname, $description, $fileUrl, $title, $averageRatings);
    $expected = $this->configureExpectedGet($allowRatings, $ideas, $averageRatings, $name, $surname, $description, $fileUrl, $title);
    $this->executeGetAndAssertResult($topic, $allowRatings, $expected);
  }

  /**
   * @param $topic
   * @param $allowRatings
   * @param $expected
   */
  private function executeGetAndAssertResult($topic, $allowRatings, $expected)
  {
    $sut = new SEOTopic();
    $actual = $sut->get($topic, $allowRatings);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $allowRatings
   * @param $ideas
   * @param $averageRatings
   * @param $name
   * @param $surname
   * @param $description
   * @param $fileUrl
   * @param $title
   * @return array
   */
  private function configureExpectedGet($allowRatings, $ideas, $averageRatings, $name, $surname, $description, $fileUrl, $title)
  {
    $expected = array(
      'allow_ratings' => $allowRatings,
      'num_opinions' => $ideas,
      'review_average' => $averageRatings,
      'topic_author' => $name . ' ' . $surname,
      'topic_description' => $description,
      'topic_img' => $fileUrl,
      'topic_title' => $title,
    );
    return $expected;
  }

  /**
   * @param      $ideas
   * @param      $name
   * @param      $surname
   * @param      $description
   * @param      $fileUrl
   * @param      $title
   * @param null $avgRatings
   *
   * @return array
   */
  private function configureTopic($ideas, $name, $surname, $description, $fileUrl, $title, $avgRatings = null)
  {
    $topic = array(
      'ideas' => $ideas,
      'site' => array(
        'user' => array(
          'name' => $name,
          'surname' => $surname,
        ),
        'description' => $description,
        'file_url' => $fileUrl,
        'title' => $title
      )
    );

    if($avgRatings)
    {
      $topic['site']['average_ratings'] = $avgRatings;
    }

    return $topic;
  }


}