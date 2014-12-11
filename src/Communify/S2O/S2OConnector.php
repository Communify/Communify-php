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

  const SINGLE_SIGN_ON_API_METHOD = 'user/authentication/singleSignOnLogin';

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
      $client = $factory->httpClient();
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
    $url = $credential->getUrl();
    $request = $this->client->createRequest('POST', $url.'/'.self::SINGLE_SIGN_ON_API_METHOD, null, $credential->get());
    $response = $this->client->send($request);
    $s2OResponse = $this->factory->response();
    $s2OResponse->set($response);
    return $s2OResponse;
  }



}