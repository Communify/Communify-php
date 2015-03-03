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
   * @var SEOFactory
   */
  private $factory;

  /**
   * @param $result
   * @param $allowRatings
   * @param SEOFactory $factory
   */
  function __construct($result, $allowRatings, SEOFactory $factory = null)
  {

    if($factory == null)
    {
      $factory = SEOFactory::factory();
    }

    $this->result = $result;
    $this->allowRatings = $allowRatings;
    $this->factory = $factory;
  }

  /**
   * @param null $result
   * @param null $allowRatings
   * @param SEOFactory $factory
   * @return SEOParser
   * @throws SEOException
   */
  public static function factory( $result=null, $allowRatings = null, SEOFactory $factory = null )
  {
    if($result == null)
    {
      throw new SEOException('Invalid result: null value is not allowed');
    }

    if($allowRatings === null)
    {
      $allowRatings = (bool) $result['data']['topic']['site']['allow_ratings'];
    }

    return new SEOParser($result, $allowRatings, $factory);
  }

  /**
   * Default value english.
   *
   * @return array
   */
  public function getLang()
  {
    return $this->factory->languageParser()->get($this->result['data']['topic']['public_configurations']);
  }

  /**
   * Get topic information
   *
   * @return array
   */
  public function getTopic()
  {
    return $this->factory->topicParser()->get($this->result['data']['topic'], $this->allowRatings);
  }

  /**
   * Get opinions information
   *
   * @return array
   */
  public function getOpinions()
  {
    $opinions = array('opinions' => array());

    $opinionParser = $this->factory->opinionParser();
    foreach($this->result['data']['opinions'] as $opinion)
    {
      $opinions['opinions'][] = $opinionParser->get($opinion, $this->allowRatings);
    }

    return $opinions;
  }

}