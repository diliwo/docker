<?php

    require_once("../model/Factory.php");
    require_once("../model/Manager.php");

    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    $FPPARMEUROObject = Factory::createObject('FPPARMEURO');

    $FPPARMEUROObject->hydrate($_POST);

    $nseq1 = $FPPARMEUROManager->GetNtable1Max();
    $nseq1++;
    $FPPARMEUROObject->nseq1 = $nseq1;
    $FPPARMEUROObject->ntabl1 = 0 ;

    if(!$FPPARMEUROManager->AddRecordsByObject($FPPARMEUROObject)){

         echo '<div class="alert alert-danger" role="alert"><strong>Attention!</strong> Echec de l\'ajout de la table, veuillez contacter l\'administrateur.</div>';            
    }
?>