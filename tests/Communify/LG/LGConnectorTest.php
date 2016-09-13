<?php

namespace tests\Communify\LG;


use Communify\C2\C2Credential;
use Communify\LG\LGConnector;
use Communify\LG\LGFactory;
use Communify\LG\LGResponse;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Message\Response as GuzzleResponse;

class LGConnectorTest extends \PHPUnit_Framework_TestCase
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
    $this->factory = $this->getMock(LGFactory::class);
    $this->client = $this->getMock(GuzzleClient::class);
    $this->sut = new LGConnector($this->factory, $this->client);
  }


  public function configureSut()
  {
    return new LGConnector($this->factory, $this->client);
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
    $this->assertAttributeInstanceOf(LGFactory::class, 'factory', $sut);
    $this->assertAttributeInstanceOf(GuzzleClient::class, 'client', $sut);
  }

  /**
  * dataProvider getConnectorCallCorrectData
  */
  public function getConnectorCallCorrectData()
  {
    return array(
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
        array('generateLead', LGConnector::LEAD_GENERATION_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),

        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
        array('getLeadInfo', LGConnector::GET_LEAD_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),

        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
        array('getUserInfo', LGConnector::GET_USER_INFO_METHOD, $this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
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
    $lgResponse = $this->getMock(LGResponse::class);
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
        ->with(LGConnector::POST_METHOD, $url.$apiMethod, null, $credentialContent)
        ->will($this->returnValue($request));

    $this->client->expects($timesSend)
        ->method('send')
        ->with($request)
        ->will($this->returnValue($response));

    $this->factory->expects($timesResponse)
        ->method('response')
        ->will($this->returnValue($lgResponse));

    $lgResponse->expects($timesSet)
        ->method('set')
        ->with($response);

    $actual = $this->sut->$functionName($credential);
    $this->assertEquals($lgResponse, $actual);
  }
}