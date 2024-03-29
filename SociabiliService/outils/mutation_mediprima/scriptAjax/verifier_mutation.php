<?php 
    include(__DIR__."/../config/config.php");
    include(__DIR__."/../model/autoloader.class.php");
    
    $db = DatabaseManager::getDb();
    
    $requete = "update med_mutation set verifie = 1 where ID_MUTATION = ".$_GET["id"];
    
    $stid = oci_parse($db, $requete);
    $oci_error = 0;
    
    if (!@oci_execute($stid))
    {
        echo $requete;
        echo "erreur";
    }
    else
    {
        echo "succes";
    }
?>