<?php

// On teste les données du formulaire de connexion
if (isset($_GET['samaccountname']) && isset($_GET['password'])) {
	if ($_GET['samaccountname'] != "") {
		if ($_GET['password'] != "") {
			// Test de connexion
			try
			{
				// Connexion à l'AD (password normal ou hexa)
				if (
					($adldap->user()->authenticate($_GET['samaccountname'], $_GET['password'])) ||
					($adldap->user()->authenticate($_GET['samaccountname'], hex2String($_GET["password"])))
				) {
					$groups = array();
					$username = $_GET['samaccountname'];

					// On test avec le login après WINDOWS 2000 (@cpas.intra)
					$userinfo = $adldap->user()->infoCollection($_GET['samaccountname'].$adldap->getAccountSuffix(), array('*'));
					if ($userinfo != false) {
						$groups = $userinfo->memberOf;
						$username = $userinfo->samaccountName;

					} else {
						// On test avec le login avant WINDOWS 2000
						$userinfo = $adldap->user()->infoCollection($_GET['samaccountname'], array('*'));
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
					$_SESSION[$_config['application_name']]['from_ssc'] = true;
					$_SESSION[$_config['application_name']]['droits'] = array(
						't25'			=> true,
						'fluxs_base' 	=> true,
						'taxi_as' 		=> false,
						'soctar' 		=> true
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
					if (isset($_GET['rn']) && (!empty($_GET['rn']))) {
						header('Location: index.php?env=member&page=person&action=display&rn=' . $_GET['rn']);

					} else {
						header('Location: index.php');
					}

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
		if ($_GET['password'] != "") {
			$error = "Veuillez encoder un nom d'utilisateur!";

		} else {
			$error = "Veuillez encoder un nom d'utilisateur et un mot de passe!";

		}
	}
} else {
	$error = "Veuillez encoder un nom d'utilisateur et un mot de passe!";

}

echo "<div><p class='error'>" . $error . "</p>";

function hex2String($hex){
	$string='';
	for ($i=0; $i < strlen($hex)-1; $i+=2)
		$string .= chr(hexdec($hex[$i].$hex[$i+1]));
	
	return $string;
}
