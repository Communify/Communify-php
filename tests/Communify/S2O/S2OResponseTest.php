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

namespace tests\Communify\S2O;

use Communify\C2\C2Exception;
use Communify\C2\interfaces\IC2Exception;
use Communify\C2\C2Meta;
use Communify\S2O\S2OResponse;

/**
 * @covers Communify\S2O\S2OResponse
 */
class S2OResponseTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $metas;

  /**
   * @var \Communify\S2O\S2OResponse
   */
  private $sut;

  private $url = 'dummy url';

  public function setUp()
  {
    $this->validator = $this->getMock('Communify\C2\C2Validator');
    $this->metas = $this->getMock('Communify\C2\C2MetaIterator');
    $this->sut = new S2OResponse($this->validator, $this->metas, $this->url);
  }

  /**
  * method: constructor
  * when: called
  * with: noParameters
  * should: defaultAttrObject
  */
  public function test_constructor_called_noParameters_defaultAttrObject()
  {
    $sut = new S2OResponse();
    $this->assertAttributeInstanceOf('Communify\C2\C2Validator', 'validator', $sut);
    $this->assertAttributeInstanceOf('Communify\C2\C2MetaIterator', 'metas', $sut);
    $this->assertAttributeEmpty('url', $sut);
    $this->assertAttributeEquals(false, 'error', $sut);
  }

  /**
   * dataProvider getSetOkStatusAndEmptyDataNoMetaPushData
   */
  public function getSetOkStatusAndEmptyDataNoMetaPushData()
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
   * with: okStatusAndEmptyData
   * should: noMetaPush
   * @dataProvider getSetOkStatusAndEmptyDataNoMetaPushData
   */
  public function test_set_called_okStatusAndEmptyData_noMetaPush($timesJson, $timesCheckData)
  {
    $data = array('data' => array());
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureResponseJson($timesJson, $response, $data);
    $this->configureCheckData($timesCheckData, $data, $this->returnValue('dummy return check data'));
    $this->metas->expects($this->never())
      ->method('push');
    $this->sut->set($response);
  }

  /**
  * dataProvider getSetOkStatusWithDataPushInnerCallsData
  */
  public function getSetOkStatusWithDataPushInnerCallsData()
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
  * with: okStatusWithData
  * should: pushInnerCalls
   * @dataProvider getSetOkStatusWithDataPushInnerCallsData
  */
  public function test_set_called_okStatusWithData_pushInnerCalls($timesJson, $timesCheckData)
  {
    $key1 = 'dummy1';
    $value1 = 'value 1';
    $key2 = 'dummy2';
    $value2 = 'value 2';
    $data = array('data' => array($key1 => $value1, $key2 => $value2));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureResponseJson($timesJson, $response, $data);
    $this->configureCheckData($timesCheckData, $data, $this->returnValue('dummy return check data'));
    $this->configureMetasPush($this->at(0), C2Meta::OK_BASE_NAME.$key1, $value1);
    $this->configureMetasPush($this->at(1), C2Meta::OK_BASE_NAME.$key2, $value2);
    $this->sut->set($response);
  }

  /**
  * dataProvider getSetInvalidDataKoStatusCorrectMetaMsgData
  */
  public function getSetInvalidDataKoStatusCorrectMetaMsgData()
  {
    return array(
      array($this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with: invalidDataWithKoStatus
  * should: correctMetaMsg
   * @dataProvider getSetInvalidDataKoStatusCorrectMetaMsgData
  */
  public function test_set_called_invalidDataWithKoStatus_correctMetaMsg($timesJson, $timesCheckData, $timesPush)
  {
    $msg = 'dummy error message';
    $error = IC2Exception::KO_ERROR_NAME;
    $this->configureAndExecuteSetWithCatchCase($timesJson, $timesCheckData, $timesPush, $msg, $error);
  }

  /**
  * dataProvider getSetInvalidDataDefaultCaseCorrectMetaMsgData
  */
  public function getSetInvalidDataDefaultCaseCorrectMetaMsgData()
  {
    return array(
      array(IC2Exception::STATUS_ERROR_NAME, $this->any(), $this->any(), $this->any()),
      array(IC2Exception::STATUS_ERROR_NAME, $this->once(), $this->any(), $this->any()),
      array(IC2Exception::STATUS_ERROR_NAME, $this->any(), $this->once(), $this->any()),
      array(IC2Exception::STATUS_ERROR_NAME, $this->any(), $this->any(), $this->once()),

      array(IC2Exception::STATUS_VALUE_ERROR_NAME, $this->any(), $this->any(), $this->any()),
      array(IC2Exception::STATUS_VALUE_ERROR_NAME, $this->once(), $this->any(), $this->any()),
      array(IC2Exception::STATUS_VALUE_ERROR_NAME, $this->any(), $this->once(), $this->any()),
      array(IC2Exception::STATUS_VALUE_ERROR_NAME, $this->any(), $this->any(), $this->once()),

      array(IC2Exception::DATA_ERROR_NAME, $this->any(), $this->any(), $this->any()),
      array(IC2Exception::DATA_ERROR_NAME, $this->once(), $this->any(), $this->any()),
      array(IC2Exception::DATA_ERROR_NAME, $this->any(), $this->once(), $this->any()),
      array(IC2Exception::DATA_ERROR_NAME, $this->any(), $this->any(), $this->once()),

      array(IC2Exception::MSG_ERROR_NAME, $this->any(), $this->any(), $this->any()),
      array(IC2Exception::MSG_ERROR_NAME, $this->once(), $this->any(), $this->any()),
      array(IC2Exception::MSG_ERROR_NAME, $this->any(), $this->once(), $this->any()),
      array(IC2Exception::MSG_ERROR_NAME, $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: set
  * when: called
  * with: invalidDataDefaultCase
  * should: correctMetaMsg
   * @dataProvider getSetInvalidDataDefaultCaseCorrectMetaMsgData
  */
  public function test_set_called_invalidDataDefaultCase_correctMetaMsg($error, $timesJson, $timesCheckData, $timesPush)
  {
    $msg = C2Meta::$MESSAGES[$error];
    $this->configureAndExecuteSetWithCatchCase($timesJson, $timesCheckData, $timesPush, $msg, $error);
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
    $scripts = '<script id="cfy-s2o-script" data-url="'.$this->url.'" src="'.$this->url.'/views/widget/s2o/s2o.min.js"></script>';
    $expected = ''.$html1.$html2.$scripts;
    $this->configureExecuteAndAssertCommonMethodsNotEmpty($timesHtml1, $timesHtml2, $html1, $html2, $expected);
  }

  /**
  * dataProvider getMetasWithErrorData
  */
  public function getMetasWithErrorData()
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
  * with: metasArrayWithError
  * should: returnCorrectString
   * @dataProvider getMetasWithErrorData
  */
  public function test_metas_called_metasArrayWithError_returnCorrectString($timesHtml1, $timesHtml2)
  {
    $html1 = 'dummy html 1';
    $html2 = 'dummy html 2';
    $expected = ''.$html1.$html2;
    $this->sut->setError(true);
    $this->configureExecuteAndAssertCommonMethodsNotEmpty($timesHtml1, $timesHtml2, $html1, $html2, $expected);
  }

  /**
  * method: get
  * when: called
  * with: emptyArray
  * should: returnEmptyArray
  */
  public function test_get_called_emptyArray_returnEmptyArray()
  {
    $actual = $this->sut->get();
    $this->assertEquals(array(), $actual);
  }

  /**
  * dataProvider getData
  */
  public function getData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: get
  * when: called
  * with: notEmptyArray
  * should: correctReturn
   * @dataProvider getData
  */
  public function test_get_called_notEmptyArray_correctReturn($timesName1, $timesContent1, $timesName2, $timesContent2)
  {
    $name1 = 'dummy name 1';
    $content1 = 'dummy name 1';
    $name2 = 'dummy name 2';
    $content2 = 'dummy content 2';
    $meta1 = $this->getMetaMock();
    $meta2 = $this->getMetaMock();
    $metas = array($meta1, $meta2);
    $expected = array(
      $name1 => $content1,
      $name2 => $content2
    );
    $this->configureGetNameAndContent($meta1, $timesName1, $name1, $timesContent1, $content1);
    $this->configureGetNameAndContent($meta2, $timesName2, $name2, $timesContent2, $content2);
    $this->sut->setMetas($metas);
    $actual = $this->sut->get();
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
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function getMetaMock()
  {
    $meta = $this->getMockBuilder('Communify\C2\C2Meta')->disableOriginalConstructor()->getMock();
    return $meta;
  }

  /**
   * @param $timesJson
   * @param $response
   * @param $data
   */
  private function configureResponseJson($timesJson, $response, $data)
  {
    $response->expects($timesJson)
      ->method('json')
      ->will($this->returnValue($data));
  }

  /**
   * @param $times
   * @param $name
   * @param $content
   */
  private function configureMetasPush($times, $name, $content)
  {
    $this->metas->expects($times)
      ->method('push')
      ->with($name, $content);
  }

  /**
   * @param $timesJson
   * @param $timesCheckData
   * @param $timesPush
   * @param $msg
   * @param $error
   */
  private function configureAndExecuteSetWithCatchCase($timesJson, $timesCheckData, $timesPush, $msg, $error)
  {
    $data = array('data' => array('message' => $msg));
    $exception = new C2Exception($error);
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')->disableOriginalConstructor()->getMock();
    $this->configureResponseJson($timesJson, $response, $data);
    $this->configureCheckData($timesCheckData, $data, $this->throwException($exception));
    $this->configureMetasPush($timesPush, $error, $msg);
    $this->sut->set($response);
    $this->assertAttributeEquals(true, 'error', $this->sut);
  }

  /**
   * @param $meta1
   * @param $timesName
   * @param $name
   * @param $timesContent
   * @param $content
   */
  private function configureGetNameAndContent($meta1, $timesName, $name, $timesContent, $content)
  {
    $meta1->expects($timesName)
      ->method('getName')
      ->will($this->returnValue($name));
    $meta1->expects($timesContent)
      ->method('getContent')
      ->will($this->returnValue($content));
  }

  /**
   * @param $timesHtml1
   * @param $timesHtml2
   * @param $html1
   * @param $html2
   * @param $expected
   */
  private function configureExecuteAndAssertCommonMethodsNotEmpty($timesHtml1, $timesHtml2, $html1, $html2, $expected)
  {
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
  * method: setUrl
  * when: called
  * with: correctUrl
  * should: correctReturn
  */
  public function test_setUrl_called_correctUrl_correctReturn()
  {
    $this->sut->setUrl('http://env.yourcommunify.com/api/env');
    $this->assertAttributeEquals('http://env.yourcommunify.com', 'url', $this->sut);
  }

}