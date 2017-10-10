<?php

include_once("server.php");
$soap = new SoapServer(null,array('url'=>"http://text-url"));
$soap->addFunction('GetTime');
$soap->setClass('member');
$soap->handle();