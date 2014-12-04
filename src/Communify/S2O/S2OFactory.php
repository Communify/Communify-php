<?php

namespace Communify\S2O;



use Guzzle\Http\Client;

class S2OFactory
{

  public static function factory()
  {
    return new S2OFactory();
  }

  /**
   * @param $data
   * @return S2OCredential
   * @throws S2OException
   */
  public function credential($data)
  {
    $credential = S2OCredential::factory();
    $credential->set($data);
    return $credential;
  }

  /**
   * @return S2OResponse
   */
  public function response($json)
  {
    return S2OResponse::factory();
  }

  /**
   * @return Client
   */
  public function httpClient()
  {
    return new Client();
  }

} 