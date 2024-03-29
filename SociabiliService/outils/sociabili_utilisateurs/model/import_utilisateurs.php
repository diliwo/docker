<?php

class ImportUtilisateurs
{
	private $connexion;
	
	public function __construct($connexion)
	{
		$this->connexion = $connexion;
	}
	
	/**
	 * 
	 * Recherche le record utilisateur correspondant au nom et prénom envoyés
	 * 
	 * @param ressource $connexion
	 * @param string $nom
	 * @param string $prenom
	 * 
	 * @return string $id_utilisateur (-1=erreur, 0=aucun et >0=ok)
	 */
	public function recherche_utilisateur($nom, $prenom)
	{
		$sql = "SELECT SSC_UTILISATEURS.ID_UTILISATEUR FROM SSC_UTILISATEURS WHERE UPPER(SSC_UTILISATEURS.NOM) LIKE UPPER(:nom) AND UPPER(SSC_UTILISATEURS.PRENOM) LIKE UPPER(:prenom)";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':nom', $nom);
		oci_bind_by_name($stid,':prenom', $prenom);
		
		// Vérification de la bonne exécution de la requête
		if (oci_execute($stid))
		{
			$nb = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			if ($nb <= 1)
			{
				// L'utilisateur n'existe pas => INSERTION DE L'UTILISATEUR
				if ($nb == 0)
				{
					$id_utilisateur = 0;
				}
				// L'utilisateur existe donc =>
				else
				{
					$id_utilisateur = $res[0]["ID_UTILISATEUR"];
				}
			}
			else
			{
				$id_utilisateur = -1;
			}
		}
		else
		{
			$id_utilisateur = -1;
		}
		oci_free_statement($stid);
		
