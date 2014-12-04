<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OResponse;

class S2OResponseTest extends \PHPUnit_Framework_TestCase
{

  private function configureSut()
  {
    return new S2OResponse();
  }

  /**
  * method: factory
  * when: called
  * with: noDependencyInjection
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OResponse::factory();
    $this->assertInstanceOf('Communify\S2O\S2OResponse', $actual);
  }

  /**
  * method: metas
  * when: called
  * with:
  * should: correct
  */
  public function test_metas_called__correct()
  {
    $expected = '<meta name="communify-user-hash" content="a46b73f57665d177220abac99e85c81e"><meta name="communify-user-json" content=\'{"id":4,"name":"Joan","email":"joan@please.to","surname":"Català","bio":"","phone":"","address":"","postal_code":"","gender":0,"birth_date":"","facebook_id":"","image":"http://pitu-comunify.s3.amazonaws.com/users/4","country_id":0,"state_id":0,"banned":false,"language":{"id":1,"name":"english","locale":"en"},"allow_create_site":false,"ext":"","updated_at":1417100009,"backoffice":true}\'>';
    $actual = $this->configureSut()->metas();
    $this->assertEquals($expected, $actual);
  }
  
}