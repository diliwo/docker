<?php

    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
    require_once("../model/Manager.php");


    require_once("../model/Factory.php");
    require_once("../model/FPPARMEUROManager.php");
    include("../view/head.html");
    include("../view/header.html");
    $FPPARMEUROManager = Factory::createManager('FPPARMEUROManager');
    $tablesFPPARMEURO = $FPPARMEUROManager->GetAllTables();
    //include("../view/left_area.html");
    include("../view/center_area.html");
    //include("../view/right_area.html");
    include("../view/footer.html");
    