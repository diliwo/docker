<?php

header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => "0");
if (isset($_GET["registre_national"])) {
	$retour["succes"] = "1";

	// Récupération et génération des arguments
	$username=$_config["flux"]["username"];
	if (isset($_GET["username"]))
		$username= $_GET["username"];
	$password="p4350415330B4474DD5238F01EBE4";
	if (isset($_GET["password"]))
		$password= $_GET["password"];
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

	$now = new DateTime();
	$now->setTimezone(new DateTimeZone("Europe/Brussels"));

	$quadrimestre = ceil($now->format("m") / 4);
	if ((isset($_GET["quadrimestre"])) && (!empty($_GET["quadrimestre"]))) {
		$quadrimestre = $_GET['quadrimestre'];
	}
	$annee = $now->format('Y');
	if ((isset($_GET["annee"])) && (!empty($_GET["annee"]))) {
		$annee = $_GET['annee'];
	}

	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../include/soap/unemployment_data/".$env."/UnemploymentDataServiceV1.wsdl";
	
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
	
	$arguments = array(
		"informationCustomer" => array(
			"ticket" => $reference,
			"timetampSent" => $now->format("Y-m-d")."T".$now->format("H:i:s")."Z",
			"customerIdentification" => array(
				"cbeNumber" => $_config["flux"]["cbe_number"],
				"sector" => $_config["flux"]["secteur"],
				"institution" => $_config["flux"]["institution"]
			)
		),
		"legalContext" => "SOCIAL_INVESTIGATION_OF_PCSA"
	);

		$arguments = array(
			"informationCustomer" => array(
				"ticket" => $reference,
				"timetampSent" => $now->format("Y-m-d")."T".$now->format("H:i:s")."Z",
				"customerIdentification" => array(
					"cbeNumber" => $_config["flux"]["cbe_number"],
					"sector" => $_config["flux"]["secteur"],
					"institution" => $_config["flux"]["institution"]
				)
			),
			"legalContext" => "SOCIAL_INVESTIGATION_OF_PCSA",
			"searchCriteria" => array(
				"ssin" => $rn,
				"quarter" => array(
					"quarterNumber" => $quadrimestre,
					"year" => $annee
				)
			)
		);
	
	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10));
	try {
		$retour["data"] = $soapClient->getPayedActivationSums($arguments);

	} catch (Exception $e) {
		$retour["error"] = $e->getMessage();

	}

	

}

echo json_encode($retour);