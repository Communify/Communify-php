<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OMeta;

class S2OMetaTest extends \PHPUnit_Framework_TestCase
{

  private function configureSut($name, $content)
  {
    return new S2OMeta($name, $content);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OMeta::factory('dummy name', 'dummy content');
    $this->assertInstanceOf('Communify\S2O\S2OMeta', $actual);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctAttrsValues
  */
  public function test_factory_called__correctAttrsValues()
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $actual = S2OMeta::factory($name, $content);
    $this->assertEquals($name, $actual->getName());
    $this->assertEquals($content, $actual->getContent());
  }

  /**
  * method: getHtml
  * when: called
  * with:
  * should: correct
  */
  public function test_getHtml_called__correct()
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $expected = '<meta name="'.$name.'" content="'.$content.'">';
    $actual = $this->configureSut($name, $content)->getHtml();
    $this->assertEquals($expected, $actual);
  }
  
}