<?php

error_reporting(0);

require_once dirname(__FILE__) . '/includes/class/active_directory_webservice.php';

// On désactive le cache
ini_set("soap.wsdl_cache_enabled", "0");

$wsdl = 'includes/wsdl/active_directory.wsdl';
// On crée l'objet SoapServer
$soapServer = new SoapServer($wsdl);
$soapServer->setClass("ActiveDirectoryWebservice");

// On lance le serveur SOAP
$soapServer->handle();
