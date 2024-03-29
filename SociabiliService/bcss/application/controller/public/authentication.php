<?php

switch($_GET['action']) {
	case 'login':
		if (isset($_SESSION[$_config['application_name']]['is_member']) && ($_SESSION[$_config['application_name']]['is_member'] == true)) {
			if ((isset($_SESSION[$_config['application_name']]['url_referer'])) && ($_SESSION[$_config['application_name']]['url_referer'] != "")) {
				header('Location: ' . $_SESSION[$_config['application_name']]['url_referer']);
			} else {
				// Vérification si utilisateur est admin
				if (isset($_SESSION[$_config['application_name']]['is_admin']) && ($_SESSION[$_config['application_name']]['is_admin'] == true)) {
					header('Location: index.php?env=admin');
				} else {
					header('Location: index.php?env=member');
				}
			}

		} else {
			// On teste les données du formulaire de connexion
			if (isset($_POST['username']) && isset($_POST['password'])) {
				if ($_POST['username'] != "") {
					if ($_POST['password'] != "") {
						// Test de connexion
						try
						{
							// Connexion à l'AD
							if ($adldap->user()->authenticate($_POST['username'], $_POST['password'])) {
								$groups = array();
								$username = $_POST['username'];

								// On test avec le login après WINDOWS 2000 (@cpas.intra)
								$userinfo = $adldap->user()->infoCollection($_POST['username'].$adldap->getAccountSuffix(), array('*'));
								if ($userinfo != false) {
									$groups = $userinfo->memberOf;
									$username = $userinfo->samaccountName;

								} else {
									// On test avec le login avant WINDOWS 2000
									$userinfo = $adldap->user()->infoCollection($_POST['username'], array('*'));
									if ($userinfo != false) {
										$groups = $userinfo->memberOf;

									}

								}

								/**
								 * Initialisation des variables de SESSION
								 */
								$_SESSION[$_config['application_name']]['is_admin'] = false;
								$_SESSION[$_config['application_name']]['is_member'] = false;
								$_SESSION[$_config['application_name']]['is_admin'] = false;
								$_SESSION[$_config['application_name']]['username'] = strtolower($username);
								$_SESSION[$_config['application_name']]['droits'] = array(
									't25'			=> true,
									'fluxs_base' 	=> true,
									'taxi_as' 		=> false,
									'soctar' 		=> true,
								);
								/**
								 *  Gestion des accès
								 */
								if (in_array($_config['ldap']['groupes']['administrateurs'], $groups)) {
									$_SESSION[$_config['application_name']]['is_admin'] = true;
									$_SESSION[$_config['application_name']]['is_member'] = true;

								} elseif (in_array($_config['ldap']['groupes']['utilisateurs'], $groups)) {
									$_SESSION[$_config['application_name']]['is_admin'] = false;
									$_SESSION[$_config['application_name']]['is_member'] = true;

								}
								/**
								 *  Gestion des droits
								 */
								if (in_array($_config['ldap']['groupes']['droits']['taxi_as'], $groups)) {
									$_SESSION[$_config['application_name']]['droits']['taxi_as'] = true;
								}
								// Pour le groupe soctar, il y a un accès unique à ce flux
								if (in_array($_config['ldap']['groupes']['droits']['soctar'], $groups)) {
									foreach($_SESSION[$_config['application_name']]['droits'] as $flux => $droit)
										$_SESSION[$_config['application_name']]['droits'][$flux] = false;

									$_SESSION[$_config['application_name']]['droits']['soctar'] = true;
								}
								// Pour le groupe t25, il y a un accès unique à ce flux
								if (in_array($_config['ldap']['groupes']['droits']['t25'], $groups)) {
									foreach($_SESSION[$_config['application_name']]['droits'] as $flux => $droit)
										$_SESSION[$_config['application_name']]['droits'][$flux] = false;

									$_SESSION[$_config['application_name']]['droits']['t25'] = true;
								}

								// Redirection
								header('Location: index.php');

							} else {
								$error = "Impossible de se connecter à l'application<br />(nom d'utilisateur ou mot de passe incorrect)";
							}

						} catch (adLDAPException $e) {
							$error = 'LDAP ERROR : '.$e;

						}

					} else {
						$error = "Veuillez encoder un mot de passe!";

					}
				} else {
					if ($_POST['password'] != "") {
						$error = "Veuillez encoder un nom d'utilisateur!";

					} else {
						$error = "Veuillez encoder un nom d'utilisateur et un mot de passe!";

					}
				}
			} else {
				$error = "";

			}

			// Affichage du formulaire de connexion
			include_once 'application/view/' . $_GET['env'] . '/' . $_GET['page'] . '/' . $_GET['action'] . '.php';
		}

		break;

	case 'logout':
		// Suppression de la session
		session_destroy();

		//Redirection
		header('Location: index.php');

		break;

	default:
		header('Location: index.php?env=' . $_GET['env'] . '&page=' . $_GET['page'] . '&action=login');

		break;

}
