<?php

namespace Communify\S2O;

/**
 * Class S2OResponse
 * @package Communify\S2O
 */
class S2OResponse
{

  const STATUS_OK   = 'ok';
  const STATUS_KO   = 'ko';

  /**
   * @var S2OMeta[]
   */
  private $metas;

  /**
   * @var S2OFactory
   */
  private $factory;

  private $validator;

  function __construct(S2OFactory $factory = null, S2OValidator $validator = null)
  {
    if($factory == null)
    {
      $factory = S2OFactory::factory();
    }

    if($validator == null)
    {
      $validator = S2OValidator::factory();
    }

    $this->metas = array();
    $this->factory = $factory;
    $this->validator = $validator;
  }

  /**
   * Create a S2OResponse.
   *
   * @return S2OResponse
   */
  public static function factory()
  {
    return new S2OResponse();
  }

  /**
   * @param $data
   */
  public function set($data)
  {
    try
    {
      $this->validator->checkData($data);
      switch($data['status'])
      {
        case self::STATUS_KO:
          $meta = $this->factory->meta(S2OMeta::KO_ERROR_NAME, $data['data']['message']);
          $this->metas[] = $meta;
          break;
        case self::STATUS_OK:
          foreach($data['data'] as $key => $value)
          {
            $meta = $this->factory->meta(S2OMeta::OK_BASE_NAME.$key, base64_encode(json_encode($value)));
            $this->metas[] = $meta;
          }
          break;
      }
    }
    catch(S2OException $e)
    {
      $error = $e->getMessage();
      $meta = $this->factory->meta($error, S2OMeta::$MESSAGES[$error]);
      $this->metas[] = $meta;
    }
  }

  /**
   * @return string
   */
  public function metas()
  {
    $html = '';
    foreach($this->metas as $meta)
    {
      $html .= $meta->getHtml();
    }
    return $html;
  }

  /**
   * @return S2OMeta[]
   */
  public function getMetas()
  {
    return $this->metas;
  }

  /**
   * @param S2OMeta[] $metas
   */
  public function setMetas($metas)
  {
    $this->metas = $metas;
  }

} 