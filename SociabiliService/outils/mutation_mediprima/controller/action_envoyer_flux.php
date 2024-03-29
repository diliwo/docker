<?php 
    if(!defined("WSDL"))
    {define("WSDL", "wsdl/eCarmedPSWC.wsdl");}

    if(!defined("USER"))
    {define("USER", "E0212358536");}

    if(!defined("PASSWORD"))
    {define("PASSWORD", "p4350415330B4474DD5238F01EBE4");}

    if(!defined("CBENUMBER"))
    {define("CBENUMBER", "0212358536");}

    if(!defined("LEGALCONTEXT"))
    {define("LEGALCONTEXT", "manage eCarmed");}

    $soapClient = new SoapClient(WSDL, array('login' =>USER, 'password' => PASSWORD, 'trace' => true, 'connection_timeout'=>10));
    try
    {
        $request = array();
        
        //XMLToArray
        $flux = new XMLToArrayForMediPrima($_POST["flux"]);
        
        
        
        $temp = $flux->renvoieArraySimple();
        
        echo "<br><br>Envoi de :<pre>";        
        print_r($temp);
        echo "</pre>";
        
        $request = $temp;        
        
        $soapClient->stopCarmed($request);
        $requestXML = Mutation::arrayToXML($request);
    }
    catch (Exception $e)
    {
        ?>
            <h1>Une erreur est survenue, la carte n'a pu être stoppée.</h1>
        <?php
        $succes = 0;
        echo "<pre>";
        print_r($e);
        echo "</pre>";
        $message=$e->getMessage();
        $xml="";
    }
    
    $retour = $soapClient->__getLastResponse();
        
    $dom = new DomDocument();
    $dom->loadXML($retour);
    
    $resultat = $dom->getElementsByTagName('value')->item(0)->nodeValue;
    
    if($resultat == "NO_RESULT")
    {
        //erreur
        $message = $dom->getElementsByTagName('communication')->item(0)->nodeValue;
        $resultat =  array("resultat"=>0,"message"=>$message,"xmlEnvoye"=>$requestXML,"xmlRecu"=>$retour);
    }
    else
    {
        $resultat =   array("resultat"=>1,"message"=>"Succès","xmlEnvoye"=>$requestXML,"xmlRecu"=>$retour);
    }
    
        
    include(__DIR__."/../view/stopCarmed.php");