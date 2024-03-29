<?php

require_once dirname(__FILE__) . '/../lib/adLdap/4.0.4r2/adLDAP.php';

class ActiveDirectory
{
	private $adLDAP;
	private $estConnecte;
	private $erreur;

	public function __construct($hostname, $baseDn, $accountSuffix, $login, $password)
	{
		try {
			// Création de l'objet adLDAP (depuis la libraire adLDAP)
			$this->adLDAP = new adLDAP(array('domain_controllers' => array($hostname), 'base_dn' => $baseDn, 'account_suffix' => $accountSuffix));

			// Connexion à l'AD
			if ($this->adLDAP->user()->authenticate($login, $password)) {
				$this->estConnecte = true;
				$this->erreur = "";

			} else {
				$this->estConnecte = false;
				$this->erreur = "Impossible de s'authentifier sur l'AD";

			}

		} catch (adLDAPException $e) {
			$this->adLDAP = null;
			$this->estConnecte = false;
			$this->erreur = "Erreur : " . $e->getMessage();

		}
	}
	public function authentification($login, $password, $encryption=false)
	{
		if ($encryption)
			$password = self::decryptage($password);

		return $this->adLDAP->user()->authenticate($login, $password);
	}
	public function getGroupesParSamaccountname($samaccountname)
	{
		// Initialisation des variables
		$groupes = array();

		if ($this->estConnecte) {
			// On test avec le login après WINDOWS 2000 (@cpas.intra)
			$userinfo = $this->adLDAP->user()->infoCollection($samaccountname . $this->adLDAP->getAccountSuffix(), array('*'));
			if ($userinfo != false) {
				$groupes = $userinfo->memberOf;

			} else {
				// On test avec le login avant WINDOWS 2000
				$userinfo = $this->adLDAP->user()->infoCollection($user['samaccountname'], array('*'));
				if ($userinfo != false) {
					$groupes = $userinfo->memberOf;

				}

			}

		} else {
			return null;
		}

		return $groupes;
	}
	public function getGroupesParNom($nom)
	{
		// Initialisation des variables
		$groupes = array();

		if ($this->estConnecte) {
			// Recherche des samaccountnames par le nom = cn
			$samaccountnames = $this->adLDAP->user()->find(false, "cn", $nom, true);
			if (count($samaccountnames) > 0) {
				foreach ($samaccountnames as $samaccountname) {
					$groupes = array_merge($groupes, $this->getGroupesParSamaccountname($samaccountname));

				}
				$groupes = array_unique($groupes);

			}

		} else {
			return null;
		}

		return $groupes;
	}
	public function getGroupesParMachine($machine)
	{
		// Initialisation des variables
		$groupes = array();

		if ($this->estConnecte) {
			$groupes = $this->adLDAP->computer()->groups($machine, true);

		} else {
			return null;
		}

		return $groupes;
	}
	public function getMembresParGroupe($groupe)
	{
		// Initialisation des variables
		$membres = array();

		if ($this->estConnecte) {
			$membres = $this->adLDAP->group()->members($groupe);

		} else {
			return null;
		}

		return $membres;
	}
	public function getEmailParSamaccountname($samaccountname)
	{
		$email = '';

		if ($this->estConnecte) {
			// On test avec le login après WINDOWS 2000 (@cpas.intra)
			$userinfo = $this->adLDAP->user()->infoCollection($samaccountname . $this->adLDAP->getAccountSuffix(), array('*'));
			if ($userinfo != false) {
				$email = $userinfo->mail;

			} else {
				// On test avec le login avant WINDOWS 2000
				$userinfo = $this->adLDAP->user()->infoCollection($user['samaccountname'], array('*'));
				if ($userinfo != false) {
					$email = $userinfo->mail;

				}

			}

		} else {
			return null;
		}

		return $email;
	}


	public static function cryptage($data)
	{
		$key = "cpaschar";
		$data = serialize($data);
		$td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$data = base64_encode(mcrypt_generic($td, '!'.$data));
		mcrypt_generic_deinit($td);
		return $data;
	}

	private static function decryptage($data)
	{
		$key = "cpaschar";
		$td = mcrypt_module_open(MCRYPT_DES, "", MCRYPT_MODE_ECB, "");
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$data = mdecrypt_generic($td, base64_decode($data));
		mcrypt_generic_deinit($td);

		if (substr($data, 0, 1) != '!')
			return false;

		$data = substr($data, 1, strlen($data)-1);
		return unserialize($data);
	}
}
