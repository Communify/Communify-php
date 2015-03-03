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

use Communify\SEO\parsers\SEOComment;

/**
 * @covers Communify\SEO\parsers\SEOComment
 */
class SEOCommentTest extends \PHPUnit_Framework_TestCase
{

  /**
  * method: get
  * when: called
  * with:
  * should: correct
  */
  public function test_get_called__correct()
  {
    $authorImg = 'dummy author img';
    $name = 'dummy name';
    $surname = 'dummy surname';
    $msg = 'dummy message';
    $epoch = 345678;
    $comment = array(
      'user'  => array(
        'file_url'  => $authorImg,
        'name'      => $name,
        'surname'   => $surname
      ),
      'msg'   => $msg,
      'epoch' => $epoch
    );
    $expected = array(
      'author_img'    => $authorImg,
      'comment_text'  => $msg,
      'reply_date'    => date('d/m/Y', $epoch),
      'user_name'     => $name.' '.$surname
    );
    $sut = new SEOComment();
    $actual = $sut->get($comment);
    $this->assertEquals($expected, $actual);
  }

}