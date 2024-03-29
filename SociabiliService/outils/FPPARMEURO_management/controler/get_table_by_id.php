<?php

        require_once("../model/Factory.php");
        require_once("../model/Manager.php");

        $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
        $recordsTable = $FPPARMEUROManager->GetAllRecordsByTable($_POST['id_table']);
        require("../view/tableau_head.html");

        if(!empty($recordsTable)){
            foreach($recordsTable as $record){

                require("../view/tableau_data.html");
            }
        }
        
        require("../view/tableau_foot.html");
        



?>