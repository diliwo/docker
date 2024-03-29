<?php 
    $mutation = new Mutation($_GET["id"]);
    
    $resultat = $mutation->stopCarmed();
    
    include(__DIR__."/../view/stopCarmed.php");
?>