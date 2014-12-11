<?php

namespace tests\Communify\S2O;

use Communify\S2O\S2OException;
use Communify\S2O\S2OMeta;
use Communify\S2O\S2OResponse;

class S2OResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $validator;

  private $sut;

  public function setUp()
  {
    $this->factory = $this->getMock('Communify\S2O\S2OFactory');
    $this->validator = $this->getMock('Communify\S2O\S2OValidator');
    $this->sut = new S2OResponse($this->factory, $this->validator);
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
  * dataProvider getSetData
  */
  public function getSetData()
  {
    return array(
      array(S2OMeta::STATUS_ERROR_NAME, $this->any(), $this->any()),
      array(S2OMeta::STATUS_ERROR_NAME, $this->once(), $this->any()),
      array(S2OMeta::STATUS_ERROR_NAME, $this->any(), $this->once()),

      array(S2OMeta::STATUS_VALUE_ERROR_NAME, $this->any(), $this->any()),
      array(S2OMeta::STATUS_VALUE_ERROR_NAME, $this->once(), $this->any()),
      array(S2OMeta::STATUS_VALUE_ERROR_NAME, $this->any(), $this->once()),

      array(S2OMeta::DATA_ERROR_NAME, $this->any(), $this->any()),
      array(S2OMeta::DATA_ERROR_NAME, $this->once(), $this->any()),
      array(S2OMeta::DATA_ERROR_NAME, $this->any(), $this->once()),

      array(S2OMeta::MSG_ERROR_NAME, $this->any(), $this->any()),
      array(S2OMeta::MSG_ERROR_NAME, $this->once(), $this->any()),
      array(S2OMeta::MSG_ERROR_NAME, $this->any(), $this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with: checkDataThrowingException
  * should: catchCase
   * @dataProvider getSetData
  */
  public function test_set_called_checkDataThrowingException_catchCase($msg, $timesCheckData, $timesMeta)
  {
    $data = array('dummy data');
    $name = $msg;
    $content = S2OMeta::$MESSAGES[$name];
    $exception = new S2OException($msg);
    $meta = $this->getMetaMock();
    $expected = array($meta);
    $this->configureCheckData($timesCheckData, $data, $this->throwException($exception));
    $this->configureFactoryCreateMeta($timesMeta, $name, $content, $meta);
    $this->sut->set($data);
    $this->assertEquals($expected, $this->sut->getMetas());
  }

  /**
  * dataProvider getSetWithKoStatusData
  */
  public function getSetWithKoStatusData()
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
  * with: koStatus
  * should: correctMeta
   * @dataProvider getSetWithKoStatusData
  */
  public function test_set_called_koStatus_correctMeta($timesCheckData, $timesMeta)
  {
    $msg = 'dummy exception message';
    $data = array(
      'message' => $msg
    );
    $data = $this->getDataArray(S2OResponse::STATUS_KO, $data);
    $meta = $this->getMetaMock();
    $this->configureCheckData($timesCheckData, $data, $this->returnValue(true));
    $this->configureFactoryCreateMeta($timesMeta, S2OMeta::KO_ERROR_NAME, $msg, $meta);
    $this->sut->set($data);
    $this->assertEquals(array($meta), $this->sut->getMetas());
  }

  /**
  * dataProvider getSetOkStatusData
  */
  public function getSetOkStatusData()
  {
    return array(
      array($this->any()),
      array($this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with: okStatus
  * should: correctMetasArray
   * @dataProvider getSetOkStatusData
  */
  public function test_set_called_okStatus_correctMetasArray($timesCheckData)
  {
    $key1 = 'dummy-key-1';
    $value1 = 'dummy value 1';
    $expectedContent1 = base64_encode(json_encode($value1));
    $key2 = 'dummy-key-2';
    $value2 = 'dummy value 2';
    $expectedContent2 = base64_encode(json_encode($value2));
    $data = array(
      $key1 => $value1,
      $key2 => $value2
    );
    $data = $this->getDataArray(S2OResponse::STATUS_OK, $data);
    $meta1 = $this->getMetaMock();
    $meta2 = $this->getMetaMock();
    $expected = array($meta1, $meta2);
    $this->configureCheckData($timesCheckData, $data, $this->returnValue(true));
    $this->configureFactoryCreateMeta($this->at(0), S2OMeta::OK_BASE_NAME.$key1, $expectedContent1, $meta1);
    $this->configureFactoryCreateMeta($this->at(1), S2OMeta::OK_BASE_NAME.$key2, $expectedContent2, $meta2);
    $this->sut->set($data);
    $this->assertEquals($expected, $this->sut->getMetas());
  }

  /**
  * method: metas
  * when: called
  * with: emptyArray
  * should: returnEmptyString
  */
  public function test_metas_called_emptyArray_returnEmptyString()
  {
    $actual = $this->sut->metas();
    $this->assertEquals('', $actual);
  }

  /**
  * dataProvider getMetasData
  */
  public function getMetasData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
  * method: metas
  * when: called
  * with: metasArray
  * should: returnCorrectString
   * @dataProvider getMetasData
  */
  public function test_metas_called_metasArray_returnCorrectString($timesHtml1, $timesHtml2)
  {
    $html1 = 'dummy html 1';
    $html2 = 'dummy html 2';
    $expected = ''.$html1.$html2;
    $meta1 = $this->getMetaMock();
    $meta2 = $this->getMetaMock();
    $metas = array($meta1, $meta2);
    $this->configureMetaGetHtml($meta1, $timesHtml1, $html1);
    $this->configureMetaGetHtml($meta2, $timesHtml2, $html2);
    $this->sut->setMetas($metas);
    $actual = $this->sut->metas();
    $this->assertEquals($expected, $actual);
  }

  /**
   * @param $meta1
   * @param $timesHtml
   * @param $html1
   */
  private function configureMetaGetHtml($meta1, $timesHtml, $html1)
  {
    $meta1->expects($timesHtml)
      ->method('getHtml')
      ->will($this->returnValue($html1));
  }

  /**
   * @param $timesCheckData
   * @param $data
   * @param $will
   */
  private function configureCheckData($timesCheckData, $data, $will)
  {
    $this->validator->expects($timesCheckData)
      ->method('checkData')
      ->with($data)
      ->will($will);
  }

  /**
   * @param $timesMeta
   * @param $name
   * @param $content
   * @param $meta
   */
  private function configureFactoryCreateMeta($timesMeta, $name, $content, $meta)
  {
    $this->factory->expects($timesMeta)
      ->method('meta')
      ->with($name, $content)
      ->will($this->returnValue($meta));
  }

  /**
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function getMetaMock()
  {
    $meta = $this->getMockBuilder('Communify\S2O\S2OMeta')->disableOriginalConstructor()->getMock();
    return $meta;
  }

  /**
   * @param $status
   * @param $data
   * @return array
   */
  private function getDataArray($status, $data)
  {
    $data = array(
      'status' => $status,
      'data' => $data
    );
    return $data;
  }

}