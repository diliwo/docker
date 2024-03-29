<?php

header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => 0);
if ((isset($_GET["registre_national"])) && (isset($_GET["nom_famille"])) && (isset($_GET["date_naissance"]))) {
	// On récupère la date et l'heure de maintenant avec le timezone correct
	$now = new DateTime();
	$now->setTimezone(new DateTimeZone('Europe/Brussels'));

	// Environnement
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

	// Récupération et génération des arguments
	$rn = $_GET["registre_national"];
	$nomFamille = $_GET["nom_famille"];
	$dateNaissance = $_GET["date_naissance"];

	$codeQualite = 1;
	if (isset($_GET["code_qualite"])) {
		switch ($_GET["code_qualite"]) {
			case "1":
				$codeQualite = "1";
				break;

			case "2":
				$codeQualite = "2";
				break;

			case "3":
				$codeQualite = "3";
				break;

			case "4":
				$codeQualite = "4";
				break;

			case "5":
				$codeQualite = "5";
				break;

			case "6":
				$codeQualite = "6";
				break;

			case "40":
				$codeQualite = "40";
				break;
			
			default:
				$codeQualite = "1";
				break;
		}
	}

	$dateDebut = $now->format("Y-m-d");
	if (isset($_GET["date_debut"])) {
		$dateDebut = $_GET["date_debut"];
	}
	
	$dateFin = "";
	if (isset($_GET["date_fin"])) {
		$dateFin = $_GET["date_fin"];
	} //else {
	//	$dateTemp = DateTime::createFromFormat("Y-m-d", $dateDebut);
	//	$dateTemp->modify("+3 months");
	//	$dateFin = $dateTemp->format("Y-m-d");
	//}
	
	//-------------------//
	// Test de connexion //
	//-------------------//
	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../include/soap/autres/" . $env . "/TestConnectionService.wsdl";
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
		$referenceFile = "../../reference.txt";
		if (file_exists($referenceFile)) {
			$fp = fopen ($referenceFile, "r+");
			$reference = fgets ($fp, 10);
			$newReference = $reference + 1;
			fseek ($fp, 0);
			fputs ($fp, $newReference);
			fclose ($fp);

		} else {
			$random = rand(0,9);

		}
		$reference = "8";
	$reference = $_config["flux"]["numero_organisation"] . $reference . str_pad($random, 9, "0", STR_PAD_LEFT);
		
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
			$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../include/soap/autres/" . $env . "/KSZBCSSWebServiceConnectorPort.wsdl";
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
	
			$xml  =	
			"<?xml version='1.0' encoding='UTF-8' standalone='yes'?>" .
			"<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>" .
			$arguments .
				"<ServiceRequest>" .
					"<ServiceId>OCMWCPASManageAccess</ServiceId>" .
					"<Version>20050930</Version>" .
						"<ns1:ManageAccessRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAccess'>" .
							"<ns1:SSIN>" . $rn . "</ns1:SSIN>" .
							"<ns1:Purpose>".$codeQualite."</ns1:Purpose>" .
							"<ns1:Period>" .
								"<ns2:StartDate xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateDebut."</ns2:StartDate>";
							if (!empty($dateFin))
								$xml .= "<ns3:EndDate xmlns:ns3='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateFin."</ns3:EndDate>";
			$xml .=
							"</ns1:Period>" .
							"<ns1:Action>UNREGISTER</ns1:Action>" .
							"<ns1:Sector>".$_config["flux"]["secteur"]."</ns1:Sector>" .
							"<ns1:QueryRegister>SECONDARY</ns1:QueryRegister>" .
							"<ns1:ProofOfAuthentication>" .
								"<ns1:PersonData>" .
									"<ns1:LastName>".$nomFamille."</ns1:LastName>" .
									"<ns1:BirthDate>".$dateNaissance."</ns1:BirthDate>" .
								"</ns1:PersonData>" .
							"</ns1:ProofOfAuthentication>" .
						"</ns1:ManageAccessRequest>" .
				"</ServiceRequest>" .
			"</SSDNRequest>";
			
			$retour['ARG_SOAP'] = json_decode(json_encode((array) simplexml_load_string($xml)), 1);
			
			try {
				$retour['succes'] = 1;

				$res = $soapClient->sendXML(new SoapParam($xml, 'xmlString'));
				$dom = new DomDocument();
				$dom->loadXML(utf8_encode($res));
	
				$codeErreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
				if ($codeErreur > 1) {
					$retour['data']['status']['value'] = "";
					$retour['data']['status']['code'] = $codeErreur;
					$retour['data']['status']['description'] = "";
				} else {
					$retour['data']['status']['value'] = "OK";
					$retour['data']['integrations'] = array();

					$integrations = $dom->getElementsByTagName('Registrations');
					if ($integrations->length > 0) {
						foreach ($integrations as $i=>$integration) {
							$retour['data']['integrations'][] = array(
								'purpose' => $integration->getElementsByTagName('Purpose')->item(0)->nodeValue,
								'start_date' => $integration->getElementsByTagName('StartDate')->item(0)->nodeValue,
								'end_date' => $integration->getElementsByTagName('EndDate')->item(0)->nodeValue,
								'org_unit' => $integration->getElementsByTagName('OrgUnit')->item(0)->nodeValue,
								'register' => $integration->getElementsByTagName('Register')->item(0)->nodeValue
							);
						}
					}
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
}

echo json_encode($retour);
