<?php

require_once dirname(__FILE__) . '/active_directory.php';
class ActiveDirectoryWebservice
{
	public function authentification($login, $password)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		return $activeDirectory->authentification($login, $password);
	}
	public function getGroupesParSamaccountname($samaccountname)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		return $activeDirectory->getGroupesParSamaccountname($samaccountname);
	}
	public function getGroupesParNom($nom)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		return $activeDirectory->getGroupesParNom($nom);
	}
	public function getGroupesParMachine($machine)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la machine
		return $activeDirectory->getGroupesParMachine($machine);
	}
	public function getMembresParGroupe($groupe)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les membres du groupe
		return $activeDirectory->getMembresParGroupe($groupe);
	}
	public function getEmailParSamaccountname($samaccountname)
	{
		include_once 'includes/config/active_directory.php';
		$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

		// Récupère les groupes de la personne
		return $activeDirectory->getEmailParSamaccountname($samaccountname);
	}
}
