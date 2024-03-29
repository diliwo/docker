<?php 
	include("../model/template.php");
	include("../model/databaseManager.php");
	
	/*$template = new Template($id_template);	
	$template->loadData();*/
	
	$DBM = new databaseManager();
	
	if(!empty($_GET))
	{
		$template = Template::createFromJSON($_GET["template"]);
	}
	else
	{
		$template = Template::createFromJSON($_POST["template"]);
	}
	
	
	$template->loadData($DBM->connexionDB);
	
	echo $template->ToJSON();
	
?>