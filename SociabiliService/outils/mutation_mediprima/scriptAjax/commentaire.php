<?php 
    include(__DIR__."/../config/config.php");
    include(__DIR__."/../model/autoloader.class.php");
    
    $id_mutation = explode("_",$_POST["ID_MUTATION"]);
    $id_mutation = $id_mutation[1];
    
    $db = DatabaseManager::getDb();
    
    $requete = "update med_mutation set commentaire = '".str_replace("'","''",$_POST["COMMENTAIRE"])."' where ID_MUTATION = ".$id_mutation;
    
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