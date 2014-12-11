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

use Communify\C2\C2Encryptor;
use Communify\C2\C2Meta;
use Communify\C2\C2MetasIterator;
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
   * @var C2MetasIterator
   */
  private $metas;

  /**
   * @var S2OValidator
   */
  private $validator;

  /**
   * @var C2Encryptor
   */
  private $encryptor;

  /**
   * Create S2OValidator.
   *
   * @param S2OValidator $validator
   * @param C2MetasIterator $metas
   * @param C2Encryptor $encryptor
   */
  function __construct(S2OValidator $validator = null, C2MetasIterator $metas = null, C2Encryptor $encryptor = null)
  {
    if($validator == null)
    {
      $validator = S2OValidator::factory();
    }

    if($metas == null)
    {
      $metas = C2MetasIterator::factory();
    }

    if($encryptor == null)
    {
      $encryptor = C2Encryptor::factory();
    }

    $this->metas = $metas;
    $this->validator = $validator;
    $this->encryptor = $encryptor;
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
   * Set Guzzle Response data to S2OResponse as elements on S2OMetasIterator.
   *
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
        $value64 = $this->encryptor->execute($value);
        $this->metas->push(C2Meta::OK_BASE_NAME.$key, $value64);
      }
    }
    catch(S2OException $e)
    {
      $error = $e->getMessage();

      switch($error)
      {
        case C2Meta::KO_ERROR_NAME:
          $msg = $data['data']['message'];
          break;

        default:
          $msg = C2Meta::$MESSAGES[$error];
          break;
      }

      $this->metas->push($error, $msg);
    }
  }

  /**
   * Get HTML metas string.
   *
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
   * Set S2OMeta's array.
   *
   * @param C2Meta[] $metas
   */
  public function setMetas($metas)
  {
    $this->metas = $metas;
  }

} 