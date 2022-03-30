<?php

use giterlizzi\ARWebService;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase {

  public function testWsdlUrl() {

    $client = new ARWebService\Client('http://localhost:8080', 'remedy', 'Demo', '');
    $client->setService('User');

    $this->expectOutputString('http://localhost:8080/arsys/WSDL/public/remedy/User');
    print $client->getWsdlUrl();

  }

  /**
    * @expectedException giterlizzi\ARWebService\ClientException
    */
  public function testNoServiceException() {

    $client = new ARWebService\Client('http://localhost:8080', 'remedy', 'Demo', '');
    $client->getWsdlUrl();

  }

}
