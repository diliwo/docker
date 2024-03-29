<?php

header('Content-Type: application/json');

$retour = array("succes" => "0");
if (isset($_GET["registre_national"])) {
	$retour["succes"] = "1";

	// Récupération et génération des arguments
	$username="E0212358536";
	if (isset($_GET["username"]))
		$username= $_GET["username"];
	$password="p4350415330B4474DD5238F01EBE4";
	if (isset($_GET["password"]))
		$password= $_GET["password"];
	$rn = $_GET["registre_national"];

	// Récupération de l'environnement
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

	// Récupération du critère de temps
	// TODO car non-implémenté à la BCSS pour le moment (17/07/2014)

	// Récupération de la date du jour
	$now = new DateTime();
	$now->setTimezone(new DateTimeZone("Europe/Brussels"));

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
		$reference = rand(0,9);

	}
	$reference = "520118" . str_pad($reference, 9, "0", STR_PAD_LEFT);

	// Génération des arguments à envoyer
	$arguments = array(
		"informationCustomer" => array(
			"ticket" => $reference,
			"timetampSent" => $now->format("Y-m-d")."T".$now->format("H:i:s")."Z",
			"customerIdentification" => array(
				"cbeNumber" => "0212358536",
				"sector" => "17",
				"institution" => "1"
			)
		),
		"legalContext" => "Social Rate Investigation",
		"criterion" => array(
			"ssin" => $rn
		)
	);

	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../includes/soap/social_rate_investigation/".$env."/SocialRateInvestigation.wsdl";
	$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10));
	try {
		$retour["data"] = $soapClient->consultExchangedData($arguments);

	} catch (Exception $e) {
		$retour["error"] = $e->getMessage();

	}

}

echo json_encode($retour);
