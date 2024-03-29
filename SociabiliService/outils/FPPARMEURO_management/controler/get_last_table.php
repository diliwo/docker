<?php

        require_once("../model/Factory.php");
        require_once("../model/Manager.php");

        $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
        $ntabl1Max = $FPPARMEUROManager->GetNtable1Max();
        $recordsTable = $FPPARMEUROManager->GetAllRecordsByTable($ntabl1Max);

        require("../view/tableau_head.html");
        
        if(!empty($recordsTable)){
            
            foreach($recordsTable as $record){

                require("../view/tableau_data.html");
            }
        }
        require("../view/tableau_foot.html");
        