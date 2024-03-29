<?php

require_once dirname(__FILE__) . '/active_directory.php';
class ActiveDirectoryXmlWebservice
{
	public function authentification($login, $password)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		if ($activeDirectory->authentification($login, $password)) {
			return "<SUCCES>1</SUCCES>";

		} else {
			return "<SUCCES>0</SUCCES>";

		}
	}
	public function getGroupesParSamaccountname($samaccountname)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		$groupes = $activeDirectory->getGroupesParSamaccountname($samaccountname);

		// Génération du retour
		$retour = "<SUCCES>0</SUCCES>";
		if (!is_null($groupes)) {
			$retour = "<SUCCES>1</SUCCES>";
			if (count($groupes) > 0) {
				$retour .= "<GROUPES>";
				foreach ($groupes as $id=>$groupe) {
					$retour .= "<GROUPE>" . $groupe . "</GROUPE>";
				}
				$retour .= "</GROUPES>";
			}
		}

		return $retour;
	}
	public function getGroupesParNom($nom)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		$groupes = $activeDirectory->getGroupesParNom($nom);

		// Génération du retour
		$retour = "<SUCCES>0</SUCCES>";
		if (!is_null($groupes)) {
			$retour = "<SUCCES>1</SUCCES>";
			if (count($groupes) > 0) {
				$retour .= "<GROUPES>";
				foreach ($groupes as $id=>$groupe) {
					$retour .= "<GROUPE>" . $groupe . "</GROUPE>";
				}
				$retour .= "</GROUPES>";
			}
		}

		return $retour;
	}
	public function getGroupesParMachine($machine)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la machine
		$groupes = $activeDirectory->getGroupesParMachine($machine);

		// Génération du retour
		$retour = "<SUCCES>0</SUCCES>";
		if (!is_null($groupes)) {
			$retour = "<SUCCES>1</SUCCES>";
			if (count($groupes) > 0) {
				$retour .= "<GROUPES>";
				foreach ($groupes as $id=>$groupe) {
					$retour .= "<GROUPE>" . $groupe . "</GROUPE>";
				}
				$retour .= "</GROUPES>";
			}
		}

		return $retour;
	}
	public function getMembresParGroupe($groupe)
	{
		// Récupère les membres du groupe
		$membres = $activeDirectory->getMembresParGroupe($groupe);

		// Génération du retour
		$retour = "<SUCCES>0</SUCCES>";
		if (!is_null($membres)) {
			$retour = "<SUCCES>1</SUCCES>";
			if (count($membres) > 0) {
				$retour .= "<MEMBRES>";
				foreach ($membres as $id=>$membre) {
					$retour .= "<MEMBRE>" . $membre . "</MEMBRE>";
				}
				$retour .= "</MEMBRES>";
			}
		}

		return $retour;
	}
	public function getEmailParSamaccountname($samaccountname)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		$email = $activeDirectory->getEmailParSamaccountname($samaccountname);

		// Génération du retour
		$retour = "<SUCCES>0</SUCCES>";
		if (!empty($email)) {
			$retour = "<SUCCES>1</SUCCES>";
			$retour .= "<EMAIL>" . $email . "</EMAIL>";
		}

		return $retour;
	}
}
