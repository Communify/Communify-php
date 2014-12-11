<?php

namespace Communify\S2O;

/**
 * Class S2OMeta
 * @package Communify\S2O
 */
class S2OValidator
{

  /**
   * @return S2OValidator
   */
  public static function factory()
  {
    return new S2OValidator();
  }

  /**
   * @param $data
   * @return mixed
   * @throws S2OException
   */
  public function checkData($data)
  {
    if( !isset($data['status']) )
    {
      throw new S2OException(S2OMeta::STATUS_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] != S2OResponse::STATUS_KO && $data['status'] != S2OResponse::STATUS_OK )
    {
      throw new S2OException(S2OMeta::STATUS_VALUE_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( !isset($data['data']) )
    {
      throw new S2OException(S2OMeta::DATA_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] == S2OResponse::STATUS_KO && !isset($data['data']['message']) )
    {
      throw new S2OException(S2OMeta::MSG_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if($data['status'] == S2OResponse::STATUS_KO)
    {
      throw new S2OException(S2OMeta::KO_ERROR_NAME, S2OException::KO_ERROR);
    }

    return $data['status'];
  }

}