<?php
    require_once("../model/Factory.php");
    require_once("../model/Manager.php");

    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    $FPPARMEUROObject = Factory::createObject('FPPARMEURO');
    $FPPARMEUROObject->hydrate($_POST);
    
    if(!$FPPARMEUROManager->DeleteRecordsByObject($FPPARMEUROObject)){

        echo '<div class="alert alert-danger" role="alert"><strong>Attention!</strong> Echec de la suppression du record, veuillez contacter l\'administrateur.</div>';
    }