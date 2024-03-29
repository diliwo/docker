<?php

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "tester":
            include_once("mvc/view/living_wages/index.php");
            
            break;
            
        default:
            header("Location: index.php?page=living_wages&action=tester");
            
            break;
    }
} else {
    header("Location: index.php?page=living_wages&action=tester");
    
}