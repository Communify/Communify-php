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
   * dataProvider getGenerateLeadCorrectData
   */
  public function getGenerateLeadCorrectData()
  {
    return array(
      array($this->any(), $this->any()),
      array($this->once(), $this->any()),
      array($this->any(), $this->once()),
    );
  }

  /**
   * method: generateLead
   * when: called
   * with:
   * should: correct
   * @dataProvider getGenerateLeadCorrectData
   */
  public function test_generateLead_called__correct($timesCredential, $timesSetOrder)
  {
    $accountId = 'dummy account id';
    $data = 'dummy data value';
    $expected = 'dummy expected value';
    $credential = $this->getMock(C2Credential::class);

    $this->factory->expects($timesCredential)
      ->method('credential')
      ->with(LGClient::WEB_SSID, $accountId, $data)
      ->will($this->returnValue($credential));

    $this->connector->expects($timesSetOrder)
      ->method('generateLead')
      ->with($credential)
      ->will($this->returnValue($expected));

    $actual = $this->configureSut()->generateLead($accountId, $data);
    $this->assertEquals($expected, $actual);
  }
}