<?php

// Récupération de l'action
$erreur = '';
$action = null;
if (isset($_GET['action']))
{
	$action = $_GET['action'];
}

// Redirection en fonction de l'action demandée
switch($action)
{
	default:
		if($_SESSION['is_connected_'.$applicationName] == true)
		{
			header('Location: '.$baseUrl.'utilisateurs');	
		}
		else
		{
			header('Location: '.$baseUrl.'authentification/connexion');
		}
		
		break;
	
}