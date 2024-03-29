<?php 
    include("model/mutation.class.php");
    $mutation = new Mutation();
    $mutation->get_data_from_file("flux",$_POST["file"]);
    $mutation->info(); 
?>