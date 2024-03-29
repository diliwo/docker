<?php

if ($_SESSION['is_connected_'.$applicationName])
{
	require_once 'model/localisation.php';
	
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
			// Récupérations des localisations
			$localisations = Localisation::getFromDatabase($connexion);
			
			// Passage à la vue
			include_once 'view/localisations/lister.php';
			
			break;
			
		case 'ajouter':
    		if ((isset($_POST['ajouter-localisation'])) && (!empty($_POST['ajouter-localisation'])))
			{
				$newLocalisation = new Localisation($connexion, $_POST['nom']);
				
				if ($newLocalisation->ajouter() == true)
				{
					$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion, "ID_LOCALISATION=".$_GET['id']);
					foreach ($slgs as $slg)
					{
						if ($slg->supprimer() == true)
						{
							$nbMembres = $slg->supprimerMembres();
							$erreur = "";
							$validation = "La localisation a été supprimé avec succès";
						}
						else
						{
							$erreur = "Impossible de supprimer la localisation";
							$validation = "";
						}
					}
				}
				else
				{
					$erreur = "Impossible d'ajouter la localisation";
					$validation = "";
				}
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."localisations/lister"); 
			}
			else
			{
				include_once 'view/localisations/ajouter.php';
			}
			
			break;
			
		case 'supprimer':
			$oldLocalisation = new Localisation($connexion);
			$oldLocalisation->setFromDatabase($_GET['id']);
			
			if ($oldLocalisation->supprimer() == true)
			{
				$erreur = "";
				$validation = "La localisation a été supprimée avec succès";
			}
			else
			{
				$erreur = "Impossible de supprimer la localisation";
				$validation = "";
			}
			
			include_once 'view/message.php';
			header("Refresh: 1; url=".$baseUrl."localisations/lister"); 
			
			break;
			
		case 'modifier':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$localisation = new Localisation($connexion);
				$localisation->setFromDatabase($_GET['id']);
				
	    		if ((isset($_POST['modifier-localisation'])) && (!empty($_POST['modifier-localisation'])))
				{
					$validation = "";
					$erreur = "";
					
					$localisation->setNom($_POST['nom']);
					if ($localisation->modifier() == true)
					{
						$validation = "La localisation a été modifiée avec succès";
					}
					else
					{
						$validation = "Impossible de modifier la localisation";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."localisations/lister"); 
				}
				else
				{
					include_once 'view/localisations/modifier.php';
				}
			}
			else 
			{
				$erreur = "Aucune localisation sélectionnée";
				$validation = "";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."localisations/lister"); 
			}
			
			break;
			
		default:
			header("Location: ".$baseUrl."localisations/lister");
			
			break;
    }
}
else
{
    header('Location: '.$baseUrl);
}
