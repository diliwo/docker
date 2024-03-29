<?php

if ($_SESSION['is_connected_'.$applicationName])
{
	require_once 'model/groupe.php';
	
	$erreur = '';
	$action = null;
	if (isset($_GET['action']))
	{
		$action = $_GET['action'];
	}
	
	// Connexion à la DB
	$connexion = oci_connect($login, $password, $tn, 'AL32UTF8');
	
    switch($action)
    {	
		case 'lister':
			// Récupérations des groupes
			$groupes = Groupe::getFromDatabase($connexion);
			
			// Passage à la vue
			include_once 'view/groupes/lister.php';
			
			break;
			
		case 'ajouter':
    		if ((isset($_POST['ajouter-groupe'])) && (!empty($_POST['ajouter-groupe'])))
			{
				$validation = "";
				$erreur = "";
				
				$groupe = new Groupe($connexion, $_POST['nom'], $_POST['niveau'], $_POST['systeme']);
				if ($groupe->ajouter() == true)
				{
					$validation = "Le groupe a été ajouté avec succès";
				}
				else
				{
					$validation = "Impossible d'ajouter le groupe";
				}
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."groupes/lister"); 
			}
			else
			{
				include_once 'view/groupes/ajouter.php';
			}
			
			break;
			
		case 'supprimer':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$oldGroupe = new Groupe($connexion);
				$oldGroupe->setFromDatabase($_GET['id']);
				
				if ($oldGroupe->supprimer() == true)
				{
					$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion, "ID_SERVICE=".$_GET['id']);
					foreach ($slgs as $slg)
					{
						if ($slg->supprimer() == true)
						{
							$nbMembres = $slg->supprimerMembres();
							$erreur = "";
							$validation = "Le groupe a été supprimé avec succès";
						}
						else
						{
							$erreur = "Impossible de supprimer le groupe";
							$validation = "";
						}
					}
				}
				else
				{
					$erreur = "Impossible de supprimer le groupe";
					$validation = "";
				}
			}
			else
			{
				$erreur = "Aucun groupe sélectionné";
				$validation = "";
			}
			
			include_once 'view/message.php';
			header("Refresh: 1; url=".$baseUrl."groupes/lister"); 
			
			break;
			
		case 'modifier':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$groupe = new Groupe($connexion);
				$groupe->setFromDatabase($_GET['id']);
				
	    		if ((isset($_POST['modifier-groupe'])) && (!empty($_POST['modifier-groupe'])))
				{
					$validation = "";
					$erreur = "";
					
					$groupe->setNom($_POST['nom']);
					$groupe->setNiveau($_POST['niveau']);
					$groupe->setSysteme($_POST['systeme']);
					if ($groupe->modifier() == true)
					{
						$validation = "Le groupe a été modifié avec succès";
						$erreur = "";
					}
					else
					{
						$validation = "";
						$erreur = "Impossible de modifier le groupe";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."groupes/lister"); 
				}
				else
				{
					include_once 'view/groupes/modifier.php';
				}
			}
			else 
			{
				$erreur = "Aucun groupe sélectionné";
				$validation = "";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."groupes/lister"); 
			}
			
			break;
			
		default:
			header("Location: ".$baseUrl."groupes/lister");
			
			break;
    }
}
else
{
    header('Location: '.$baseUrl);
}
