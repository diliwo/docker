<?php

header('Content-Type: application/json');

$retour = array("succes" => "0");
if (isset($_GET["registre_national"]) && isset($_GET["scope"])) {
	$retour["succes"] = "1";

	// Récupération et génération des arguments
	$username="E0212358536";
	if (isset($_GET["username"]))
		$username= $_GET["username"];
	$password="p4350415330B4474DD5238F01EBE4";
	if (isset($_GET["password"]))
		$password= $_GET["password"];
	$rn = $_GET["registre_national"];
	$scope = $_GET["scope"]; //active, activeInPeriod ou mutations

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

	$testPeriode = false;
	if ( in_array($scope, array("activeInPeriod", "mutations")) ) {
		$testPeriode = true;

		$dateDebut = clone $now;
		$dateDebut->modify("-100 years");
		if ((isset($_GET["date_debut"])) && (!empty($_GET["date_debut"]))) {
			$dateDebut = DateTime::createFromFormat("Y-m-d", $_GET['date_debut'], new DateTimeZone('Europe/Brussels'));
		}
		$dateFin = clone $now;
		if ((isset($_GET["date_fin"])) && (!empty($_GET["date_fin"]))) {
			$dateFin = DateTime::createFromFormat("Y-m-d", $_GET['date_fin'], new DateTimeZone('Europe/Brussels'));
		}

	}

	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../includes/soap/dolsis/".$env."/dolsis2011CBSS_subsetPSWC.wsdl";

	// Récupération et génération de la référence
	$referenceFile = "../../../../includes/soap/reference.txt";
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
		"securityContext" => array(
			"service" => "WELFARE",
			"legalContext" => "SOCIAL_INVESTIGATION_OF_PCSA",
			"role" => "Agent"
		),
		"criteria" => array(
			"ssin" => $rn,
			"scope" => $scope
		)
	);

	if ($testPeriode == true) {
		$arguments["criteria"]["period"] = array(
			"beginDate" => $dateDebut->format("Y-m-d"),
			"endDate" => $dateFin->format("Y-m-d")
		);

	}

	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10));
	try {
		$retour["data"] = $soapClient->findEmployersByWorker($arguments);

	} catch (Exception $e) {
		print_r($e);
		$retour["error"] = $e->getMessage();

	}

}

echo json_encode($retour);
