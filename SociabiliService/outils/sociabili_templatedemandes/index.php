<?php 
	//session_save_path("c:/inetpub/temp/sessions");
	session_start();
	set_time_limit(60);
		
	include("view/header.php");
	include("model/autoloader.php");
	
	if(isset($_SESSION["TEMPLATE_LOGGED_IN"]) && !$_SESSION["TEMPLATE_LOGGED_IN"])
	{
		$page_demandee = "accueil";
		
		if( !empty($_GET["page"]) && $_GET["page"] != "accueil" && $_GET["page"] != "verification_mdp")
		{
			echo("<p class='error'>Vous n'avez pas accès à cette page.</p>");
		}
		
		if($_GET["page"] == "verification_mdp")
		{
			$page_demandee = $_GET["page"];
		}
	
		if(file_exists("controler/".$page_demandee.".php"))
		{
			include("controler/".$page_demandee.".php");
		}
		else
		{
			//la page n'existe pas
			include("view/error_404.php");
		}
	}
	else
	{
		$page_demandee = "principale";
		if( !empty($_GET["page"]) )
		{
			$page_demandee = $_GET["page"];
		}
		
		if(file_exists("controler/".$page_demandee.".php"))
		{
			include("controler/".$page_demandee.".php");
		}
		else
		{
			//la page n'existe pas
			include("view/error_404.php");
		}
	}
	
	
	include("view/footer.php");
?>