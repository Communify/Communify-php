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

namespace Communify\SEO;


use Communify\C2\abstracts\C2AbstractFactorizable;

/**
 * Class SEOParser
 * @package Communify\SEO
 *
 */
class SEOParser extends C2AbstractFactorizable
{

  /**
   * @var array
   */
  private $result;

  /**
   * @var bool
   */
  private $allowRatings;

  /**
   * @param $result
   * @param $allowRatings
   */
  function __construct($result, $allowRatings)
  {
    $this->result = $result;
    $this->allowRatings = $allowRatings;
  }

  /**
   * @param null $result
   * @param null $allowRatings
   * @return SEOParser
   * @throws SEOException
   */
  public static function factory( $result=null, $allowRatings = null )
  {
    if($result == null)
    {
      throw new SEOException('Invalid result: null value is not allowed');
    }

    if($allowRatings === null)
    {
      $allowRatings = (bool) $result['data']['topic']['site']['allow_ratings'];
    }

    return new SEOParser($result, $allowRatings);
  }

  /**
   * Default value english.
   *
   * @return array
   */
  public function getLang()
  {
    $lang = 'en';
    foreach($this->result['data']['topic']['public_configurations'] as $config)
    {
      if($config['id'] == 'language_id')
      {
        $lang = $config['value'];
      }
    }

    return array(
      'language'  => $lang
    );
  }

  /**
   * Get topic information
   *
   * @return array
   */
  public function getTopic()
  {
    return array(
      'allow_ratings'       => $this->allowRatings,
      'num_opinions'        => $this->result['data']['topic']['ideas'],
      'review_average'      => $this->allowRatings ? $this->result['data']['topic']['site']['average_ratings'] : '',
      'topic_author'        => $this->result['data']['topic']['site']['user']['name'].' '.$this->result['data']['topic']['site']['user']['surname'],
      'topic_description'   => $this->result['data']['topic']['site']['description'],
      'topic_img'           => $this->result['data']['topic']['site']['file_url'],
      'topic_title'         => $this->result['data']['topic']['site']['title'],
    );
  }

  /**
   * Get opinions information
   *
   * @return array
   */
  public function getOpinions()
  {
    $opinions = array('opinions' => array());

    foreach($this->result['data']['opinions'] as $opinion)
    {

      $comments = array();
      foreach($opinion['replies'] as $comment)
      {
        $comments[] = array(
          'author_img'    => $comment['user']['file_url'],
          'comment_text'  => $comment['msg'],
          'reply_date'    => date('d/m/Y', $comment['epoch']),
          'user_name'     => $comment['user']['name'].' '.$comment['user']['surname'],
        );
      }

      $opinions['opinions'][] = array(
        'comments'        => $comments,
        'num_comments'    => $opinion['opinion']['num_replies'],
        'num_negatives'   => $opinion['opinion']['num_negative_joins'],
        'num_positives'   => $opinion['opinion']['num_positive_joins'],
        'opinion_date'    => date('d/m/Y', $opinion['opinion']['epoch']),
        'reviewer_img'    => $opinion['opinion']['user']['file_url'],
        'reviewer_name'   => $opinion['opinion']['user']['name'].' '.$opinion['opinion']['user']['surname'],
        'reviewer_rating' => $this->allowRatings ? $opinion['opinion']['rating'] : '',
        'reviewer_review' => $opinion['opinion']['msg'],
      );
    }

    return $opinions;
  }

}