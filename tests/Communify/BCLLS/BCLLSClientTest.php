<?php

namespace tests\Communify\BCLLS;


use Communify\C2\C2Credential;
use Communify\BCLLS\BCLLSClient;
use Communify\BCLLS\BCLLSConnector;
use Communify\BCLLS\BCLLSFactory;

class BCLLSClientTest extends \PHPUnit_Framework_TestCase
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
    $this->factory = $this->getMock(BCLLSFactory::class);
    $this->connector = $this->getMock(BCLLSConnector::class);
  }


  public function configureSut()
  {
    return new BCLLSClient($this->factory, $this->connector);
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
    $this->assertAttributeInstanceOf(BCLLSFactory::class, 'factory', $sut);
    $this->assertAttributeInstanceOf(BCLLSConnector::class, 'connector', $sut);
  }

  /**
  * dataProvider getClientCallsCorrectData
  */
  public function getClientCallsCorrectData()
  {
    return array(
      array( 'getAPData', 'getAPData', $this->any(), $this->any() ),
      array( 'getAPData', 'getAPData', $this->once(), $this->any() ),
      array( 'getAPData', 'getAPData', $this->any(), $this->once() ),

      array( 'registerEvent', 'registerEvent', $this->any(), $this->any() ),
      array( 'registerEvent', 'registerEvent', $this->once(), $this->any() ),
      array( 'registerEvent', 'registerEvent', $this->any(), $this->once() ),

      array( 'getNumEvents', 'getNumEvents', $this->any(), $this->any() ),
      array( 'getNumEvents', 'getNumEvents', $this->once(), $this->any() ),
      array( 'getNumEvents', 'getNumEvents', $this->any(), $this->once() ),
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
    $ssid = BCLLSClient::WEB_SSID;

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