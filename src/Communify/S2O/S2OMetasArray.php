<?php

namespace Communify\S2O;

/**
 * Class S2OMeta
 * @package Communify\S2O
 */
class S2OMetasArray implements \Iterator
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
   * @return S2OMetasArray
   */
  public static function factory()
  {
    return new S2OMetasArray();
  }

  public function push($name, $content)
  {
    $meta = $this->factory->meta($name, $content);
    $this->array[] = $meta;
  }

  /**
   *
   */
  public function rewind()
  {
    $this->position = 0;
  }

  /**
   * @return S2OMeta
   */
  public function current()
  {
    return $this->array[$this->position];
  }

  /**
   * @return int
   */
  public function key()
  {
    return $this->position;
  }

  /**
   *
   */
  public function next()
  {
    $this->position++;
  }

  /**
   * @return bool
   */
  public function valid()
  {
    return isset($this->array[$this->position]);
  }

  /**
   * @param S2OMeta[] $array
   */
  public function setArray($array)
  {
    $this->array = $array;
  }



} 