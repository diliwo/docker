<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => 0);
if (isset($_GET["registre_national"])) {

	// Récupération et génération des arguments
	//$username=$_config["flux"]["username"];

	$username = $_config["flux"]["username"];

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

	$naturePersonne = 1;
	if ((isset($_GET["nature_personne"])) && (!is_numeric($_GET["nature_personne"]))) 
	    $naturePersonne = $_GET["nature_personne"];
    
	$now = new DateTime();
	$now->setTimezone(new DateTimeZone("Europe/Brussels"));

	$wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../include/soap/cadnet/".$env."/ConsultPatrimonyCPASV1.wsdl";
	
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
            "timestampSent" => $now->format("Y-m-d")."T".$now->format("H:i:s")."Z",
            "customerIdentification" => array(
                "cbeNumber" => $username = $_config["flux"]["cbe_number"],
                "sector" => $_config["flux"]["secteur"],
                "institution" => $_config["flux"]["institution"]
            )
        ),
        "searchCriterion" => array(
            "naturalPerson" => array(
                "ssin" => $rn  
            ),
            "naturePerson" => $naturePersonne,
            "language"=> ( isset($_GET["langue"]) ? strtoupper($_GET["langue"]) : 'FR' )   
        )
    );
	
	$retour['ARG_SOAP'] = json_decode(json_encode($arguments, JSON_FORCE_OBJECT));

	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$soapClient = new SoapClient($wsdl,
	    array(
	        "login" => $username,
	        "password" => $password,
	        "trace" => true,
	        "connection_timeout"=>10,
	        'stream_context' => stream_context_create (
	            array (
	                'ssl'=> array (
	                    'verify_peer'     => false,
	                    'verify_peer_name' => false
	                )
	            )
            )
	    )
    ); 
	
    try {
        
        $retour["data"] = $soapClient->findProperties($arguments);
        
        try {
            
            $iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator( $retour["data"]) );
            
            foreach ( $iterator  as $ik => $iv ) {
                
                if($ik == 'value' || $ik == 'code' || $ik == 'description') {
                    $retour["succes"] = 1;
                    break;
                }
                
            }
            
        } catch ( Throwable $throw ) {
            $retour["succes"] = 0;
            $retour["error"] = $throw->getMessage();
            
        }
        
    } catch ( Exception $e ) {
        $retour["succes"] = 0;
        $retour["error"] = $e->getMessage();
        
    }

}

echo json_encode($retour);
