<?php 

	include("../model/template.php");
	include("../model/databaseManager.php");

	$DBM = new DatabaseManager();
	
	
	
	$liste_Templates = Template::Lister($DBM->connexionDB, $_GET["ta"],$_GET["sta"],$_GET["v"],$_GET["libelle"],$_GET["cl"]);
	
	if(!empty($liste_Templates))
	{
		foreach($liste_Templates as $template)
		{	
			echo "<option  value='".$template->id_template."' >".$template->id_type." ".$template->id_sous_type." ".$template->id_verbe." ".$template->libelle." </option>\n";
		}
	}
?>
