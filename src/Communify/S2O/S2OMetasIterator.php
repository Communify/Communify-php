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

namespace Communify\S2O;

/**
 * Class S2OMeta
 * @package Communify\S2O
 */
class S2OMetasIterator implements \Iterator
{

  /**
   * @var int
   */
  private $position;

  /**
   * @var S2OMeta[]
   */
  private $array;

  /**
   * @var S2OFactory
   */
  private $factory;

  /**
   * Create S2OMetasIterator with dependency injection. Position and array with empty default values.
   *
   * @param S2OFactory $factory
   * @param int $position
   * @param array $array
   */
  function __construct(S2OFactory $factory = null, $position = 0, $array = array())
  {
    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }
    $this->position = $position;
    $this->array = $array;
    $this->factory = $factory;
  }

  /**
   * Create S2OMetasIterator.
   *
   * @return S2OMetasIterator
   */
  public static function factory()
  {
    return new S2OMetasIterator();
  }

  /**
   * Push meta on S2OMetasIterator.
   *
   * @param $name
   * @param $content
   */
  public function push($name, $content)
  {
    $meta = $this->factory->meta($name, $content);
    $this->array[] = $meta;
  }

  /**
   * Go to position as zero.
   */
  public function rewind()
  {
    $this->position = 0;
  }

  /**
   * Get current meta element on S2OMetaIterator.
   *
   * @return S2OMeta
   */
  public function current()
  {
    return $this->array[$this->position];
  }

  /**
   * Get current key on S2OMetasIterator.
   *
   * @return int
   */
  public function key()
  {
    return $this->position;
  }

  /**
   * Increments position.
   */
  public function next()
  {
    $this->position++;
  }

  /**
   * Check if is a valid position on S2OMetasIterator.
   *
   * @return bool
   */
  public function valid()
  {
    return isset($this->array[$this->position]);
  }

  /**
   * Set S2OMeta's array.
   *
   * @param S2OMeta[] $array
   */
  public function setArray($array)
  {
    $this->array = $array;
  }

} 