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
 * Class SEOComment
 * @package Communify\SEO\parsers
 */
class SEOComment extends C2AbstractFactorizable implements ISEOParser
{

  /**
   * Get comment information from array result.
   *
   * @param $comment
   * @return array
   */
  public function get($comment)
  {
    return array(
      'author_img'    => $comment['user']['file_url'],
      'comment_text'  => $comment['msg'],
      'reply_date'    => date('d/m/Y', $comment['epoch']),
      'user_name'     => $comment['user']['name'].' '.$comment['user']['surname'],
    );
  }

}