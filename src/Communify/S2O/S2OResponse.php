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

use Communify\C2\abstracts\C2AbstractResponse;
use Communify\C2\C2Exception;
use Communify\C2\C2Meta;
use Communify\C2\C2MetaIterator;
use Communify\C2\C2Validator;
use Communify\C2\interfaces\IC2Exception;
use Guzzle\Http\Message\Response;

/**
 * Class S2OResponse
 * @package Communify\S2O
 */
class S2OResponse extends C2AbstractResponse
{

  /**
   * @var C2MetaIterator
   */
  private $metas;

  /**
   * @var String
   */
  private $url;

  /**
   * @var bool
   */
  private $error;

  /**
   * Create S2OValidator.
   *
   * @param C2Validator $validator
   * @param C2MetaIterator $metas
   * @param null $url
   */
  function __construct(C2Validator $validator = null, C2MetaIterator $metas = null, $url = null)
  {

    if($metas == null)
    {
      $metas = C2MetaIterator::factory();
    }

    $this->metas = $metas;
    $this->url = null;
    $this->error = false;

    if($url != null)
    {
      $this->url = $url;
    }

    parent::__construct($validator);
  }

  /**
   * Set Guzzle Response data to S2OResponse as elements on S2OMetaIterator.
   *
   * @param Response $response
   */
  public function set(Response $response)
  {
    $data = $response->json();
    try
    {
      $this->validator->checkData($data);
      foreach($data['data'] as $key => $value)
      {
        $this->metas->push(C2Meta::OK_BASE_NAME.$key, $value, true);
      }
    }
    catch(C2Exception $e)
    {
      $error = $e->getMessage();

      switch($error)
      {
        case IC2Exception::KO_ERROR_NAME:
          $msg = $data['data']['message'];
          break;

        default:
          $msg = C2Meta::$MESSAGES[$error];
          break;
      }
      $this->metas->push($error, $msg);
      $this->error = true;
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

    if($html != '' && !$this->error)
    {
      //$html .= '<script src="'.$this->url.'/bower_components/scriptjs/dist/script.min.js"></script>';
      //$html .= '<script id="cfy-s2o-script" data-url="'.$this->url.'" src="'.$this->url.'/views/widget/s2o/bootstrap.js"></script>';
      $html .= '<script id="cfy-s2o-script" data-url="'.$this->url.'" src="'.$this->url.'/views/widget/s2o/s2o.min.js"></script>';
    }

    return $html;
  }

  /**
   * @return array
   */
  public function get()
  {
    $result = array();
    foreach($this->metas as $meta)
    {
      $result[$meta->getName()] = $meta->getContent();
    }

    return $result;
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

  /**
   * Set url attribute. Expected to be as: http://[env].yourcommunify.com/api/[env]
   * Save url as: http://[env].yourcommunify.com
   *
   * @param String $url
   */
  public function setUrl($url)
  {
    $urlArray = explode('/', $url);
    $n = count($urlArray);
    unset($urlArray[$n - 1]);
    unset($urlArray[$n - 2]);
    $this->url = implode('/', $urlArray);
  }

  /**
   * @param boolean $error
   */
  public function setError($error)
  {
    $this->error = $error;
  }

} 