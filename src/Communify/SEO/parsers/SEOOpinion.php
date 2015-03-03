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

namespace Communify\SEO\parsers;


use Communify\C2\abstracts\C2AbstractFactorizable;
use Communify\SEO\parsers\interfaces\ISEOParser;

/**
 * Class SEOOpinion
 * @package Communify\SEO\parsers
 */
class SEOOpinion extends C2AbstractFactorizable implements ISEOParser
{

  /**
   * @var SEOComment
   */
  private $commentParser;

  /**
   * @param SEOComment $commentParser
   */
  function __construct(SEOComment $commentParser = null)
  {
    if($commentParser == null)
    {
      $commentParser = SEOComment::factory();
    }

    $this->commentParser = $commentParser;
  }


  /**
   * Get opinion information from array result.
   *
   * @param $opinion
   * @param $allowRatings
   * @return array
   */
  public function get($opinion, $allowRatings = false)
  {
    $comments = array();
    foreach($opinion['replies'] as $comment)
    {
      $comments[] = $this->commentParser->get($comment);
    }

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

}