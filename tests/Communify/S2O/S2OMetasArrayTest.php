<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OMetasArray;

class S2OMetasArrayTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var S2OMetasArray
   */
  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
    $this->sut = new S2OMetasArray($this->factory);
  }

  /**
  * method: factory
  * when: called
  * with:
  * should: correctReturn
  */
  public function test_factory_called_noDependencyInjection_correctReturn()
  {
    $actual = S2OMetasArray::factory();
    $this->assertInstanceOf('Communify\S2O\S2OMetasArray', $actual);
  }

  /**
  * dataProvider getPushData
  */
  public function getPushData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
  * method: push
  * when: called
  * with:
  * should: correct
   * @dataProvider getPushData
  */
  public function test_push_called__correct($times)
  {
    $name = 'dummy name';
    $content = 'dummy content';
    $meta = $this->getMockBuilder('Communify\S2O\S2OMeta')->disableOriginalConstructor()->getMock();
    $this->factory->expects($times)
      ->method('meta')
      ->with($name, $content)
      ->will($this->returnValue($meta));
    $this->sut->push($name, $content);
    $this->assertEquals($this->sut->current(), $meta);
  }

  /**
  * method: rewindAndNext
  * when: called
  * with:
  * should: correct
  */
  public function test_rewindAndNext_called__correct()
  {
    $this->assertEquals(0, $this->sut->key());
    $this->sut->next();
    $this->assertEquals(1, $this->sut->key());
    $this->sut->rewind();
    $this->assertEquals(0, $this->sut->key());
  }

  /**
  * method: valid
  * when: called
  * with: noElements
  * should: correct
  */
  public function test_valid_called_noElements_correct()
  {
    $this->assertEquals(false, $this->sut->valid());
  }

  /**
  * method: valid
  * when: called
  * with: oneElement
  * should: correct
  */
  public function test_valid_called_oneElement_correct()
  {
    $this->sut->setArray(array('dummy array'));
    $this->assertEquals(true, $this->sut->valid());
  }
  
}