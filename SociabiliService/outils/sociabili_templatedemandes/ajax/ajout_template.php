<?php 

	include("../model/template.php");
	include("../model/databaseManager.php");

	$DBM = new DatabaseManager();
	$template = Template::recupFromJSON_add($_POST["template"]);
	
	$retour = $template->addTemplate($DBM->connexionDB);
	
	echo "<option >".$retour." </option>\n";
	
	$liste_template = Template::getAllTemplate($DBM->connexionDB);
	
	foreach($liste_template as $template)
		{	
			echo "<option  value='".$template->id_template."' >".$template->id_type." ".$template->id_sous_type." ".$template->id_verbe." ".$template->libelle." </option>\n";
		}
	

?>
