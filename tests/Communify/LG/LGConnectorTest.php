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
   * dataProvider getGenerateLeadCorrectData
   */
  public function getGenerateLeadCorrectData()
  {
    return array(
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->once(), $this->any(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->once(), $this->any(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->once(), $this->any(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->once(), $this->any(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->once(), $this->any()),
      array($this->any(), $this->any(), $this->any(), $this->any(), $this->any(), $this->once()),
    );
  }

  /**
   * method: generateLead
   * when: called
   * with:
   * should: correct
   * @dataProvider getGenerateLeadCorrectData
   */
  public function test_generateLead_called__correct($timesGetUrl, $timesGetCredentialContent, $timesCreateRequest, $timesSend, $timesResponse, $timesSet)
  {
    $url = 'dummy url';
    $request = 'dummy request';
    $response = $this->getMockBuilder(GuzzleResponse::class)->disableOriginalConstructor()->getMock();
    $credential = $this->getMock(C2Credential::class);
    $credentialContent = 'dummy credential content';
    $eapResponse = $this->getMock(LGResponse::class);

    $credential->expects($timesGetUrl)
      ->method('getUrl')
      ->will($this->returnValue($url));

    $credential->expects($timesGetCredentialContent)
      ->method('get')
      ->will($this->returnValue($credentialContent));

    $this->client->expects($timesCreateRequest)
      ->method('createRequest')
      ->with(LGConnector::POST_METHOD, $url.LGConnector::LEAD_GENERATION_METHOD, null, $credentialContent)
      ->will($this->returnValue($request));

    $this->client->expects($timesSend)
      ->method('send')
      ->with($request)
      ->will($this->returnValue($response));

    $this->factory->expects($timesResponse)
      ->method('response')
      ->will($this->returnValue($eapResponse));

    $eapResponse->expects($timesSet)
      ->method('set')
      ->with($response);

    $actual = $this->sut->generateLead($credential);
    $this->assertEquals($eapResponse, $actual);
  }
}