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
use Communify\SEO\engines\SEOConversationsEngine;


/**
 * Class SEOUserConversationTopic
 * @package Communify\SEO\parsers
 */
class SEOUserConversationTopic extends C2AbstractFactorizable implements ISEOParser
{

  /**
   * @var SEOConversationsEngine
   */
  private $engine;

  /**
   * SEOUserConversationTopic constructor.
   *
   * @param SEOConversationsEngine|null $engine
   */
  function __construct(SEOConversationsEngine $engine = null)
  {
    if($engine == null)
    {
      $engine = SEOConversationsEngine::factory();
    }

    $this->engine = $engine;

  }


  /**
   * Get topic information from array result.
   *
   * @param $topic
   * @param bool $allowRatings
   * @return array
   */
  public function get($topic, $allowRatings = false)
  {
      $array =  array(
        'allow_ratings'       => $allowRatings,
        'num_ideas'           => $topic['num_ideas'],
        'review_average'      => $allowRatings ? $topic['average_ratings'] : '',
        'topic_author'        => htmlentities($topic['user']['name'].' '.$topic['user']['surname']),
        'topic_description'   => htmlentities($topic['description']),
        'topic_img'           => $topic['file_url'],
        'topic_title'         => htmlentities($topic['title']),
        'topic_name'          => htmlentities($topic['name']),
        'language'            => $topic['language']
      );

    return $this->engine->render($array);
  }

}