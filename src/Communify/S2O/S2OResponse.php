<?php
/**
 * Copyright 2014 Communify.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://dev.communify.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Communify\S2O;

use Guzzle\Http\Message\Response;

/**
 * Class S2OResponse
 * @package Communify\S2O
 */
class S2OResponse
{

  const STATUS_OK   = 'ok';
  const STATUS_KO   = 'ko';

  /**
   * @var S2OMetasArray
   */
  private $metas;

  /**
   * @var S2OValidator
   */
  private $validator;

  /**
   * @param S2OValidator $validator
   * @param S2OMetasArray $metas
   */
  function __construct(S2OValidator $validator = null, S2OMetasArray $metas = null)
  {
    if($validator == null)
    {
      $validator = S2OValidator::factory();
    }

    if($metas == null)
    {
      $metas = S2OMetasArray::factory();
    }

    $this->metas = $metas;
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
   * @param Response $response
   */
  public function set(Response $response)
  {
    try
    {
      $data = $response->json();
      $this->validator->checkData($data);
      foreach($data['data'] as $key => $value)
      {
        $this->metas->push(S2OMeta::OK_BASE_NAME.$key, base64_encode(json_encode($value)));
      }
    }
    catch(S2OException $e)
    {
      $error = $e->getMessage();

      switch($error)
      {
        case S2OMeta::KO_ERROR_NAME:
          $msg = $data['data']['message'];
          break;

        default:
          $msg = S2OMeta::$MESSAGES[$error];
          break;
      }

      $this->metas->push($error, $msg);
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
   * @param S2OMeta[] $metas
   */
  public function setMetas($metas)
  {
    $this->metas = $metas;
  }

} 