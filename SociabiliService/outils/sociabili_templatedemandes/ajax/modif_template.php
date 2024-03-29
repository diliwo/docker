<?php 

	include("../model/template.php");
	include("../model/databaseManager.php");

	$DBM = new DatabaseManager();
	$template = Template::createFromJSON_mod($_POST["template"]);
		
	$test = $template->modTemplate($DBM->connexionDB,$template->id_template,$template->libelle,$template->template,$template->id_type,$template->id_sous_type,$template->id_verbe, $template->id_code_langue);
	
	$liste_template = Template::getAllTemplate($DBM->connexionDB);
	
	foreach($liste_template as $template)
		{	
			echo "<option value='".$template->id_template."' >".$template->id_type." ".$template->id_sous_type." ".$template->id_verbe." ".$template->libelle." </option>\n";
		}
?>
