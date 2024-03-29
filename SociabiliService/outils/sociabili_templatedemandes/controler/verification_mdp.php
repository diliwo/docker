<?php 
	$DBM = new DatabaseManager();
	if(AdDAP::isValide($_POST["nom_utilisateur"],$_POST["pass"]))
	{
		$user = new Utilisateur($_POST["nom_utilisateur"]);
		if(AdDAP::hasAccess($_POST["nom_utilisateur"],$_POST["pass"]) )// l'objet DBM fait appel a la fonction connexionDB qui se trouve dans sa class
		{
			$user->connect();
			
			include("view/principale.php");
		}
		else
		{
			echo("<p class='error' style='color:red;'>Vous n'avez pas les droits pour travailler sur les templates.</p>");
			include("view/accueil.php");
		}
	}
	else
	{	
		echo("<p class='error'>Votre nom d 'utilisateur et/ou votre mot de passe est erroné.</p>");
		include("view/accueil.php");
	}
	
	
	
	
	
?>
