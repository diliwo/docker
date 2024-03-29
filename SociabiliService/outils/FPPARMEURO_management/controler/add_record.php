<?php

    require_once("../model/Factory.php");
    require_once("../model/Manager.php");

    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    $FPPARMEUROObject = Factory::createObject('FPPARMEURO');
    $FPPARMEUROObject->hydrate($_POST);

    $maxNseq1 = $FPPARMEUROManager->GetMaxNseq1ByTable($FPPARMEUROObject->ntabl1);
    $maxNseq1++;
    $FPPARMEUROObject->nseq1 = $maxNseq1;

    if(!$FPPARMEUROManager->AddRecordsByObject($FPPARMEUROObject)){

         echo '<div class="alert alert-danger" role="alert"><strong>Attention!</strong> Echec de l\'ajout du record, veuillez contacter l\'administrateur.</div>';            
    }
?>