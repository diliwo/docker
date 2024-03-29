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

	$langue = "fr";
	if (isset($_GET["langue"])) {
		switch ($_GET["langue"]) {
			case "nl":
				$langue = "nl";
				break;
			
			default:
				$langue = "fr";
				break;
		}
	}
	$historicite = true;
	if (isset($_GET["historicite"])) {
		switch ($_GET["historicite"]) {
			case false:
				$historicite = false;
				break;
			
			default:
				$historicite = true;
				break;
		}
	}
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
	$version = "5";
	if (isset($_GET["version"])) {
		switch ($_GET["version"]) {
			case "2":
				$version = "2";
				break;

			case "3":
				$version = "3";
				break;
			
			default:
				$version = "5";
				break;
		}
	}

	$now = new DateTime();
	$now->setTimezone(new DateTimeZone("Europe/Brussels"));

	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../include/soap/transaction25/".$env."/v".$version."/RetrieveTIGroupsV" . $version . ".wsdl";
	
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
		"searchInformation" => array(
			"ssin" => $rn,
			"language" => $langue,
			"history" => $historicite
		)
	);
	
	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10));
	try {
		$retour["data"] = $soapClient->retrieveTI($arguments);

	} catch (Exception $e) {
		$retour["error"] = $e->getMessage();

	}

	

}

echo json_encode($retour);