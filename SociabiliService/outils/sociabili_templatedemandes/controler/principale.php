<?php 

	$DBM = new DatabaseManager();
		
	$liste_template = Template::getAllTemplate($DBM->connexionDB);
	
	include("view/principale.php");
?>