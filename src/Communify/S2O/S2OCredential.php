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

  private $url;

  function __construct()
  {
    $this->url = 'https://communify.com/api';
  }


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
    if( isset($data['communify_url']) )
    {
      $this->url = $data['communify_url'];
      unset($data['communify_url']);
    }
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

  /**
   * @return mixed
   */
  public function getUrl()
  {
    return $this->url;
  }

}