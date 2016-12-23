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

  private static $factoryGeneratorFunction = [ 1 => 'userConversationTopicParser',
                                          2 => 'userConversationTopicParser',
                                          3 => 'leadsTopicParser',
                                          5 => 'enrichedTopicParser'];

  /**
   * @var array
   */
  private $result;


  /**
   * @var SEOFactory
   */
  private $factory;

  /**
   * @var array
   */
  private $topic;


  /**
   * @var int
   */
  private $topicTypeId;




  /**
   * @param $result
   * @param SEOFactory $factory
   */
  function __construct($result, SEOFactory $factory = null)
  {

    if($factory == null)
    {
      $factory = SEOFactory::factory();
    }

    $this->result = $result;
    $this->factory = $factory;
    $this->topic = $this->result['data']['sites'][0]['site'];
    $this->topicTypeId = $this->topic['type_configuration']['id'];
    $this->topic = array_merge($this->topic, $this->getLang());
  }

  /**
   * @param null $result
   * @param SEOFactory $factory
   * @return SEOParser
   * @throws SEOException
   */
  public static function factory( $result=null, SEOFactory $factory = null )
  {
    if($result == null)
    {
      throw new SEOException('Invalid result: null value is not allowed');
    }

    return new SEOParser($result, $factory);
  }

  /**
   * Default value english.
   *
   * @return array
   */
  public function getLang()
  {
    return $this->factory->languageParser()->get($this->result['data']['public_configurations']);
  }

  /**
   * Get topic information
   *
   * @return array
   */
  public function getTopic()
  {
    $parser = self::$factoryGeneratorFunction[$this->topicTypeId];
    return $this->factory->$parser()->get($this->topic);
  }


}