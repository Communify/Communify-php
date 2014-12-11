<?php

namespace Communify\S2O;

/**
 * Class S2OCredential
 * @package Communify\S2O
 */
class S2OCredential
{

  /**
   * @var array
   */
  private $data;

  /**
   * @return S2OCredential
   */
  public static function factory()
  {
    return new S2OCredential();
  }

  /**
   * @param array $data
   * @throws S2OException
   */
  public function set($ssid, $data)
  {
    $this->data = array(
      'ssid'  => $ssid,
      'info'  => $data
    );
  }

  /**
   * @return array
   */
  public function get()
  {
    return json_encode($this->data);
  }

  /**
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }

}