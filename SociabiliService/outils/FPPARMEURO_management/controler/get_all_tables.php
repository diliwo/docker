<?php

    require_once("../model/Manager.php");
    require_once("../model/Factory.php");

    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    
    $tablesFPPARMEURO = $FPPARMEUROManager->GetAllTables();
    $ntabl1Max = $FPPARMEUROManager->GetNtable1Max();

    
    echo '<option></option>';                            

    foreach($tablesFPPARMEURO as $tableFPPARMEURO){

        if(!empty($_POST['ajout']) && $tableFPPARMEURO->nseq1 == $ntabl1Max ){

            echo("<option selected='selected' value=".$tableFPPARMEURO->nseq1." >".$tableFPPARMEURO->nseq1." ".$tableFPPARMEURO->infor1."</option>");
        }
        else{
            echo("<option value=".$tableFPPARMEURO->nseq1." >".$tableFPPARMEURO->nseq1." ".$tableFPPARMEURO->infor1."</option>");
       }      
    }
                            