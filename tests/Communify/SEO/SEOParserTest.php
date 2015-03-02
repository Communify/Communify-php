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
   * @param $result
   * @return SEOParser
   * @throws \Communify\SEO\SEOException
   */
  protected function configureSut($result)
  {
    return SEOParser::factory($result);
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
  }

  /**
  * method: getLang
  * when: called
  * with: noLanguageId
  * should:
  */
  public function test_getLang_called_noLanguageId_()
  {
  
  }
  
  /**
  * dataProvider getTopicData
  */
  public function getTopicData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: getTopic
  * when: called
  * with:
  * should: correct
   * @dataProvider getTopicData
  */
  public function test_getTopic_called__correct($allowRatings)
  {
    $numOpinions = 'dummy num opinions';
    $topicTitle = 'dummy topic title';
    $topicImg = 'dummy topic img';
    $topicDesc = 'dummy topic desc';
    $name = 'dummy user name';
    $surname = 'dummy user surname';
    $reviewAverage = 'dummy review average';

    $result = array(
      'data'  => array(
        'topic' => array(
          'site'  => array(
            'title'           => $topicTitle,
            'file_url'        => $topicImg,
            'description'     => $topicDesc,
            'user'            => array(
              'name'    => $name,
              'surname' => $surname
            ),
            'allow_ratings'   => $allowRatings,
            'average_ratings'  => $reviewAverage
          ),
          'ideas' => $numOpinions
        )
      )
    );

    $expected = array(
      'allow_ratings'       => $allowRatings,
      'num_opinions'        => $numOpinions,
      'review_average'      => $allowRatings ? $reviewAverage : '',
      'topic_author'        => $name.' '.$surname,
      'topic_description'   => $topicDesc,
      'topic_img'           => $topicImg,
      'topic_title'         => $topicTitle,
    );

    $actual = $this->configureSut($result)->getTopic();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getOpinionsNoOpinionsReturnEmptyData
  */
  public function getOpinionsNoOpinionsReturnEmptyData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: getOpinions
  * when: called
  * with: noOpinions
  * should: returnEmpty
   * @dataProvider getOpinionsNoOpinionsReturnEmptyData
  */
  public function test_getOpinions_called_noOpinions_returnEmpty($allowRatings)
  {
    $result = $this->configureResultOnGetOpinions(array(), $allowRatings);
    $expected = array('opinions'  => array());
    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getOpinionsTwoOpinionsWithNoRepliesData
  */
  public function getOpinionsTwoOpinionsWithNoRepliesData()
  {
    return array(
      array(true),
      array(false),
    );
  }

  /**
  * method: getOpinions
  * when: called
  * with: twoOpinionsWithNoReplies
  * should: correct
   * @dataProvider getOpinionsTwoOpinionsWithNoRepliesData
  */
  public function test_getOpinions_called_twoOpinionsWithNoReplies_correct($allowRatings)
  {
    $opinion1 = $this->configureOpinion('dummy name 1', 'dummy surname 1', 'dummy image 1', 'dummy msg 1', 'dummy num replies 1', 'dummy num positive 1', 'dummy num negative 1', 1234567, 1, array());
    $opinion2 = $this->configureOpinion('dummy name 2', 'dummy surname 2', 'dummy image 2', 'dummy msg 2', 'dummy num replies 2', 'dummy num positive 2', 'dummy num negative 2', 12345678, 2, array());

    $result = $this->configureResultOnGetOpinions(array($opinion1, $opinion2), $allowRatings);

    $expected = array('opinions'  => array(
      $this->getExpectedOpinion($opinion1, array(), $allowRatings),
      $this->getExpectedOpinion($opinion2, array(), $allowRatings)
    ));

    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
  * dataProvider getOpinionsTwoOpinionsWithRepliesData
  */
  public function getOpinionsTwoOpinionsWithRepliesData()
  {
    return array(
      array(true),
      array(false)
    );
  }

  /**
  * method: getOpinions
  * when: called
  * with: twoOpinionsWithReplies
  * should: correct
   * @dataProvider getOpinionsTwoOpinionsWithRepliesData
  */
  public function test_getOpinions_called_twoOpinionsWithReplies_correct($allowRatings)
  {

    $comment1 = $this->configureComment('dummy user image comment 1', 'dummy name comment 1', 'dummy surname comment 1', 'dummy msg comment 1', 123456);
    $comment2 = $this->configureComment('dummy user image comment 2', 'dummy name comment 2', 'dummy surname comment 2', 'dummy msg comment 2', 1234567);
    $comment3 = $this->configureComment('dummy user image comment 3', 'dummy name comment 3', 'dummy surname comment 3', 'dummy msg comment 3', 12345678);
    $comment4 = $this->configureComment('dummy user image comment 4', 'dummy name comment 4', 'dummy surname comment 4', 'dummy msg comment 4', 123456789);

    $comments1 = array($comment1, $comment2);
    $comments2 = array($comment3, $comment4);

    $opinion1 = $this->configureOpinion('dummy name 1', 'dummy surname 1', 'dummy image 1', 'dummy msg 1', 'dummy num replies 1', 'dummy num positive 1', 'dummy num negative 1', 12345678, 1, $comments1);
    $opinion2 = $this->configureOpinion('dummy name 2', 'dummy surname 2', 'dummy image 2', 'dummy msg 2', 'dummy num replies 2', 'dummy num positive 2', 'dummy num negative 2', 123456789, 2, $comments2);

    $result = $this->configureResultOnGetOpinions(array($opinion1, $opinion2), $allowRatings);

    $expected = array('opinions'  => array(
      $this->getExpectedOpinion($opinion1, array($this->getExpectedComment($comment1), $this->getExpectedComment($comment2)), $allowRatings),
      $this->getExpectedOpinion($opinion2, array($this->getExpectedComment($comment3), $this->getExpectedComment($comment4)), $allowRatings),
    ));

    $actual = $this->configureSut($result)->getOpinions();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $opinions
   * @param $allowRatings
   * @return array
   */
  protected function configureResultOnGetOpinions($opinions, $allowRatings)
  {
    $result = array(
      'data' => array(
        'opinions' => $opinions,
        'topic' => array(
          'site'  => array(
            'allow_ratings' => $allowRatings
          )
        )
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
  protected function configureOpinion($name, $surname, $reviewerImg, $msg, $numReplies, $numPositive, $numNegative, $epoch, $rating, $replies)
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
        'epoch' => $epoch,
        'rating'  => $rating
      )
    );
    return $opinion1;
  }

  /**
   * @param $opinion
   * @param $comments
   * @return array
   */
  public function getExpectedOpinion($opinion, $comments, $allowRatings)
  {
    return array(
      'comments'        => $comments,
      'num_comments'    => $opinion['opinion']['num_replies'],
      'num_negatives'   => $opinion['opinion']['num_negative_joins'],
      'num_positives'   => $opinion['opinion']['num_positive_joins'],
      'opinion_date'    => date('d/m/Y', $opinion['opinion']['epoch']),
      'reviewer_img'    => $opinion['opinion']['user']['file_url'],
      'reviewer_name'   => $opinion['opinion']['user']['name'].' '.$opinion['opinion']['user']['surname'],
      'reviewer_rating' => $allowRatings ? $opinion['opinion']['rating'] : '',
      'reviewer_review' => $opinion['opinion']['msg'],
    );
  }

  /**
   * @param $authorImg
   * @param $name
   * @param $surname
   * @param $msg
   * @return array
   */
  protected function configureComment($authorImg, $name, $surname, $msg, $epoch)
  {
    $comment1 = array(
      'user' => array(
        'file_url' => $authorImg,
        'name' => $name,
        'surname' => $surname
      ),
      'msg' => $msg,
      'epoch' => $epoch
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
      'comment_text'  => $comment['msg'],
      'reply_date'    => date('d/m/Y', $comment['epoch'])
    );
  }

  /**
   * @param $allowRatings
   * @return array
   */
  protected function configureFactoryResult($allowRatings)
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
  protected function assertFactory($allowRatings, $actual, $result)
  {
    $this->assertInstanceOf('Communify\SEO\SEOParser', $actual);
    $this->assertAttributeEquals($result, 'result', $actual);
    $this->assertAttributeEquals($allowRatings, 'allowRatings', $actual);
  }


}