<?php

header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => 0); 

// Environement
$env = strtolower($_GET['env']);
$env = in_array($env, array('test', 'acpt', 'prod')) ? $env : 'test';

// Paramètres
$ref = 8;
$ref = $_config["flux"]["numero_organisation"].$ref;

for ($i=0; $i < 9; $i++) $ref .= mt_rand(0, 9);

$now = new DateTime('now', new DateTimeZone('Europe/Brussels'));
$params = array(
    'RequestContext_Reference' => $ref,
    'RequestContext_TimeRequest' => $now->format('Ymd\THis'),
    'ServiceRequest_TargetSSIN' => $_GET['TargetSSIN'],
    'ServiceRequest_PeriodStartDate' => $_GET['PeriodStartDate'],
    'ServiceRequest_PeriodEndDate' => $_GET['PeriodEndDate'],
    'ServiceRequest_RequestedDataPillar' => $_GET['RequestedDataPillar'],
    'ServiceRequest_RequestedDataRequestedInformation' => $_GET['RequestedDataRequestedInformation'],
    'ServiceRequest_RequestedDataFocus' => $_GET['RequestedDataFocus']
);

// Test de connexion à la BCSS
$soapTestWsdl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['PHP_SELF']) . '../../../include/soap/autres/' . $env . '/TestConnectionService.wsdl';

try {
    
    $soapTestClient = new SoapClient($soapTestWsdl, array('trace' => true, 'connection_timeout' => 10, 'soap_version' => SOAP_1_1,
        'stream_context' => stream_context_create (
            array (
                'ssl'=> array (
                    'verify_peer'     => false,
                    'verify_peer_name' => false
                )
            )
        )   
    ));
    
    $soapTestResult = $soapTestClient->sendTestMessage(array('echo' => 'cpascharleroi'));

    if ( $soapTestResult->echo != 'cpascharleroi' ) {
        $retour['succes'] = 0;
        $retour['data']['status']['description'] = 'BCSS indisponible.';
    }
} catch (Exception $e) {
    $retour['succes'] = 0;
    $retour['data']['status']['description'] = $e->getMessage();
}

// Préparation du flux
$xml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
$xml .= '<SSDNRequest xmlns="http://www.ksz-bcss.fgov.be/XSD/SSDN/Service">';
  $xml .= '<RequestContext>';
    $xml .= '<AuthorizedUser>';
      $xml .= '<UserID>'.$_config["flux"]["old"]["user_id"].'</UserID>';
      $xml .= '<Email>CLAMOTMICHAEL@CPASCHARLEROI.BE</Email>';
      $xml .= '<OrgUnit>'.$_config["flux"]["old"]["org_unit"].'</OrgUnit>';
      $xml .= '<MatrixID>'.$_config["flux"]["secteur"].'</MatrixID>';
      $xml .= '<MatrixSubID>'.$_config["flux"]["institution"].'</MatrixSubID>';
    $xml .= '</AuthorizedUser>';
    $xml .= '<Message>';
      $xml .= '<Reference>' . $params['RequestContext_Reference'] . '</Reference>';
      $xml .= '<TimeRequest>' . $params['RequestContext_TimeRequest'] . '</TimeRequest>';
      $xml .= '<Language>fr</Language>';
    $xml .= '</Message>';
  $xml .= '</RequestContext>';
  $xml .= '<ServiceRequest>';
    $xml .= '<ServiceId>OCMWCPASPensionRegisterConsult</ServiceId>';
    $xml .= '<Version>20090706</Version>';
    $xml .= '<ns1:Penskad_OpenPK_ConsultRequest xmlns:ns1="http://www.ksz-bcss.fgov.be/XSD/SSDN/PensionRegister">';
      $xml .= '<ns1:TargetSSIN>' . $params['ServiceRequest_TargetSSIN'] . '</ns1:TargetSSIN>';
      $xml .= '<ns1:Period>';
        $xml .= '<ns1:StartDate>' . $params['ServiceRequest_PeriodStartDate'] . '</ns1:StartDate>';
        $xml .= '<ns1:EndDate>' . $params['ServiceRequest_PeriodEndDate'] . '</ns1:EndDate>';
      $xml .= '</ns1:Period>';
      $xml .= '<ns1:RequestedData>';
        $xml .= '<ns1:Pillar>' . $params['ServiceRequest_RequestedDataPillar'] . '</ns1:Pillar>';
        $xml .= '<ns1:RequestedInformation>' . $params['ServiceRequest_RequestedDataRequestedInformation'] . '</ns1:RequestedInformation>';
        $xml .= '<ns1:Focus>' . $params['ServiceRequest_RequestedDataFocus'] . '</ns1:Focus>';
      $xml .= '</ns1:RequestedData>';
      $xml .= '<ns1:Language>FR</ns1:Language>';
    $xml .= '</ns1:Penskad_OpenPK_ConsultRequest>';
  $xml .= '</ServiceRequest>';
$xml .= '</SSDNRequest>';

$retour['ARG_SOAP'] = json_decode(json_encode((array) simplexml_load_string($xml)), 1);

// Envoi du flux à la BCSS
$soapWsdl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['PHP_SELF']) . '../../../include/soap/autres/' . $env . '/KSZBCSSWebServiceConnectorPort.wsdl';

$soapResult = NULL;

try {
    $retour['succes'] = 1;

    $soapClient = new SoapClient($soapWsdl, array('trace' => true, 'connection_timeout' => 10, 'soap_version' => SOAP_1_1,
        'stream_context' => stream_context_create (
            array (
                'ssl'=> array (
                    'verify_peer'     => false,
                    'verify_peer_name' => false
                )
            )
        )
    ));
    
    $soapResult = simplexml_load_string($soapClient->sendXML(new SoapParam($xml, 'xmlString')));
} catch (Exception $e) {
    $retour['succes'] = 0;
    $retour['data']['status']['description'] = $e->getMessage();
}

$soapResultCommon = $soapResult->ServiceReply->children('http://www.ksz-bcss.fgov.be/XSD/SSDN/Common');
$soapResultPensionRegister = $soapResult->ServiceReply->children('http://www.ksz-bcss.fgov.be/XSD/SSDN/PensionRegister');

if (strval($soapResultCommon->ResultSummary->ReturnCode) == '0') {
    $retour['data']['status']['value'] = 'DATA_FOUND';
    $retour['data']['pension'] = $soapResultPensionRegister->Penskad_OpenPK_ConsultReply;
} else {
    $retour['data']['status']['value'] = 'NO_DATA_FOUND';
    $retour['data']['status']['code'] = strval($soapResultCommon->ResultSummary->Detail->ReasonCode);
    $retour['data']['status']['description'] = strval($soapResultCommon->ResultSummary->Detail->Diagnostic);
}

echo json_encode($retour);
