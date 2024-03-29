<?php

    require_once("../model/Factory.php");
    require_once("../model/Manager.php");

    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    $FPPARMEUROObject = Factory::createObject('FPPARMEURO');
    $FPPARMEUROObject->hydrate($_POST);

    //var_dump($FPPARMEUROObject);

    if(!$FPPARMEUROManager->UpdateRecordsByObject($FPPARMEUROObject)){

         echo '<div class="alert alert-danger" role="alert"><strong>Attention!</strong> Echec de la modification du record, veuillez contacter l\'administrateur.</div>';   
    }
?>