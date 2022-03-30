<?php

use giterlizzi\ARWebService;
use PHPUnit\Framework\TestCase;

final class QualifierTest extends TestCase {

  public function testEqIntger() {

    $qualifier = new ARWebService\Qualifier;

    $this->expectOutputString('(1 = 1)');
    print $qualifier->parse($qualifier->andx($qualifier->eq(1, 1)));

  }

  public function testEqField() {

    $qualifier = new ARWebService\Qualifier;

    $this->expectOutputString("('Request_ID' = \"000000000000001\")");
    print $qualifier->parse($qualifier->andx($qualifier->eq('Request_ID', '000000000000001')));

  }

}

