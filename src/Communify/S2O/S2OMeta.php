<?php

namespace Communify\S2O;

/**
 * Class S2OMeta
 * @package Communify\S2O
 */
class S2OMeta
{



  const STATUS_ERROR_NAME           = 'communify-error-json-status';
  const STATUS_VALUE_ERROR_NAME     = 'communify-error-status-value';
  const DATA_ERROR_NAME             = 'communify-error-json-data';
  const MSG_ERROR_NAME              = 'communify-error-json-msg';

  const KO_ERROR_NAME               = 'communify-error';
  const OK_BASE_NAME                = 'communify-';

  private $name;
  private $content;

  public static $MESSAGES = array(
    self::STATUS_ERROR_NAME         => 'Invalid response structure. Status needed.',
    self::STATUS_VALUE_ERROR_NAME   => 'Invalid status value',
    self::DATA_ERROR_NAME           => 'Invalid response structure. Data needed.',
    self::MSG_ERROR_NAME            => 'Invalid response structure. Message needed.',
  );

  /**
   * @param $name
   * @param $content
   */
  function __construct($name, $content)
  {
    $this->name = $name;
    $this->content = $content;
  }

  /**
   * @param $name
   * @param $content
   * @return S2OMeta
   */
  public static function factory($name, $content)
  {
    return new S2OMeta($name, $content);
  }

  /**
   * @return string
   */
  public function getHtml()
  {
    return '<meta name="'.$this->name.'" content="'.$this->content.'">';
  }

  /**
   * @return mixed
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

} 