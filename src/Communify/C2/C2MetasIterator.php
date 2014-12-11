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

namespace Communify\C2;

/**
 * Class C2Meta
 * @package Communify\C2
 */
class C2MetasIterator implements \Iterator
{

  /**
   * @var int
   */
  private $position;

  /**
   * @var C2Meta[]
   */
  private $array;

  /**
   * @var C2Factory
   */
  private $factory;

  /**
   * Create C2MetasIterator with dependency injection. Position and array with empty default values.
   *
   * @param C2Factory $factory
   * @param int $position
   * @param array $array
   */
  function __construct(C2Factory $factory = null, $position = 0, $array = array())
  {
    if($factory == null)
    {
      $factory = C2Factory::factory();
    }
    $this->position = $position;
    $this->array = $array;
    $this->factory = $factory;
  }

  /**
   * Create C2MetasIterator.
   *
   * @return C2MetasIterator
   */
  public static function factory()
  {
    return new C2MetasIterator();
  }

  /**
   * Push meta on C2MetasIterator.
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
   * Get current meta element on C2MetaIterator.
   *
   * @return C2Meta
   */
  public function current()
  {
    return $this->array[$this->position];
  }

  /**
   * Get current key on C2MetasIterator.
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
   * Check if is a valid position on C2MetasIterator.
   *
   * @return bool
   */
  public function valid()
  {
    return isset($this->array[$this->position]);
  }

  /**
   * Set C2Meta's array.
   *
   * @param C2Meta[] $array
   */
  public function setArray($array)
  {
    $this->array = $array;
  }

} 