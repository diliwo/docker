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
	        )));
	
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
				"<ServiceId>OCMWCPASIdentifyPerson</ServiceId>" .
				"<Version>20050930</Version>" .
					"<ns1:IdentifyPersonRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/IdentifyPerson'>" .
						"<ns1:SearchCriteria>" .
							"<ns1:SSIN>" . $rn . "</ns1:SSIN>" .
						"</ns1:SearchCriteria>" .
					"</ns1:IdentifyPersonRequest>" .
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
					$retour['data']['status']['value'] = "NO_DATA_FOUND";
					$retour['data']['status']['code'] = $codeErreur;
					$retour['data']['status']['description'] = "SSIN is not valid";
				} else {
					$retour['data']['status']['value'] = "DATA_FOUND";
					$retour['data']['person'] = array();

					$reply = $dom->getElementsByTagName('ServiceReply');
					if ($reply->length > 0) {
						$retour['data']['person']['ssin'] = $reply->item(0)->getElementsByTagName('SocialSecurityUser')->item(0)->nodeValue;
						$retour['data']['person']['name'] = $reply->item(0)->getElementsByTagName('LastName')->item(0)->nodeValue;
						$retour['data']['person']['firstname'] = $reply->item(0)->getElementsByTagName('FirstName')->item(0)->nodeValue;
						$date_anniversaire_tmp = explode('-', $reply->item(0)->getElementsByTagName('BirthDate')->item(0)->nodeValue);
						$retour['data']['person']['birthdate'] = $reply->item(0)->getElementsByTagName('BirthDate')->item(0)->nodeValue;
						$retour['data']['person']['sex'] = $reply->item(0)->getElementsByTagName('Gender')->item(0)->nodeValue;
						$nodeAddress = $reply->item(0)->getElementsByTagName('Address');
						if ($nodeAddress->length > 0) {
							$retour['data']['person']['address']['street'] = $nodeAddress->item(0)->getElementsByTagName('Street')->item(0)->nodeValue;
							$retour['data']['person']['address']['number'] = $nodeAddress->item(0)->getElementsByTagName('HouseNumber')->item(0)->nodeValue;
							$retour['data']['person']['address']['full'] = $retour['data']['person']['address']['street'] . ", " . $retour['data']['person']['address']['number'];
							if (isset($nodeAddress->item(0)->getElementsByTagName('Box')->item(0)->nodeValue)) {
								$retour['data']['person']['address']['box'] = $nodeAddress->item(0)->getElementsByTagName('Box')->item(0)->nodeValue;
								$retour['data']['person']['address']['full'] .= "/" . $retour['data']['person']['address']['box'];
							}
							$retour['data']['person']['address']['postal_code'] = $nodeAddress->item(0)->getElementsByTagName('PostalCode')->item(0)->nodeValue;
							$retour['data']['person']['address']['city'] = $nodeAddress->item(0)->getElementsByTagName('Municipality')->item(0)->nodeValue;
							$retour['data']['person']['address']['full'] .= " - " . $retour['data']['person']['address']['postal_code'] . " " . $retour['data']['person']['address']['city'];
	
							$retour['data']['person']['address']['street_code'] = $nodeAddress->item(0)->getElementsByTagName('StreetCode')->item(0)->nodeValue;;
						} else {
							$nodeAddress = $reply->item(0)->getElementsByTagName('DiplomaticPost');
							if ($nodeAddress->length > 0) {
								$retour['data']['person']['address']['full'] = $nodeAddress->item(0)->getElementsByTagName('AddressPlainText')->item(0)->nodeValue;
							}
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
