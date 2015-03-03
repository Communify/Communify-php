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

use Communify\SEO\parsers\SEOOpinion;

/**
 * @covers Communify\SEO\parsers\SEOOpinion
 */
class SEOOpinionTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $commentParser;

  public function setUp()
  {
    $this->commentParser = $this->getMock('Communify\SEO\parsers\SEOComment');
  }

  /**
   * @return SEOOpinion
   */
  public function configureSut()
  {
    return new SEOOpinion($this->commentParser);
  }

  /**
  * method: constructor
  * when: called
  * with: noInjected
  * should: correct
  */
  public function test_constructor_called_noInjected_correct()
  {
    $sut = new SEOOpinion();
    $this->assertAttributeInstanceOf('Communify\SEO\parsers\SEOComment', 'commentParser', $sut);
  }

  /**
  * dataProvider getNoRepliesData
  */
  public function getNoRepliesData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: get
  * when: called
  * with: noReplies
  * should: correct
   * @dataProvider getNoRepliesData
  */
  public function test_get_called_noReplies_correct($allowRatings)
  {
    $replies = array();
    $comments = array();
    $this->commentParser->expects($this->never())
      ->method('get');
    $this->configureExecuteAndAssertGet($allowRatings, $replies, $comments);
  }

  /**
  * dataProvider getData
  */
  public function getData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: get
  * when: called
  * with:
  * should: correct
   * @dataProvider getData
  */
  public function test_get_called__correct($allowRatings)
  {
    $reply1 = array('dummy reply 1');
    $reply2 = array('dummy reply 2');
    $reply3 = array('dummy reply 3');
    $comment1 = array('dummy comment 1');
    $comment2 = array('dummy comment 2');
    $comment3 = array('dummy comment 3');
    $replies = array($reply1, $reply2, $reply3);
    $comments = array($comment1, $comment2, $comment3);
    $this->configureCommentParserGet($this->at(0), $reply1, $comment1);
    $this->configureCommentParserGet($this->at(1), $reply2, $comment2);
    $this->configureCommentParserGet($this->at(2), $reply3, $comment3);
    $this->configureExecuteAndAssertGet($allowRatings, $replies, $comments);
  }

  /**
   * @param $allowRatings
   * @param $replies
   * @param $comments
   */
  protected function configureExecuteAndAssertGet($allowRatings, $replies, $comments)
  {
    $numReplies = 'dummy num replies';
    $numNegativeJoins = 'dummy num negative joins';
    $numPositiveJoins = 'dummy num positive joins';
    $epoch = 456789;
    $rating = 'dummy rating';
    $msg = 'dummy message';
    $fileUrl = 'dummy file url';
    $name = 'dummy name';
    $surname = 'dummy surname';
    $opinion = array(
      'replies' => $replies,
      'opinion' => array(
        'num_replies' => $numReplies,
        'num_negative_joins' => $numNegativeJoins,
        'num_positive_joins' => $numPositiveJoins,
        'epoch' => $epoch,
        'rating' => $rating,
        'msg' => $msg,
        'user' => array(
          'file_url' => $fileUrl,
          'name' => $name,
          'surname' => $surname,
        )
      )
    );
    $expected = array(
      'comments' => $comments,
      'num_comments' => $numReplies,
      'num_negatives' => $numNegativeJoins,
      'num_positives' => $numPositiveJoins,
      'opinion_date' => date('d/m/Y', $epoch),
      'reviewer_img' => $fileUrl,
      'reviewer_name' => $name . ' ' . $surname,
      'reviewer_rating' => $allowRatings ? $rating : '',
      'reviewer_review' => $msg
    );
    $actual = $this->configureSut()->get($opinion, $allowRatings);
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $times
   * @param $reply1
   * @param $comment1
   */
  protected function configureCommentParserGet($times, $reply1, $comment1)
  {
    $this->commentParser->expects($times)
      ->method('get')
      ->with($reply1)
      ->will($this->returnValue($comment1));
  }

}