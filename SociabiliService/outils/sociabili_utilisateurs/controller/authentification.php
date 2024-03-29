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
	case 'connexion':
		require_once 'includes/lib/ldap.php';
		
		// Vérification de l'existence des POST d'authentification
		if ((isset($_POST['username'])) && (isset($_POST['password'])))
		{
			// Test de connexion
			$ldap = new Ldap();
			$test = $ldap->authentification($_POST['username'], $_POST['password']);
			
			if ($test['succes']==true)
			{
				// Construction de la session
				$_SESSION['is_connected_'.$applicationName] = true;
				$_SESSION['nom'] = $_POST['username'];
				$_SESSION['env'] = $_POST['env'];
				
				// Redirection vers les usagers
				header('Location: '.$baseUrl.'test');
			}
			else
			{
				switch($test['xml'])
				{
					case Ldap::CONNEXION_OBLIGATOIRE:
						$erreur = "Vous devez étre connecté pour accéder à cette page!";
						
						break;
						
					case Ldap::MAUVAIS_LOGIN_PASSWORD:
						$erreur = "Vous avez entré un mauvais nom d'utilisateur ou mauvais mot de passe";
						
						break;
						
					case Ldap::PAS_DE_DROITS:
						$erreur = "Vous n'avez pas les droits pour accéder à ce programme!";
						
						break;
						
					case Ldap::FORMULAIRE_INCOMPLET:
						$erreur = "Veuillez remplir tous les champs du formulaire de connexion";
						
						break;
						
					default:
						$erreur = "Erreur inconnue";
						
						break;
				}
				
				include_once('view/authentification/connexion.php');
			}
		}
		else
		{
			include_once('view/authentification/connexion.php');
		}
	
		break;
	
	case 'deconnexion':
		// Destruction de la session et de l'objet $connexion
		unset ($connexion);
		unset($_SESSION['is_connected_'.$applicationName]);
		unset($_SESSION['nom']);
		session_destroy();
		//Redirection
		header('Location: '.$baseUrl);
		
		break;
	
	default:
		header('Location: '.$baseUrl.'authentification/connexion');	
			
		break;
	
}