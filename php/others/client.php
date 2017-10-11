<?php
$client = new SoapClient(null,array(
    'location'=>"http://www.practicephp.com/proxy.client",
    'url'=>'http://test-url',
    'style'=>SOAP_RPC,
    "use"=>SOAP_ENCODED,
    "trace"=>1,
    "exceptions"=>0
));
$addresult = $client->add(1);
print_r($addresult);
