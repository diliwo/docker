<?php
    session_start();
    
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('display_errors', '1');

    include("view/header.php");
    
    include("controller/principal.php");
    
    include("view/footer.php");
 ?>