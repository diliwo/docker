<?php

header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => 0);
if (isset($_GET["registre_national"])) {
	// Récupération et génération des arguments
	$rn = $_GET["registre_national"];

	$env = "test";
	if (isset($_GET["env"])) {
		switch ($_GET["env"]) {
			case "acpt":
				$env = "acpt";
				break;

			case "prod":
				$env = "prod";
				break;
			
			default:
				$env = "test";
				break;
		}
	}

	// On récupère la date et l'heure de maintenant avec le timezone correct
	$now = new DateTime();
	$now->setTimezone(new DateTimeZone('Europe/Brussels'));

	$dateDebut = clone $now;
	$dateDebut->modify("-10 years");
	$dateDebut->modify("+1 day");
	if ((isset($_GET["date_debut"])) && (!empty($_GET["date_debut"]))) {
		$dateDebut = DateTime::createFromFormat("Y-m-d", $_GET['date_debut'], new DateTimeZone('Europe/Brussels'));
	}
	$dateFin = clone $now;
	if ((isset($_GET["date_fin"])) && (!empty($_GET["date_fin"]))) {
		$dateFin = DateTime::createFromFormat("Y-m-d", $_GET['date_fin'], new DateTimeZone('Europe/Brussels'));
	}

	
	//-------------------//
	// Test de connexion //
	//-------------------//
	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../include/soap/autres/" . $env . "/TestConnectionService.wsdl";
	$soapClient = new SoapClient($wsdl, array('trace'=>true, 'connection_timeout'=>10, 'soap_version'=>SOAP_1_1,
	    'stream_context' => stream_context_create (
	        array (
	            'ssl'=> array (
	                'verify_peer'     => false,
	                'verify_peer_name' => false
	            )
	        )
        )
	));
	
	// Connexion au WS
	$res = $soapClient->sendTestMessage(array('echo'=> 'test'));
	unset ($soapClient);
	
	if ($res->echo == "test") {
		// Récupération et génération de la référence
		$referenceFile = "../../../reference.txt";
		if (file_exists($referenceFile)) {
			$fp = fopen ($referenceFile, "r+");
			$reference = fgets ($fp, 10);
			$newReference = $reference + 1;
			fseek ($fp, 0);
			fputs ($fp, $newReference);
			fclose ($fp);

		} else {
			$random = rand(0,10);

		}
		$reference = $_config["flux"]["numero_organisation"] . str_pad($random, 10, "0", STR_PAD_LEFT);
		
		//-------------------------------------------//
		// Connexion au webservice 'identify person' //
		//-------------------------------------------//
		$arguments  =
		"<RequestContext>" .
			"<AuthorizedUser>" .
				"<UserID>".$_config["flux"]["old"]["user_id"]."</UserID>" .
				"<Email>".$_config["flux"]["old"]["email"]."</Email>" .
				"<OrgUnit>".$_config["flux"]["old"]["org_unit"]."</OrgUnit>" .
				"<MatrixID>".$_config["flux"]["secteur"]."</MatrixID>" .
				"<MatrixSubID>".$_config["flux"]["institution"]."</MatrixSubID>" .
			"</AuthorizedUser>" .
			"<Message>" .
				"<Reference>" . $reference . "</Reference>" .
				"<TimeRequest>" . $now->format('Ymd') . "T" . $now->format('His') . "</TimeRequest>" .
				"<Language>fr</Language>" .
			"</Message>" .
		"</RequestContext>";
	
		try {
			$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../include/soap/autres/" . $env . "/KSZBCSSWebServiceConnectorPort.wsdl";
			$soapClient = new SoapClient($wsdl, array('trace'=>true, 'connection_timeout'=>10, 'soap_version'=>SOAP_1_1,
			    'stream_context' => stream_context_create (
			        array (
			            'ssl'=> array (
			                'verify_peer'     => false,
			                'verify_peer_name' => false
			            )
			        )
                )
			));
			
			$xml = 
			"<?xml version='1.0' encoding='UTF-8' standalone='yes'?>" .
			"<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>" .
			$arguments .
				"<ServiceRequest>" .
					"<ServiceId>OCMWCPASListOfAttestations</ServiceId>" .
					"<Version>20080317</Version>" .
					"<ns1:ListOfAttestationsRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAttests' xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>" .
						"<ns1:SocialSecurityUser>" . $rn . "</ns1:SocialSecurityUser>" .
						"<ns1:RequestType>STATUT65</ns1:RequestType>" .
						"<ns1:SearchPeriod>" .
							"<ns2:StartDate>" . $dateDebut->format("Y-m-d") . "</ns2:StartDate>" .
							"<ns2:EndDate>" . $dateFin->format("Y-m-d") . "</ns2:EndDate>" .
						"</ns1:SearchPeriod>" .
					"</ns1:ListOfAttestationsRequest>" .
				"</ServiceRequest>" .
			"</SSDNRequest>";
			
			$retour['ARG_SOAP'] = json_decode(json_encode((array) simplexml_load_string($xml)), 1);

			try {
				$retour['succes'] = 1;

				$res = $soapClient->sendXML(new SoapParam($xml, 'xmlString'));
				$simpleXml = new SimpleXMLElement($res);
				$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->ReturnCode[0];
				
				if ($codeErreur > 1) {
					$retour['data']['status']['value'] = "NO_DATA_FOUND";
					$retour['data']['status']['code'] = $codeErreur;
					$retour['data']['status']['description'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->Detail->Diagnostic[0];

				} else {
					$retour['data']['status']['value'] = "DATA_FOUND";
					
				}

			} catch (Exception $e) {
				$retour['succes'] = 0;
				$retour['data']['status']['description']  = $e->getMessage();

			}
	
		} catch (Exception $e) {
			$retour['succes'] = 0;
			$retour['data']['status']['description'] = $e->getMessage();

		}
	
	}

} else {
	$retour["message"] = "Le registre national n'est pas encodé";

}

echo json_encode($retour);
