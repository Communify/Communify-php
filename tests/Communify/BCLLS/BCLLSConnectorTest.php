<?php

namespace tests\Communify\BCLLS;


use Communify\C2\C2Credential;
use Communify\BCLLS\BCLLSConnector;
use Communify\BCLLS\BCLLSFactory;
use Communify\BCLLS\BCLLSResponse;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Message\Response as GuzzleResponse;

class BCLLSConnectorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $client;


  public function setUp()
  {
    $this->factory = $this->getMock(BCLLSFactory::class);
    $this->client = $this->getMock(GuzzleClient::class);
    $this->sut = new BCLLSConnector($this->factory, $this->client);
  }


  public function configureSut()
  {
    return new BCLLSConnector($this->factory, $this->client);
  }


  /**
   * method: constructor
   * when: called
   * with: noParameters
   * should: defaultAttrObjects
   */
  public function test_constructor_called_noParameters_defaultAttrObjects()
  {
    $sut = $this->configureSut();
    $this->assertAttributeInstanceOf(BCLLSFactory::class, 'factory', $sut);
    $this->assertAttributeInstanceOf(GuzzleClient::class, 'client', $sut);
  }

  /**
  * dataProvider getConnectorCallCorrectData
  */
  public function getConnectorCallCorrectData()
  {
    return array(
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
        array('getAPData', BCLLSConnector::GET_AP_DATA_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),

        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
        array('registerEvent', BCLLSConnector::REGISTER_EVENT_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
  * method: connectorCall
  * when: called
  * with:
  * should: correctInnerCalls
   * @dataProvider getConnectorCallCorrectData
  */
  public function test_connectorCall_called__correctInnerCalls( $functionName, $apiMethod, $timesGetUrl, $timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet)
  {
    $this->configureRequest( $functionName, $apiMethod, $timesGetUrl, $timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet);
  }

  /**
   * @param $functionName
   * @param $apiMethod
   * @param $timesGetUrl
   * @param $timesGet
   * @param $timesCreateRequest
   * @param $timesSend
   * @param $timesResponse
   * @param $timesSet
   */
  private function configureRequest( $functionName, $apiMethod, $timesGetUrl, $timesGet, $timesCreateRequest, $timesSend, $timesResponse, $timesSet )
  {
    $url = 'dummy url';
    $request = 'dummy request';
    $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();
    $credentialContent = 'dummy credential content';
    $BCLLSResponse = $this->getMock(BCLLSResponse::class);
    $credential = $this->getMock(C2Credential::class);

    $header = null;

    $credential->expects( $timesGetUrl )
        ->method( 'getUrl' )
        ->will( $this->returnValue( $url ) );

    $credential->expects( $timesGet )
        ->method( 'get' )
        ->will( $this->returnValue( $credentialContent ) );

    $this->client->expects($timesCreateRequest)
        ->method('createRequest')
        ->with(BCLLSConnector::POST_METHOD, $url.$apiMethod, null, $credentialContent)
        ->will($this->returnValue($request));

    $this->client->expects($timesSend)
        ->method('send')
        ->with($request)
        ->will($this->returnValue($response));

    $this->factory->expects($timesResponse)
        ->method('response')
        ->will($this->returnValue($BCLLSResponse));

    $BCLLSResponse->expects($timesSet)
        ->method('set')
        ->with($response);

    $actual = $this->sut->$functionName($credential);
    $this->assertEquals($BCLLSResponse, $actual);
  }
}