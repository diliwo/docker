<?php 
    
    $mutation = new Mutation($_GET["id"]);
    $refundCodes = Mutation::get_all_refundcode();
    
    include(__DIR__."/../view/visualiser_mutation.php");
?>