<?php

namespace Communify\S2O;


class S2OCredential
{

  const ATTR_NEEDED_ERROR = 102;
  const TYPE_ARRAY_ERROR = 101;

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
  public function set($data)
  {

    if( !is_array($data))
    {
      throw new S2OException('Data must be an array.', self::TYPE_ARRAY_ERROR);
    }

    if(!isset($data['ssid']))
    {
      throw new S2OException('SSID must be included on data array.', self::ATTR_NEEDED_ERROR);
    }

    if(!isset($data['name']))
    {
      throw new S2OException('Name must be included on data array.', self::ATTR_NEEDED_ERROR);
    }

    if(!isset($data['surname']))
    {
      throw new S2OException('Surname must be included on data array.', self::ATTR_NEEDED_ERROR);
    }

    if(!isset($data['email']))
    {
      throw new S2OException('Email must be included on data array.', self::ATTR_NEEDED_ERROR);
    }

    $this->data = $data;

  }

  /**
   * @return array
   */
  public function get()
  {
    return $this->data;
  }


} 