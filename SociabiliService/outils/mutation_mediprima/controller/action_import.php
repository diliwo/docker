<?php 

    //verification
    $verif = 1;
    $message = "";
    $erreur = "";
    
    if(!isset($_POST))
    {
        $erreur = "Aucune donnée reçue pour l'importation.";
        include(__DIR__."/import.php");
    }
    else if(count($_POST) == 0)
    {
        $erreur = "Aucune donnée reçue pour l'importation.";
        include(__DIR__."/import.php");
    }
    else
    {
        $retours = array();
        
        foreach($_POST as $key=>$val)
        {
            //tentative d'importation
            $mutation = Mutation::get_data_from_mysql_by_filename(str_replace("_",".",$key));

            if(is_object($mutation))
            {
                $resultat = $mutation->ajouter();
                $retours[str_replace("_",".",$key)] = $resultat;
            }
            else
            {
               $retours[str_replace("_",".",$key)] = 0;
            }
        }
        
        include(__DIR__."/../view/resultat_import.php");
    }