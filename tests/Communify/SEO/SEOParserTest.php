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

use Communify\SEO\SEOParser;

/**
 * @covers Communify\SEO\SEOParser
 */
class SEOParserTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @param $result
   * @return SEOParser
   * @throws \Communify\SEO\SEOException
   */
  protected function configureSut($result)
  {
    return SEOParser::factory($result);
  }

  /**
  * method: constructor
  * when: called
  * with:
  * should: correct
  */
  public function test_constructor_called__correct()
  {
    $expected = 'dummy result value';
    $sut = new SEOParser($expected);
    $this->assertAttributeEquals($expected, 'result', $sut);
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
  * method: factory
  * when: called
  * with:
  * should: correct
  */
  public function test_factory_called__correct()
  {
    $expected = 'dummy result';
    $actual = $this->configureSut($expected);
    $this->assertInstanceOf('Communify\SEO\SEOParser', $actual);
    $this->assertAttributeEquals($expected, 'result', $actual);
  }

  /**
  * method: getTopic
  * when: called
  * with:
  * should: correct
  */
  public function test_getTopic_called__correct()
  {
    $numOpinions = 'dummy num opinions';
    $topicTitle = 'dummy topic title';
    $topicImg = 'dummy topic img';
    $topicDesc = 'dummy topic desc';
    $name = 'dummy user name';
    $surname = 'dummy user surname';

    $result = array(
      'data'  => array(
        'topic' => array(
          'site'  => array(
            'title'       => $topicTitle,
            'file_url'    => $topicImg,
            'description' => $topicDesc,
            'user'        => array(
              'name'    => $name,
              'surname' => $surname
            )
          ),
          'ideas' => $numOpinions
        )
      )
    );

    $expected = array(
      'topic_title'         => $topicTitle,
      'topic_img'           => $topicImg,
      'topic_description'   => $topicDesc,
      'topic_author'        => $name.' '.$surname,
      'num_opinions'        => $numOpinions,
    );

    $actual = $this->configureSut($result)->getTopic();
    $this->assertEquals($expected, $actual);
  }

  /**
  * method: getOpinions
  * when: called
  * with: noOpinions
  * should: returnEmpty
  */
  public function test_getOpinions_called_noOpinions_returnEmpty()
  {
    $result = $this->configureResultOnGetOpinions(array());
    $expected = array('opinions'  => array());
    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
  * method: getOpinions
  * when: called
  * with: twoOpinionsWithNoReplies
  * should: correct
  */
  public function test_getOpinions_called_twoOpinionsWithNoReplies_correct()
  {
    $opinion1 = $this->configureOpinion('dummy name 1', 'dummy surname 1', 'dummy image 1', 'dummy msg 1', 'dummy num replies 1', 'dummy num positive 1', 'dummy num negative 1', array());
    $opinion2 = $this->configureOpinion('dummy name 2', 'dummy surname 2', 'dummy image 2', 'dummy msg 2', 'dummy num replies 2', 'dummy num positive 2', 'dummy num negative 2', array());

    $result = $this->configureResultOnGetOpinions(array($opinion1, $opinion2));

    $expected = array('opinions'  => array(
      $this->getExpectedOpinion($opinion1, array()),
      $this->getExpectedOpinion($opinion2, array())
    ));

    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
  * method: getOpinions
  * when: called
  * with: twoOpinionsWithReplies
  * should: correct
  */
  public function test_getOpinions_called_twoOpinionsWithReplies_correct()
  {

    $comment1 = $this->configureComment('dummy user image comment 1', 'dummy name comment 1', 'dummy surname comment 1', 'dummy msg comment 1');
    $comment2 = $this->configureComment('dummy user image comment 2', 'dummy name comment 2', 'dummy surname comment 2', 'dummy msg comment 2');
    $comment3 = $this->configureComment('dummy user image comment 3', 'dummy name comment 3', 'dummy surname comment 3', 'dummy msg comment 3');
    $comment4 = $this->configureComment('dummy user image comment 4', 'dummy name comment 4', 'dummy surname comment 4', 'dummy msg comment 4');

    $comments1 = array($comment1, $comment2);
    $comments2 = array($comment3, $comment4);

    $opinion1 = $this->configureOpinion('dummy name 1', 'dummy surname 1', 'dummy image 1', 'dummy msg 1', 'dummy num replies 1', 'dummy num positive 1', 'dummy num negative 1', $comments1);
    $opinion2 = $this->configureOpinion('dummy name 2', 'dummy surname 2', 'dummy image 2', 'dummy msg 2', 'dummy num replies 2', 'dummy num positive 2', 'dummy num negative 2', $comments2);

    $result = $this->configureResultOnGetOpinions(array($opinion1, $opinion2));

    $expected = array('opinions'  => array(
      $this->getExpectedOpinion($opinion1, array($this->getExpectedComment($comment1), $this->getExpectedComment($comment2))),
      $this->getExpectedOpinion($opinion2, array($this->getExpectedComment($comment3), $this->getExpectedComment($comment4))),
    ));

    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $opinions
   * @return array
   */
  protected function configureResultOnGetOpinions($opinions)
  {
    $result = array(
      'data' => array(
        'opinions' => $opinions
      )
    );
    return $result;
  }

  /**
   * @param $name
   * @param $surname
   * @param $reviewerImg
   * @param $msg
   * @param $numReplies
   * @param $numPositive
   * @param $numNegative
   * @param $replies
   * @return array
   */
  protected function configureOpinion($name, $surname, $reviewerImg, $msg, $numReplies, $numPositive, $numNegative, $replies)
  {
    $opinion1 = array(
      'replies' => $replies,
      'opinion' => array(
        'user' => array(
          'file_url' => $reviewerImg,
          'name' => $name,
          'surname' => $surname
        ),
        'msg' => $msg,
        'num_replies' => $numReplies,
        'num_positive_joins' => $numPositive,
        'num_negative_joins' => $numNegative,
      )
    );
    return $opinion1;
  }

  /**
   * @param $opinion
   * @param $comments
   * @return array
   */
  public function getExpectedOpinion($opinion, $comments)
  {
    return array(
      'reviewer_img'    => $opinion['opinion']['user']['file_url'],
      'reviewer_name'   => $opinion['opinion']['user']['name'].' '.$opinion['opinion']['user']['surname'],
      'reviewer_review' => $opinion['opinion']['msg'],
      'num_comments'    => $opinion['opinion']['num_replies'],
      'num_positives'   => $opinion['opinion']['num_positive_joins'],
      'num_negatives'   => $opinion['opinion']['num_negative_joins'],
      'comments'        => $comments
    );
  }

  /**
   * @param $authorImg
   * @param $name
   * @param $surname
   * @param $msg
   * @return array
   */
  protected function configureComment($authorImg, $name, $surname, $msg)
  {
    $comment1 = array(
      'user' => array(
        'file_url' => $authorImg,
        'name' => $name,
        'surname' => $surname
      ),
      'msg' => $msg
    );
    return $comment1;
  }

  /**
   * @param $comment
   * @return array
   */
  public function getExpectedComment($comment)
  {
    return array(
      'author_img'    => $comment['user']['file_url'],
      'user_name'     => $comment['user']['name'].' '.$comment['user']['surname'],
      'comment_text'  => $comment['msg']
    );
  }


}