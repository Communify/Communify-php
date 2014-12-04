<?php

namespace Communify\S2O;


class S2OClient
{

  private $connector;
  private $factory;


  /**
   * @param S2OConnector $connector
   * @param S2OFactory $factory
   */
  function __construct(S2OConnector $connector = null, S2OFactory $factory = null)
  {
    if($connector == null)
    {
      $connector = S2OConnector::factory();
    }

    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }

    $this->connector = $connector;
    $this->factory = $factory;
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
   * @param $data
   * @return S2OResponse
   * @throws S2OException
   */
  public function login($data)
  {
    $credential = $this->factory->credential($data);
    return $this->connector->login($credential);
  }


} 