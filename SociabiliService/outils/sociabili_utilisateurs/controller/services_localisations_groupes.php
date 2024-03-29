<?php

if ($_SESSION['is_connected_'.$applicationName])
{
	require_once 'model/service_localisation_groupe.php';
	
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
			$slgs = ServiceLocalisationGroupe::getFromDatabase($connexion);
			
			// Passage à la vue
			include_once 'view/services_localisations_groupes/lister.php';
			
			break;
			
		case 'ajouter':
    		if ((isset($_POST['ajouter-slg'])) && (!empty($_POST['ajouter-slg'])))
			{
				$id_slg = ServiceLocalisationGroupe::existe($connexion, $_POST['id_service'], $_POST['id_localisation'], $_POST['id_groupe']);
				
				if ($id_slg == 0)
				{
					$newSLG = new ServiceLocalisationGroupe($connexion, $_POST['id_service'], $_POST['id_localisation'], $_POST['id_groupe']);
					
					if ($newSLG->ajouter() == true)
					{
						$erreur = "";
						$validation = "Le SLG a été ajouté avec succès";
					}
					else
					{
						$erreur = "Il est impossible d'ajouter un SLG";
						$validation = "";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
				}
				elseif ($id_slg == -1)
				{
					$erreur = "Il est impossible d'ajouter un SLG";
					$validation = "";
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
				}
				else
				{
					$erreur = "";
					$validation = "Le SLG existe déjà";
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
				}
				
				
			}
			else
			{
				require_once 'model/service.php';
				require_once 'model/localisation.php';
				require_once 'model/groupe.php';
				
				$services = Service::getFromDatabase($connexion);
				$localisations = Localisation::getFromDatabase($connexion);
				$groupes = Groupe::getFromDatabase($connexion);
				
				include_once 'view/services_localisations_groupes/ajouter.php';
			}
			
			break;
			
		case 'supprimer':
			$oldSLG = new ServiceLocalisationGroupe($connexion);
			$oldSLG->setFromDatabase($_GET['id']);
			
			if ($oldSLG->supprimer() == true)
			{
				$nbMembres = $oldSLG->supprimerMembres();
				$erreur = "";
				$validation = "Le SLG a été supprimé avec succès avec ses ".$nbMembres." membre(s)";
			}
			else
			{
				$erreur = "Impossible de supprimer le SLG";
				$validation = "";
			}
			
			include_once 'view/message.php';
			header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
			
			break;
			
		case 'modifier':
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$slg = new ServiceLocalisationGroupe($connexion);
				$slg->setFromDatabase($_GET['id']);
				
	    		if ((isset($_POST['modifier-slg'])) && (!empty($_POST['modifier-slg'])))
				{
					$validation = "";
					$erreur = "";
					
					$slg->setIdService($_POST['id_service']);
					$slg->setIdLocalisation($_POST['id_localisation']);
					$slg->setIdGroupe($_POST['id_groupe']);
					if ($slg->modifier() == true)
					{
						$validation = "Le SLG a été modifié avec succès";
					}
					else
					{
						$validation = "Impossible de modifier le SLG";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
				}
				else
				{
					$services = Service::getFromDatabase($connexion);
					$localisations = Localisation::getFromDatabase($connexion);
					$groupes = Groupe::getFromDatabase($connexion);
					
					include_once 'view/services_localisations_groupes/modifier.php';
				}
			}
			else 
			{
				$erreur = "Aucun SLG sélectionné";
				$validation = "";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister"); 
			}
			
			break;
			
		case 'ajouter_membre':
			
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$slg = new ServiceLocalisationGroupe($connexion);
				$slg->setFromDatabase($_GET['id']);
				
				if ((isset($_POST['ajouter_membre'])) && (!empty($_POST['ajouter_membre'])))
				{
					$nbAjouts = 0;
					if (count($_POST['id_membre']) > 0)
					{
						foreach ($_POST['id_membre'] as $idMembre)
						{
							if ($slg->estMembre($idMembre) == 0)
							{
								if ($slg->ajouterMembre($idMembre) == true)
								{
									$nbAjouts++;
								}
							}
						}
						
					}
					$nbSuppressions = 0;
					if (count($slg->getIdMembres()) > 0)
					{
						foreach ($slg->getIdMembres() as $idMembre)
						{
							if (in_array($idMembre, $_POST['id_membre']) == false)
							{
								if ($slg->supprimerMembre($idMembre) == true)
								{
									$nbSuppressions++;
								}
							}
						}
					}
					
					if (($nbAjouts > 0) || ($nbSuppressions > 0))
					{
						$validation = $nbAjouts." membre(s) (a)(ont) été ajouté(s) et ".$nbSuppressions." a(ont) été supprimé(s) au SLG <br />".$slg->getService()->getNom();
						$erreur = "";
					}
					else
					{
						$erreur = "Impossible d'ajouter le membre au SLG ";
						$validation = "";
					}
					
					include_once 'view/message.php';
					header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/membres/".$slg->getId()); 
				}
				else
				{
					$membres = Utilisateur::getFromDatabase($connexion);
					include_once 'view/services_localisations_groupes/ajouter_membre.php';
				}
			}
			else
			{
				$erreur = "Aucune liaison SLG selectionnée";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister");
			}
			
			break;
			
		case 'supprimer_membre':
			
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$ids = explode('-', $_GET['id']);
				
				$slg = new ServiceLocalisationGroupe($connexion);
				$slg->setFromDatabase($ids[1]);
				
				if ($slg->supprimerMembre($ids[0]) == true)
				{
					$erreur = "";
					$validation = "Le SLG a été supprimé avec succès pour cet utilisateur";
				}
				else
				{
					$erreur = "Impossible de supprimer le SLG de cet utilisateur";
					$validation = "";
				}
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."utilisateurs/membre_de/".$ids[0]); 
			}
    		else
			{
				$erreur = "Impossible de supprimer le SLG de cet utilisateur";
				$validation = "";
				
				include_once 'view/message.php';
				header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister");
			}
			
			break;
			
		case 'membres':
			
			if ((isset($_GET['id'])) && (!empty($_GET['id'])))
			{
				$slg = new ServiceLocalisationGroupe($connexion);
				$slg->setFromDatabase($_GET['id']);
				
				// Récupération des membres de ce SLG
				$membres = $slg->getMembres();
				
				// Passage à la vue
				include_once 'view/services_localisations_groupes/membres.php';
			}
			else
			{
				$erreur = "Aucune liaison SLG selectionnée";
				include_once 'view/message.php';
				
				header("Refresh: 1; url=".$baseUrl."services_localisations_groupes/lister");
			}
			
			break;
			
		default:
			header("Location: ".$baseUrl."services_localisations_groupes/lister");
			
			break;
    }
}
else
{
    header('Location: '.$baseUrl);
}
