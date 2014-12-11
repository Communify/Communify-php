<?php
/**
 * Created by PhpStorm.
 * User: pitu
 * Date: 4/12/14
 * Time: 12:22
 */

namespace Communify\S2O;
use Guzzle\Http\Client;

/**
 * Class S2OConnector
 * @package Communify\S2O
 */
class S2OConnector
{

  /**
   * @var S2OFactory
   */
  private $factory;

  /**
   * @var \Guzzle\Http\Client
   */
  private $client;

  function __construct(S2OFactory $factory = null, Client $client = null)
  {
    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }
    if($client == null)
    {
      $factory->httpClient();
    }
    $this->factory = $factory;
    $this->client = $client;
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
    $request = $this->client->createRequest('POST', 'http://10.0.1.126:80/api/user/authentication/login', null, $credential->get());
    $response = $this->client->send($request);
    $data = $response->json();
    $s2OResponse = $this->factory->response();
    $s2OResponse->set($data);
    return $s2OResponse;
  }



}