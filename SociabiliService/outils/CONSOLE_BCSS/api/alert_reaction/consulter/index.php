<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

header('Content-Type: application/json');

include("../../../config/config.php");
 
$retour = array("succes" => 0);
if ( ( isset($_GET["alertId"]) ) && ( isset($_GET["formNumber"]) ) && ( isset($_GET["codeM"]) ) ) {

	// Récupération et génération des arguments
	//$username=$_config["flux"]["username"];
	$username = $_config["flux"]["username"];

	if (isset($_GET["username"]))
		$username= $_GET["username"];
	$password="p4350415330B4474DD5238F01EBE4";
	if (isset($_GET["password"]))
		$password= $_GET["password"];

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
	
	$alertId    = ( is_numeric($_GET["alertId"])    ? (int)$_GET["alertId"]    : 1 ) ;
	$formNumber = ( is_numeric($_GET["formNumber"]) ? (int)$_GET["formNumber"] : 1 ) ;
	$code       = ( is_numeric($_GET["codeM"])      ? (int)$_GET["codeM"]      : 1 ) ;
	
	$wsdl = absolutePath('include/soap/alert_reaction/'.$env.'/pcsa-alert-reaction-wsdl/intf/PcsaAlertReactionService/PcsaAlertReactionV1.wsdl');
	
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

    /*
     * PCSA:SOCIAL_FRAUD
     * SOCIAL_INVESTIGATION_OF_PCSA 
     * PCSA:SOCIAL_INQUIRY
     */
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
		"legalContext" => "PCSA:SOCIAL_FRAUD",
	    "motivations" => array(
	        "motivation" => array(
	           "alertId" => $alertId,
	            "formNumber" => $formNumber,
	            "code" => $code
	        )
	    )
	);
	
	if (!empty($_GET["comment"]) ) {
	    $arguments["motivations"]["motivation"]["comment"] = $_GET["comment"];
	    
	}
	
	$retour['ARG_SOAP'] = json_decode(json_encode($arguments, JSON_FORCE_OBJECT));
	
	// Création et connexion au webservice SOAP
	ini_set("default_socket_timeout", 15);
	$soapClient = new SoapClient($wsdl, array("login" => $username, "password" => $password, "trace" => true, "connection_timeout"=>10,
	    'stream_context' => stream_context_create (
	        array (
	            'ssl'=> array (
	                'verify_peer'     => false,
	                'verify_peer_name' => false
	            )
	        )
        )
	));
	
	try {
	    
	    $retour["data"] = $soapClient->motivateDecision($arguments);
	    
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

function absolutePath($dir, $protocol = 'http', $root = '', $max = 10) {
    
    $pi = pathinfo($dir);
    $path = NULL;
    try {
        
        $it = new DirectoryIterator($root.$pi['dirname']);
        while($it->valid()) {
            
            if($it->current() == $pi['basename']) {
                $path  =  $protocol . '://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['PHP_SELF']) . $root . $dir;
                break;
            }
            $it->next();
            
        }
        
    } catch ( Exception $e ) {
        $root .= '../';
        if( $max > 0 ) {
            return absolutePath($dir, $protocol, $root, --$max);
            
        }
    }
    return $path ;
}

