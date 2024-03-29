<?php

include_once 'model/ldapConnex.php';

$wsdl	= 'wsdl/ldapConnex.wsdl';
$server	= new SoapServer($wsdl);
$server->setClass('ldapConnex');
$server->handle();

?>