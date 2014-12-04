<?php

namespace Communify\S2O;


class S2OResponse
{
  function __construct()
  {
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
   * @return string
   */
  public function metas()
  {
    return '<meta name="communify-user-hash" content="a46b73f57665d177220abac99e85c81e"><meta name="communify-user-json" content=\'{"id":4,"name":"Joan","email":"joan@please.to","surname":"Català","bio":"","phone":"","address":"","postal_code":"","gender":0,"birth_date":"","facebook_id":"","image":"http://pitu-comunify.s3.amazonaws.com/users/4","country_id":0,"state_id":0,"banned":false,"language":{"id":1,"name":"english","locale":"en"},"allow_create_site":false,"ext":"","updated_at":1417100009,"backoffice":true}\'>';
  }


} 