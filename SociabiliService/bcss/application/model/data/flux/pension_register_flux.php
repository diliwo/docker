<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';

class PensionRegisterFlux extends OldFlux
{
  public function getData($niss, $dateDebut = '', $dateFin = '', $pillar = 'FirstSecond', $information = 'RightsMaximumPayments', $type = 'ReferencePeriod')
  {
    // Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient)) {
      return null;
    }

    // Calcul de la période si elle n'est pas fournie
    if (empty($dateDebut) || empty($dateFin)) {
      $today = new DateTime();
      $dateFin = $today->format('Y-m-d');
      $dateDebut = $today->modify('-1 year')->format('Y-m-d');
    }

    // Préparation du flux
    $xml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
    $xml .= '<SSDNRequest xmlns="http://www.ksz-bcss.fgov.be/XSD/SSDN/Service">';
      $xml .=		$this->arguments;
      $xml .= '<ServiceRequest>';
        $xml .= '<ServiceId>OCMWCPASPensionRegisterConsult</ServiceId>';
        $xml .= '<Version>20090706</Version>';
        $xml .= '<ns1:Penskad_OpenPK_ConsultRequest xmlns:ns1="http://www.ksz-bcss.fgov.be/XSD/SSDN/PensionRegister">';
          $xml .= '<ns1:TargetSSIN>' . $niss . '</ns1:TargetSSIN>';
          $xml .= '<ns1:Period>';
            $xml .= '<ns1:StartDate>' . $dateDebut . '</ns1:StartDate>';
            $xml .= '<ns1:EndDate>' . $dateFin . '</ns1:EndDate>';
          $xml .= '</ns1:Period>';
          $xml .= '<ns1:RequestedData>';
            $xml .= '<ns1:Pillar>' . $pillar . '</ns1:Pillar>';
            $xml .= '<ns1:RequestedInformation>' . $information . '</ns1:RequestedInformation>';
            $xml .= '<ns1:Focus>' . $type . '</ns1:Focus>';
          $xml .= '</ns1:RequestedData>';
          $xml .= '<ns1:Language>FR</ns1:Language>';
        $xml .= '</ns1:Penskad_OpenPK_ConsultRequest>';
      $xml .= '</ServiceRequest>';
    $xml .= '</SSDNRequest>';

    // Envoi du flux à la BCSS
    $retour = array();

    try {
      $soapResult = simplexml_load_string($this->soapClient->sendXML(new SoapParam($xml, 'xmlString')));

      $soapResultCommon = $soapResult->ServiceReply->children('http://www.ksz-bcss.fgov.be/XSD/SSDN/Common');
      $soapResultPensionRegister = $soapResult->ServiceReply->children('http://www.ksz-bcss.fgov.be/XSD/SSDN/PensionRegister');

      if (strval($soapResultCommon->ResultSummary->ReturnCode) == '0') {
        $retour['error'] = '0';
        $retour['items'] = $soapResultPensionRegister->Penskad_OpenPK_ConsultReply->PensionItem;
      } else {
        $retour['error'] = '1';
        $retour['message'] = strval($soapResultCommon->ResultSummary->Detail->Diagnostic);
      }
    } catch (Exception $e) {
      $retour['error'] = '1';
      $retour['message']  = 'Impossible de se connecter au flux.';
    }

    return $retour;
  }
}
