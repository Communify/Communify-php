<?php

namespace Communify\S2O;

use Guzzle\Http\Client;

/**
 * Class S2OFactory
 * @package Communify\S2O
 */
class S2OFactory
{

  /**
   * @return S2OFactory
   */
  public static function factory()
  {
    return new S2OFactory();
  }

  /**
   * @return S2OConnector
   */
  public function connector()
  {
    return S2OConnector::factory();
  }

  /**
   * @return S2OCredential
   * @throws S2OException
   */
  public function credential()
  {
    return S2OCredential::factory();
  }

  /**
   * @return S2OResponse
   */
  public function response()
  {
    return S2OResponse::factory();
  }

  /**
   * @param $name
   * @param $content
   * @return S2OResponse
   */
  public function meta($name, $content)
  {
    return S2OMeta::factory($name, $content);
  }

  /**
   * @return Client
   */
  public function httpClient()
  {
    return new Client();
  }

}