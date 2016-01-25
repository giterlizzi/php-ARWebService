# ARWebService Client
BMC Remedy(R) Mid-Tier SOAP client wrapper


## Install

```.sh
composer.phar require lotar/arwebservice
```

## Usage

```.php
<?php

include('vendor/autoload.php');

use Lotar\ARWebService;

$client = new ARWebService\Client('http://localhost:8080', 'ars81', 'Demo', '');
$client->setService('User');

print_r($client->getWSDL()); // Get the WSDL

$qualifier = new ARWebService\Qualifier;
$qualification = $qualifier->parse($qualifier->andx($qualifier->eq('Request_ID', '000000000000001')));

print_r($client->call('OpGetList',
  array('Qualification' => $qualification, // ( 'Request_ID' = 000000000000001 )
        'startRecord'   => 0,
        'maxLimit'      => 1000)
  ));

```
