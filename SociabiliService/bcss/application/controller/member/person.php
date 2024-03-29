<?php

require_once 'application/model/personne.php';

require_once 'application/model/data/flux/manage_access_flux.php';
require_once 'application/model/data/flux/identify_person_flux.php';
require_once 'application/model/data/flux/identify_person/date_identify_person.php';
require_once 'application/model/data/flux/identify_person/adresse_identify_person.php';

$identifyPersonFlux = new IdentifyPersonFlux(
	ENV,
	$_config["flux"]["cbe_number"],
	$_config["flux"]["secteur"],
	$_config["flux"]["institution"],
	$_config["flux"]["numero_organisation"],
	$_config["flux"]["old"]["user_id"],
	$_config["flux"]["old"]["email"]
);
$manageAccesssFlux = new ManageAccessFlux(
	ENV,
	$_config["flux"]["cbe_number"],
	$_config["flux"]["secteur"],
	$_config["flux"]["institution"],
	$_config["flux"]["numero_organisation"],
	$_config["flux"]["old"]["user_id"],
	$_config["flux"]["old"]["email"]
);

// Variables diverses
$ip = $_SERVER['REMOTE_ADDR'];
$samacountname = $_SESSION[$_config['application_name']]['username'];

switch($_GET['action']) {
	case 'search':
		include_once 'application/view/' . $_GET['env'] . '/' . $_GET['page'] . '/' . $_GET['action'] . '.php';
		
		break;
		
	case 'integrate':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$today = new DateTime();
			if (isset($_POST['date_debut'])) {
				$dateDebut = $_POST['date_debut'];
				
			} else {
				$dateDebut = $today->format('d/m/Y');
				
			} 
			if (!isset($_POST['date_fin'])) {
				$dateFin = $today->modify("+1 month")->format('d/m/Y');
				
			} else {
				$dateFin = $_POST['date_fin'];
				
			}
			
			if ($identifyPersonFlux->connexion()) {
				$res = $identifyPersonFlux->getPersonneParRn( $rn );
				
				if ($res['error'] == 0) {
					// Nouvelle personne
					$personne = new Personne();
					$personne->set('rn', $res['data']->Basic->SocialSecurityUser );
					$personne->set('nom', $res['data']->Basic->LastName );
					$personne->set('prenom', $res['data']->Basic->FirstName );
					$personne->set('date_naissance', DateIdentifyPerson::format( $res['data']->Basic->BirthDate ) );
					$personne->set('adresse', AdresseIdentifyPerson::format( $res['data']->Basic->Address ) );
					if ($res['data']->Basic->Gender == 1) {
						$personne->set('sexe', "HOMME");
					} else {
						$personne->set('sexe', "FEMME");
					}

					
					if (isset($_POST['integrate_person'])) {
						// On vérifie si la personne est intégrée
						if ($manageAccesssFlux->connexion()) {
							$nomFamille = $personne->get('nom');
							$dateNaissance = $personne->get('date_naissance');
							
							$test = $manageAccesssFlux->integrer($rn, $nomFamille, $dateNaissance, $dateDebut, $dateFin);
							if ($test == true) {
								// LOG
								$logDb->integrer($ip, $samacountname, $rn, $dateDebut, $dateFin);
								// GOL
								
								header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=display&rn=' . $rn);
							} else {
								$error = "Impossible d'intégrer la personne à la BCSS";
								include_once 'application/view/message.php';

								header('Refresh: 2; url=index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=search');
							}
							
						} else {
							$error = "<b>BCSS INDISPONIBLE</b><br /><br />Il nous est impossible de récupérer les données pour l'instant, <br />veuillez réessayer ultérieurement.";
						}
						
					} else {
						include_once 'application/view/' . $_GET['env'] . '/' . $_GET['page'] . '/' . $_GET['action'] . '.php';
					}
				} else {
					$error = "<b>BCSS INDISPONIBLE</b><br /><br />Il nous est impossible de récupérer les données pour l'instant, <br />veuillez réessayer ultérieurement.";
				}
				
			} else {
				$error = "Impossible de se connecter à la BCSS";
			}
			
			include_once 'application/view/message.php';
			
		} else {
			header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=search');
		}
	
		break;
	
	case 'display':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			if ($identifyPersonFlux->connexion()) {
				$res = $identifyPersonFlux->getPersonneParRn( $rn );
				
				// Nouvelle personne
				$personne = new Personne();
				$personne->set('rn', $res['data']->Basic->SocialSecurityUser );
				$personne->set('nom', $res['data']->Basic->LastName );
				$personne->set('prenom', $res['data']->Basic->FirstName );
				$personne->set('date_naissance', DateIdentifyPerson::format( $res['data']->Basic->BirthDate ) );
				$personne->set('adresse', AdresseIdentifyPerson::format( $res['data']->Basic->Address ) );
				if ($res['data']->Basic->Gender == 1) {
					$personne->set('sexe', "HOMME");
				} else {
					$personne->set('sexe', "FEMME");
				}
				
				// On vérifie si la personne est intégrée
				if ($manageAccesssFlux->connexion()) {
					$nomFamille = $personne->get('nom');
					$dateNaissance = $personne->get('date_naissance');
					
    				$test = $manageAccesssFlux->estIntegreEnCours($rn, $nomFamille, $dateNaissance);
					if ($test == true) {
						// LOG
						$logDb->afficher($ip, $samacountname, $rn);
						// GOL
						
						include_once 'application/view/' . $_GET['env'] . '/' . $_GET['page'] . '/' . $_GET['action'] . '.php';
					} else {
						header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=integrate&rn=' . $rn);
					}
					
				} else {
					$error = "<b>BCSS INDISPONIBLE</b><br /><br />Il nous est impossible de récupérer les données pour l'instant, <br />veuillez réessayer ultérieurement.";
				}
			} else {
				$error = "<b>BCSS INDISPONIBLE</b><br /><br />Il nous est impossible de récupérer les données pour l'instant, <br />veuillez réessayer ultérieurement.";
			}
			
			include_once 'application/view/message.php';
			
		} else {
			header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=search');
		}
		
		break;
		
	default:
		header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=search');	
		
		break;
	
}
