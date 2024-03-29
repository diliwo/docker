<?php

if ($_SESSION['is_connected_'.$applicationName])
{
	require_once 'model/service.php';
	
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
			// Récupérations des services
			$services = Service::getFromDatabase($connexion);
			
			// Passage à la vue
			include_once 'view/services/lister.php';
			
			break;
			
		case 'ajouter':
			if ((isset($_POST['ajouter-service'])) && (!empty($_POST['ajouter-service'])))
			{
				$newService = new Service($connexion, $_POST['nom']);
				
				if ($newService->ajouter() == true)
				{
					$erreur = "";
					$validation = "Le service a été ajouté avec succès";
				}
				else
				{
					$erreur = "Impossible d'ajouter le service";
					$validation = "";
				}
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services/lister"); 
			}
			else
			{
				include_once 'view/services/ajouter.php';
			}
			
			break;
			
		case 'supprimer':
			$oldService = new Service($connexion);
			$oldService->setFromDatabase($_GET['id']);
			
			if ($oldService->supprimer() == true)
			{
				require_once 'model/service_localisation_groupe.php';
				
				$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion, "ID_SERVICE=".$_GET['id']);
				foreach ($slgs as $slg)
				{
					if ($slg->supprimer() == true)
					{
						$nbMembres = $slg->supprimerMembres();
						$erreur = "";
						$validation = "Le service a été supprimé avec succès";
					}
					else
					{
						$erreur = "Impossible de supprimer le service";
						$validation = "";
					}
				}
			}
			else
			{
				$erreur = "Impossible de supprimer le service";
				$validation = "";
			}
			
			include_once 'view/message.php';
			header("Refresh: 1; url=".$baseUrl."services/lister"); 
			
			break;
			
		case 'modifier':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$service = new Service($connexion);
				$service->setFromDatabase($_GET['id']);
				
	    		if ((isset($_POST['modifier-service'])) && (!empty($_POST['modifier-service'])))
				{
					$validation = "";
					$erreur = "";
					
					$service->setNom($_POST['nom']);
					if ($service->modifier() == true)
					{
						$validation = "Le service a été modifié avec succès";
					}
					else
					{
						$validation = "Impossible de modifier le service";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services/lister"); 
				}
				else
				{
					include_once 'view/services/modifier.php';
				}
			}
			else 
			{
				$erreur = "Aucun service sélectionné";
				$validation = "";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services/lister"); 
			}
			
			break;
			
		default:
			header("Location: ".$baseUrl."services/lister");
			
			break;
    }
}
else
{
    header('Location: '.$baseUrl);
}
