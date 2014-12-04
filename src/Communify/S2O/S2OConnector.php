<?php
/**
 * Created by PhpStorm.
 * User: pitu
 * Date: 4/12/14
 * Time: 12:22
 */

namespace Communify\S2O;


class S2OConnector
{

  /**
   * @var S2OFactory
   */
  private $factory;

  function __construct(S2OFactory $factory = null)
  {
    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }
    $this->factory = $factory;
  }

  /**
   * @return S2OConnector
   */
  public static function factory()
  {
    return new S2OConnector();
  }

  /**
   * @param S2OCredential $credential
   * @return S2OResponse
   */
  public function login(S2OCredential $credential)
  {
    $client = $this->factory->httpClient();
    $res = $client->post('http://communify.com', $credential->get());
    $json = $res->getBody();
    return $this->factory->response($json);
  }



}