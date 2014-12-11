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
   * @return bool
   * @throws S2OException
   */
  public function checkData($data)
  {
    if( !isset($data['status']) )
    {
      throw new S2OException(S2OMeta::STATUS_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] != 'ko' && $data['status'] != 'ok' )
    {
      throw new S2OException(S2OMeta::STATUS_VALUE_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( !isset($data['data']) )
    {
      throw new S2OException(S2OMeta::DATA_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    if( $data['status'] == 'ko' && !isset($data['data']['message']) )
    {
      throw new S2OException(S2OMeta::MSG_ERROR_NAME, S2OException::PARAM_ERROR);
    }

    return true;
  }

}