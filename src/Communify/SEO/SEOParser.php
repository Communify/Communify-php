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

  private $result;

  function __construct($result)
  {
    $this->result = $result;
  }

  /**
   * @param null $result
   * @return SEOParser
   * @throws SEOException
   */
  public static function factory( $result=null )
  {
    if($result == null)
    {
      throw new SEOException('Invalid result: null value is not allowed');
    }

    return new SEOParser($result);
  }

  /**
   * Get topic information
   *
   * @return array
   */
  public function getTopic()
  {
    return array(
      'topic_title'         => $this->result['data']['topic']['site']['title'],
      'topic_img'           => $this->result['data']['topic']['site']['file_url'],
      'topic_description'   => $this->result['data']['topic']['site']['description'],
      'topic_author'        => $this->result['data']['topic']['site']['user']['name'].' '.$this->result['data']['topic']['site']['user']['surname'],
      'num_opinions'        => $this->result['data']['topic']['ideas'],
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
          'user_name'     => $comment['user']['name'].' '.$comment['user']['surname'],
          'comment_text'  => $comment['msg']
        );
      }

      $opinions['opinions'][] = array(
        'reviewer_img'    => $opinion['opinion']['user']['file_url'],
        'reviewer_name'   => $opinion['opinion']['user']['name'].' '.$opinion['opinion']['user']['surname'],
        'reviewer_review' => $opinion['opinion']['msg'],
        'num_comments'    => $opinion['opinion']['num_replies'],
        'num_positives'   => $opinion['opinion']['num_positive_joins'],
        'num_negatives'   => $opinion['opinion']['num_negative_joins'],
        'comments'        => $comments
      );
    }

    return $opinions;
  }

}