<?php

use Lotar\ARWebService;

class ClientTest extends PHPUnit_Framework_TestCase {

  public function testWsdlUrl() {

    $client = new ARWebService\Client('http://localhost:8080', 'remedy', 'Demo', '');
    $client->setService('User');

    $this->expectOutputString('http://localhost:8080/arsys/WSDL/public/remedy/User');
    print $client->getWsdlUrl();

  }

  /**
    * @expectedException Lotar\ARWebService\ClientException
    */
  public function testNoServiceException() {

    $client = new ARWebService\Client('http://localhost:8080', 'remedy', 'Demo', '');
    $client->getWsdlUrl();

  }

}
