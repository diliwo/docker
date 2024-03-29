<?php

header("Content-Type: application/json");

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

	// Récupération de la date du jour
	$now = new DateTime();
	$now->setTimezone(new DateTimeZone("Europe/Brussels"));

	// Récupération et initialisation des dates à placer en paramêtre
	$dateDebut = clone $now;
	$dateDebut->modify("-1 years");
	if ((isset($_GET["date_debut"])) && (!empty($_GET["date_debut"]))) {
		$dateDebut = DateTime::createFromFormat("Y-m-d", $_GET["date_debut"], new DateTimeZone("Europe/Brussels"));
	}
	$dateFin = null;
	if ((isset($_GET["date_fin"])) && (!empty($_GET["date_fin"]))) {
		$dateFin = DateTime::createFromFormat("Y-m-d", $_GET["date_fin"], new DateTimeZone("Europe/Brussels"));
	}
	// Récupération et initialisation des années et quadrimestres à placer en paramêtre
	$quadrimestreDebut = ceil($dateDebut->format("m") / 3);
	if ((isset($_GET["quadrimestre_debut"])) && (!empty($_GET["quadrimestre_debut"]))) {
		$quadrimestreDebut = $_GET["quadrimestre_debut"];
	}
	$anneeDebut = $dateDebut->format("Y");
	if ((isset($_GET["annee_debut"])) && (!empty($_GET["annee_debut"]))) {
		$anneeDebut = $_GET["annee_debut"];
	}
	if (!is_null($dateFin)) {
		$dateFinQuadrimestre = clone $dateFin;
	} else {
		$dateFinQuadrimestre = clone $now;
	}
	$quadrimestreFin = ceil($dateFinQuadrimestre->format("m") / 3);
	if ((isset($_GET["quadrimestre_fin"])) && (!empty($_GET["quadrimestre_fin"]))) {
		$quadrimestreFin = $_GET["quadrimestre_fin"];
	}
	$anneeFin = $dateFinQuadrimestre->format("Y");
	if ((isset($_GET["annee_fin"])) && (!empty($_GET["annee_fin"]))) {
		$anneeFin = $_GET["annee_fin"];
	}

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
		"legalContext" => "PCSA:SOCIAL_INQUIRY"
	);

	// Mise en place des critères de recherche
	if (!is_null($dateFin)) {
		$periodeCarriere = array(
			"beginDate" => $dateDebut->format("Y-m-d"),
			"endDate" => $dateFin->format("Y-m-d")
		);

	} else {
		$periodeCarriere = array(
			"beginDate" => $dateDebut->format("Y-m-d")
		);

	}
	$arguments["criteria"] = array(
		"ssin" => $_GET["registre_national"],
		"careerPeriod" => $periodeCarriere,
		"contributionPeriod" => array(
			"beginQuarter" => array(
				"year" => $anneeDebut,
				"quarter" => $quadrimestreDebut
			),
			"endQuarter" => array(
				"year" => $anneeFin,
				"quarter" => $quadrimestreFin
			)
		)
	);

	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../include/soap/self_employed/".$env."/SelfEmployedV1.wsdl";

	try {
		$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10));
		$retour["data"] = $soapClient->consultCareerAndContributions($arguments);

	} catch (Exception $e) {
		$retour["error"] = $e->getMessage();

	}

}

echo json_encode($retour);
