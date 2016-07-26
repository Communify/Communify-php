<?php

namespace tests\Communify\LG;


use Communify\C2\C2Validator;
use Communify\LG\LGResponse;
use Guzzle\Http\Message\Response as GuzzleResponse;

class LGResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $validator;


  public function setUp()
  {
    $this->validator = $this->getMock(C2Validator::class);
  }


  public function configureSut()
  {
    return new LGResponse($this->validator);
  }

  /**
   * dataProvider getSetData
   */
  public function getSetData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
   * method: set
   * when: called
   * with:
   * should: correct
   * @dataProvider getSetData
   */
  public function test_set_called__correct($timesJson, $timesCheckData)
  {
    $data = 'dummy data';
    $sut = $this->configureSut();

    $response = $this->configureSet($timesJson, $timesCheckData, $data);
    $sut->set($response);
    $this->assertAttributeEquals($data, 'data', $sut);
  }


  /**
   * method: get
   * when: called
   * with:
   * should: correct
   */
  public function test_get_called__correct()
  {
    $expected = 'dummy data';

    $sut = $this->configureSut();

    $response = $this->configureSet($this->any(), $this->any(), $expected);
    $sut->set($response);
    $actual = $sut->get();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $timesJson
   * @param $timesCheckData
   * @param $data
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function configureSet($timesJson, $timesCheckData, $data)
  {
    $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();

    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($data));

    $this->validator->expects($timesCheckData)
      ->method('checkData')
      ->with($data);

    return $response;
  }

}