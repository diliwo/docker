<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header('Content-Type: application/json');

include("../../../config/config.php");

$retour = array("succes" => 0); 
// Récupération et génération des arguments
if(isset($_GET["registre_national"]) ) {
    $username=$_config["flux"]["username"];
    
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
            
    $startDate = clone $now;
    $startDate->modify("-1 year");
    
    $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]) . "../../../../../include/soap/self_employed/v1/".$env."/SelfEmployedV1.wsdl";

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

    $dateDebut = $startDate->format('Y-m-d');
    if ((isset($_GET["date_debut"])) && (!empty($_GET["date_debut"]))) 
        $dateDebut = $_GET['date_debut'];
    
    $dateFin = $now->format('Y-m-d');
    if ((isset($_GET["date_fin"])) && (!empty($_GET["date_fin"]))) 
        $dateFin = $_GET['date_fin'];
    
    $beginYear = NULL;
    if(isset($_GET['q_date_debut'])  && is_numeric($_GET['q_date_debut']) )
        $beginYear = $_GET['q_date_debut'];
        
    $beginQuarter = NULL;
    if(isset($_GET['debut_quadr'])  && is_numeric($_GET['debut_quadr']) )
        $beginQuarter = $_GET['debut_quadr'];
            
    $endYear = NULL;
    if(isset($_GET['q_date_fin'])  && is_numeric($_GET['q_date_fin']) )
        $endYear = $_GET['q_date_fin'];
                
    $endQuarter = NULL;
    if(isset($_GET['fin_quadr'])  && is_numeric($_GET['fin_quadr']) )
        $endQuarter = $_GET['fin_quadr'];
                
    $reference = "8";
	$reference = $_config["flux"]["numero_organisation"] . $reference . str_pad($random, 9, "0", STR_PAD_LEFT);
    
    $arguments = array(
        "informationCustomer" => array(
            "ticket" => $reference,
            "timestampSent" => $now->format("Y-m-d")."T".$now->format("H:i:s")."Z",
            "customerIdentification" => array(
                "cbeNumber" => $_config["flux"]["cbe_number"],
                "sector" => $_config["flux"]["secteur"],
                "institution" => $_config["flux"]["institution"]
            )
        ),
        "legalContext" => "PCSA:SOCIAL_INQUIRY", // SOCIAL_INVESTIGATION_OF_PCSA // PCSA:SOCIAL_INQUIRY
        "criteria" => array(
            "ssin" => $_GET["registre_national"],
            "careerPeriod" => array(
                "beginDate"=> $dateDebut,
                "endDate"=> $dateFin
            
            ),
            "contributionPeriod" =>array(
                "beginQuarter"=>array(
                    "year"=> (is_null($beginYear) ? $startDate->format('Y') : $beginYear ),
                    "quarter"=>(is_null($beginQuarter) ? 1 : $beginQuarter )
                ),
                "endQuarter"=>array(
                    "year"=> (is_null($endYear) ? $now->format('Y') : $endYear ),
                    "quarter"=> (is_null($endQuarter) ? 1 : $endQuarter )
                )
            )
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
                'stream_context'     => stream_context_create (
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
        
        $retour["data"] = $soapClient->consultCareerAndContributions($arguments);
        
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
