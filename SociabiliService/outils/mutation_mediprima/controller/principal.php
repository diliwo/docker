<?php 
    include(__DIR__."/../config/config.php");
    include(__DIR__."/../model/autoloader.class.php");
    
    $compte_new_mut = Mutation::listMutationMysql();
    $compte_new_mut = count($compte_new_mut);
    
    $ctrl = "new";
    
    if(isset($_GET["ctrl"]))
    {
        $ctrl = $_GET["ctrl"];
        if($ctrl == "action_import")
        {
            $compte_new_mut = "?";
        }
    }
    
    include(__DIR__."/../view/menu.php");
    
    if(is_file(__DIR__."/".$ctrl.".php"))
    {
        include(__DIR__."/../controller/".$ctrl.".php");
    }
    else
    {
        //404
        include(__DIR__."/../view/404.php");
    }
    

    