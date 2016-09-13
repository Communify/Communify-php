<?php

namespace tests\Communify\LG;


use Communify\C2\C2Credential;
use Communify\LG\LGClient;
use Communify\LG\LGConnector;
use Communify\LG\LGFactory;

class LGClientTest extends \PHPUnit_Framework_TestCase
{
  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $connector;

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  private $factory;


  public function setUp()
  {
    $this->factory = $this->getMock(LGFactory::class);
    $this->connector = $this->getMock(LGConnector::class);
  }


  public function configureSut()
  {
    return new LGClient($this->factory, $this->connector);
  }

  /**
   * method: constructor
   * when: called
   * with: noParameters
   * should: defaultObjectAttrs
   */
  public function test_constructor_called_noParameters_defaultObjectAttrs()
  {
    $sut = $this->configureSut();
    $this->assertAttributeInstanceOf(LGFactory::class, 'factory', $sut);
    $this->assertAttributeInstanceOf(LGConnector::class, 'connector', $sut);
  }

  /**
  * dataProvider getClientCallsCorrectData
  */
  public function getClientCallsCorrectData()
  {
    return array(
      array( 'generateLead', 'generateLead', $this->any(), $this->any() ),
      array( 'generateLead', 'generateLead', $this->once(), $this->any() ),
      array( 'generateLead', 'generateLead', $this->any(), $this->once() ),

      array( 'getLeadInfo', 'getLeadInfo', $this->any(), $this->any() ),
      array( 'getLeadInfo', 'getLeadInfo', $this->once(), $this->any() ),
      array( 'getLeadInfo', 'getLeadInfo', $this->any(), $this->once() ),

      array( 'getUserInfo', 'getUserInfo', $this->any(), $this->any() ),
      array( 'getUserInfo', 'getUserInfo', $this->once(), $this->any() ),
      array( 'getUserInfo', 'getUserInfo', $this->any(), $this->once() ),
    );
  }

  /**
  * method: clientCalls
  * when: called
  * with:
  * should: correctInnerCalls
   * @dataProvider getClientCallsCorrectData
  */
  public function test_clientCalls_called__correctInnerCalls($functionName, $functionToCall, $timesCredential, $timesConnectorCall)
  {
    $this->configureCalls( $functionName, $functionToCall, $timesCredential, $timesConnectorCall );
  }

  /**
   * @param $functionName
   * @param $functionToCall
   * @param $timesConnectorCall
   * @param $timesCredential
   */
  private function configureCalls($functionName, $functionToCall, $timesConnectorCall, $timesCredential)
  {
    $accountId = 'dummy account id';
    $data = 'dummy data value';
    $expected = 'dummy expected value';
    $ssid = LGClient::WEB_SSID;

    $credential = $this->configureCredential( $ssid, $accountId, $data, $timesCredential );

    $this->connector->expects( $timesConnectorCall )
        ->method( $functionToCall )
        ->with( $credential )
        ->will( $this->returnValue( $expected ) );

    $actual = $this->configureSut()->$functionName( $accountId, $data );

    $this->assertEquals( $expected, $actual );
  }

  /**
   * @param $ssid
   * @param $accountId
   * @param $data
   * @param $timesCredential
   *
   * @return \PHPUnit_Framework_MockObject_MockObject
   */
  private function configureCredential( $ssid, $accountId, $data, $timesCredential )
  {
    $credential = $this->getMock(C2Credential::class);

    $this->factory->expects( $timesCredential )
        ->method( 'credential' )
        ->with( $ssid, $accountId, $data )
        ->will( $this->returnValue( $credential ) );

    return $credential;
  }
}