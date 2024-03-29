<?php

error_reporting(0);

require_once dirname(__FILE__) . '/includes/class/active_directory_xml_webservice.php';

// On désactive le cache
ini_set("soap.wsdl_cache_enabled", "0");

$wsdl = 'includes/wsdl/active_directory_xml.wsdl';
// On crée l'objet SoapServer
$soapServer = new SoapServer($wsdl);
$soapServer->setClass("ActiveDirectoryXmlWebservice");

// On lance le serveur SOAP
$soapServer->handle();
