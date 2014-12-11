<?php

namespace Communify\S2O;

/**
 * Class S2OClient
 * @package Communify\S2O
 */
class S2OClient
{

  /**
   * @var S2OConnector
   */
  private $connector;

  /**
   * @var S2OFactory
   */
  private $factory;


  /**
   * Call without params on production purposes. Can use factory static method.
   *
   * @param S2OFactory $factory
   * @param S2OConnector $connector
   */
  function __construct(S2OFactory $factory = null, S2OConnector $connector = null)
  {
    if($connector == null)
    {
      $connector = S2OConnector::factory();
    }

    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }

    $this->factory = $factory;
    $this->connector = $connector;
  }

  /**
   * Create a S2OClient.
   *
   * @return S2OClient
   */
  public static function factory()
  {
    return new S2OClient();
  }

  /**
   * Makes single sign on possible.
   *
   * @param $ssid
   * @param $data
   * @return S2OResponse
   */
  public function login($ssid, $data)
  {
    $credential = $this->factory->credential();
    $credential->set($ssid, $data);
    return $this->connector->login($credential);
  }


} 