		return $id_utilisateur;
	}
	
	/**
	 * 
	 * Recherche le record liaison SLG correspondant à l'id_utilisareur, id_service et id_groupe envoyés
	 * 
	 * @param ressource $connexion
	 * @param string $id_localisation
	 * @param string $id_service
	 * @param string $id_groupe
	 * 
	 * @return string $id_liaison_loc_group_serv (-1=erreur, 0=aucun et >0=ok)
	 */
	public function recherche_liaison_slg($id_localisation, $id_service, $id_groupe)
	{
		$sql = "SELECT SSC_LIAISON_LOC_GROUP_SERV.ID_LIAISON_LOC_GROUP_SERV FROM SSC_LIAISON_LOC_GROUP_SERV WHERE SSC_LIAISON_LOC_GROUP_SERV.ID_LOCALISATION = :id_localisation AND SSC_LIAISON_LOC_GROUP_SERV.ID_SERVICE = :id_service AND SSC_LIAISON_LOC_GROUP_SERV.ID_GROUPE = :id_groupe";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':id_localisation', $id_localisation);
		oci_bind_by_name($stid,':id_service', $id_service);
		oci_bind_by_name($stid,':id_groupe', $id_groupe);
		
		// Vérification de la bonne exécution de la requête
		if (oci_execute($stid))
		{
			$nb = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			if ($nb <= 1)
			{
				// La liaison SLG n'existe pas => On la crée
				if ($nb == 0)
				{
					$id_liaison_loc_group_serv = 0;
				}
				// La liaison SLG existe
				else
				{
					$id_liaison_loc_group_serv= $res[0]["ID_LIAISON_LOC_GROUP_SERV"];
				}
			}
			else
			{
				$id_liaison_loc_group_serv = -1;
			}
		}
		else
		{
			$id_liaison_loc_group_serv = -1;
		}
		oci_free_statement($stid);
		
		return $id_liaison_loc_group_serv;
	}
	
	/**
	 * 
	 * Recherche le record liaison utilisateur et liaison SLG correspondant à l'id_utilisareur, id_liaison_loc_group_serv envoyés
	 * 
	 * @param string $connexion
	 * @param string $id_utilisateur
	 * @param string $id_liaison_loc_group_serv
	 * 
	 * @return boolean true/false/-1
	 */
	public function recherche_liaison_utilisateur_liaison_slg($id_utilisateur, $id_liaison_loc_group_serv)
	{
		$sql = "SELECT COUNT(*) AS NB FROM SSC_LIAISON_UTILISAT_DROITS WHERE SSC_LIAISON_UTILISAT_DROITS.ID_UTILISATEUR=:id_utilisateur AND SSC_LIAISON_UTILISAT_DROITS.ID_LIAISON_LOC_GROUP_SERV=:id_liaison_loc_group_serv";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':id_utilisateur', $id_utilisateur);
		oci_bind_by_name($stid,':id_liaison_loc_group_serv', $id_liaison_loc_group_serv);
		
		// Vérification de la bonne exécution de la requête
		if (oci_execute($stid))
		{
			oci_fetch($stid);
			$nb = oci_result($stid, 'NB');
			if ($nb <= 1)
			{
				// La liaison SLG n'existe pas => On la crée
				if ($nb == 0)
				{
					$retour = 0;
				}
				// La liaison SLG existe
				else
				{
					$retour = 1;
				}
			}
			else
			{
				$$retour = -1;
			}
		}
		else
		{
			$retour = -1;
		}
		oci_free_statement($stid);
		
		return $retour;
	}
	
	/**
	 * 
	 * Ajoute le record utilisateur dans la table SSC_UTILISATEURS et renvoie l'id_utilisateur
	 * 
	 * @param ressource $connexion
	 * @param string $nom
	 * @param string $prenom
	 */
	public function ajouter_utilisateur($nom, $prenom)
	{
		$samaccountname = str_replace(" ", "", strtolower($prenom.".".$nom));
		
		// Création de l'utilisateur
		$sql = "INSERT INTO SSC_UTILISATEURS (SSC_UTILISATEURS.NOM, SSC_UTILISATEURS.PRENOM, SSC_UTILISATEURS.SAMACCOUNTNAME) VALUES (UPPER(:nom), UPPER(:prenom), :samaccountname)";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':nom', $nom);
		oci_bind_by_name($stid,':prenom', $prenom);
		oci_bind_by_name($stid,':samaccountname', $samaccountname);
		
		if (oci_execute($stid))
		{
			$sql = "SELECT SSC_UTILISATEURS_SEQ.CURRVAL FROM DUAL";
			$stid = oci_parse($connexion, $sql);
			if (oci_execute($stid))
			{
				$res = oci_fetch_assoc($stid);
				$id_utilisateur = $res['CURRVAL'];
			}
			else
			{
				$id_utilisateur = -1;
			}
		}
		else
		{
			$id_utilisateur = -1;
		}
		oci_free_statement($stid);
		
		return $id_utilisateur;
	}
	
	/**
	 * 
	 * Ajoute le record liaison slg dans la table SSC_LIAISON_LOC_GROUP_SERV et renvoie l'id_liaison_loc_group_serv
	 * 
	 * @param resource $connexion
	 * @param string $id_localisation
	 * @param string $id_service
	 * @param string $id_groupe
	 * 
	 * @return string $id_liaison_loc_group_serv
	 */
	public function ajouter_liaison_slg($id_localisation, $id_service, $id_groupe)
	{
		// Création de la liaison SLG
		$sql = "INSERT INTO SSC_LIAISON_LOC_GROUP_SERV (SSC_LIAISON_LOC_GROUP_SERV.ID_LOCALISATION, SSC_LIAISON_LOC_GROUP_SERV.ID_SERVICE, SSC_LIAISON_LOC_GROUP_SERV.ID_GROUPE) VALUES (:id_localisation, :id_service, :id_groupe)";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':id_localisation', $id_localisation);
		oci_bind_by_name($stid,':id_service', $id_service);
		oci_bind_by_name($stid,':id_groupe', $id_groupe);
		
		if (oci_execute($stid))
		{
			$sql = "SELECT SSC_LIAISON_LOC_GROUP_SERV_SEQ.CURRVAL FROM DUAL";
			$stid = oci_parse($this->connexion, $sql);
			if (oci_execute($stid))
			{
				$res = oci_fetch_assoc($stid);
				$id_liaison_loc_group_serv = $res['CURRVAL'];
				oci_free_statement($stid);
				
				// Insertion de la SLG dans la liaison fenêtre
				$sql = "INSERT INTO SSC_LIAISON_FENETRE(SSC_LIAISON_FENETRE.ID_LIAISON_LOC_GROUP_SERV, SSC_LIAISON_FENETRE.ID_DROIT_FENETRE) VALUES (:id_liaison_loc_group_serv, '72')";
				$stid = oci_parse($this->connexion, $sql);
				oci_bind_by_name($stid,':id_liaison_loc_group_serv', $id_liaison_loc_group_serv);
				oci_execute($stid);
			}
			else
			{
				$id_liaison_loc_group_serv = -1;
			}
		}
		else
		{
			$id_liaison_loc_group_serv = -1;
		}
		oci_free_statement($stid);
		
		return $id_liaison_loc_group_serv;
	}
	
	/**
	 * 
	 * Ajoute le record liaison utilisateur et liaison slg dans la table SSC_LIAISON_UTILISAT_DROITS et renvoie true ou false
	 * 
	 * @param resource $connexion
	 * @param string $id_utilisateur
	 * @param string $id_liaison_loc_group_serv
	 * 
	 * @return boolean true/false
	 */
	public function ajouter_liaison_utilisateur_liaison_slg($id_utilisateur, $id_liaison_loc_group_serv)
	{
		// Création de la liaison utilisateur et liaison SLG
		$sql = "INSERT INTO SSC_LIAISON_UTILISAT_DROITS(SSC_LIAISON_UTILISAT_DROITS.ID_UTILISATEUR, SSC_LIAISON_UTILISAT_DROITS.ID_LIAISON_LOC_GROUP_SERV) VALUES (:id_utilisateur, :id_liaison_loc_group_serv)";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid,':id_utilisateur', $id_utilisateur);
		oci_bind_by_name($stid,':id_liaison_loc_group_serv', $id_liaison_loc_group_serv);
		
		if (oci_execute($stid))
		{
			oci_free_statement($stid);
			return true;
		}
		else
		{
			oci_free_statement($stid);
			return false;
		}
	}
}