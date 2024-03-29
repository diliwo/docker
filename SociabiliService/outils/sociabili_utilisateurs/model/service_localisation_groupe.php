<?php

require_once 'model/service.php';
require_once 'model/localisation.php';
require_once 'model/groupe.php';
require_once 'model/utilisateur.php';

class ServiceLocalisationGroupe
{
	//
	// ATTRIBUTS
	//
	private $connexion;
	private $id = 0;
	private $idService;
	private $idLocalisation;
	private $idGroupe;
	private $idMembres;
	
	/**
	 * 
	 * Constructeur de la classe
	 * 
	 * @param oci_connection $connexion
	 * @param string $nom
	 */
	public function __construct($connexion, $idService="", $idLocalisation="", $idGroupe="", $idMembres=array())
	{
		$this->connexion = $connexion;
		$this->idService = $idService;
		$this->idLocalisation = $idLocalisation;
		$this->idGroupe = $idGroupe;
		
		$this->idMembres = $idMembres;
	}
	
	//
	// GETTERS
	//
	public function getId()
	{
		return $this->id;
	}
	public function getIdService()
	{
		return $this->idService;
	}
	public function getService()
	{
		$service = new Service($this->connexion);
		$service->setFromDatabase($this->idService);
		return $service;
	}
	public function getIdLocalisation()
	{
		return $this->idLocalisation;
	}
	public function getLocalisation()
	{
		$localisation = new Localisation($this->connexion);
		$localisation->setFromDatabase($this->idLocalisation);
		return $localisation;
	}
	public function getIdGroupe()
	{
		return $this->idGroupe;
	}
	public function getGroupe()
	{
		$groupe = new Groupe($this->connexion);
		$groupe->setFromDatabase($this->idGroupe);
		return $groupe;
	}
	public function getIdMembres()
	{
		return $this->idMembres;
	}
	public function getMembres()
	{
		$membres = array();
		
		foreach ($this->idMembres as $idMembre)
		{
			$membre = new Utilisateur($this->connexion);
			$membre->setFromDatabase($idMembre);
			$membres[] = $membre;
			
			unset($membre);
		}
		
		return $membres;
	}
	
	//
	// SETTERS
	//
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setIdService($idService)
	{
		$this->idService = $idService;
	}
	public function setIdLocalisation($idLocalisation)
	{
		$this->idLocalisation = $idLocalisation;
	}
	public function setIdGroupe($idGroupe)
	{
		$this->idGroupe = $idGroupe;
	}
	public function setIdMembres($idMembres)
	{
		$this->idMembres = $idMembres;
	}
	public function setMembres($membres)
	{
		foreach ($membres as $membre)
		{
			$this->idMembres[] = $membre->getId();
		}
	}
	/**
	 * 
	 * Initialise les attributs depuis les données de la base de données
	 * 
	 * @param integer $id
	 */
	public function setFromDatabase($id)
	{
		$this->id = $id;
		
		$sql = "SELECT * FROM SSC_LIAISON_LOC_GROUP_SERV WHERE ID_LIAISON_LOC_GROUP_SERV=:id_liaison_loc_group_serv AND ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid, ':id_liaison_loc_group_serv', $this->id);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows == 1)
			{
				$this->idService = $res[0]['ID_SERVICE'];
				$this->idLocalisation = $res[0]['ID_LOCALISATION'];
				$this->idGroupe = $res[0]['ID_GROUPE'];
				
				// Recherche des idMembres
				$sql2 = "SELECT SSC_UTILISATEURS.ID_UTILISATEUR 
						FROM SSC_UTILISATEURS
						INNER JOIN SSC_LIAISON_UTILISAT_DROITS 
							ON SSC_LIAISON_UTILISAT_DROITS.ID_UTILISATEUR = SSC_UTILISATEURS.ID_UTILISATEUR
						INNER JOIN SSC_LIAISON_LOC_GROUP_SERV 
							ON SSC_LIAISON_LOC_GROUP_SERV.ID_LIAISON_LOC_GROUP_SERV = SSC_LIAISON_UTILISAT_DROITS.ID_LIAISON_LOC_GROUP_SERV
						WHERE (SSC_UTILISATEURS.SOFTDELETE IS NULL OR SSC_UTILISATEURS.SOFTDELETE = 0)
						AND SSC_LIAISON_UTILISAT_DROITS.ID_LIAISON_LOC_GROUP_SERV = :id_liaison_loc_group_serv";
				$stid2 = oci_parse($this->connexion, $sql2);
				oci_bind_by_name($stid2, ':id_liaison_loc_group_serv', $this->id);
				
				if (oci_execute($stid2))
				{
					$nrows2 = oci_fetch_all($stid2, $res2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
					
					foreach ($res2 as $rec)
					{
						$this->idMembres[] = $rec['ID_UTILISATEUR'];
					}
				}
				
				oci_free_statement($stid2);
			}
		}
	}
	
	// 
	// GESTION BDD 
	//
	/**
	 * 
	 * Ajoute le groupe dans la base de données
	 * 
	 */
	public function ajouter()
	{
		if ($this->id == 0)
		{
			$sql = "INSERT INTO SSC_LIAISON_LOC_GROUP_SERV(ID_SERVICE, ID_LOCALISATION, ID_GROUPE) VALUES(:id_service, :id_localisation, :id_groupe)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_service', $this->idService);
			oci_bind_by_name($stid, ':id_localisation', $this->idLocalisation);
			oci_bind_by_name($stid, ':id_groupe', $this->idGroupe);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					$sql2 = "SELECT SSC_LIAISON_LOC_GROUP_SERV_SEQ.CURRVAL FROM DUAL";
					$stid2 = oci_parse($this->connexion, $sql2);
					oci_define_by_name($stid2, 'CURRVAL', $this->id);
					
					if (oci_execute($stid2))
					{
						oci_fetch($stid2);
						
						$sql3 = "INSERT INTO SSC_LIAISON_FENETRE(ID_LIAISON_LOC_GROUP_SERV, ID_DROIT_FENETRE) VALUES(:id_slg, '72')";
						$stid3 = oci_parse($this->connexion, $sql3);
						oci_bind_by_name($stid3, ':id_slg', $this->id);
						
						if (oci_execute($stid3))
						{
							// Libération des stids
							oci_free_statement($stid);
							oci_free_statement($stid2);
							oci_free_statement($stid3);
							return true;
						}
						else 
						{
							// Libération des stids
							oci_free_statement($stid);
							oci_free_statement($stid2);
							oci_free_statement($stid3);
							return -1;
						}
					}
					else
					{
						// Libération des stids
						oci_free_statement($stid);
						oci_free_statement($stid2);
						return -1;
					}
				}
				else 
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Supprime le groupe dans la base de données
	 * 
	 */
	public function supprimer()
	{
		if ($this->id > 0)
		{
			//$sql = "UPDATE SSC_LIAISON_LOC_GROUP_SERV SET SOFTDELETE = 1 WHERE ID_LIAISON_LOC_GROUP_SERV=:id";
			$sql = "DELETE FROM SSC_LIAISON_LOC_GROUP_SERV WHERE ID_LIAISON_LOC_GROUP_SERV=:id";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id', $this->id);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else 
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Modifie le groupe dans la base données
	 * 
	 */
	public function modifier()
	{
		if ($this->id > 0)
		{
			$sql = "UPDATE SSC_LIAISON_LOC_GROUP_SERV SET ID_SERVICE = :id_service, ID_LOCALISATION = :id_localisation, ID_GROUPE = :id_groupe WHERE ID_LIAISON_LOC_GROUP_SERV=:id";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id', $this->id);
			oci_bind_by_name($stid, ':id_service', $this->idService);
			oci_bind_by_name($stid, ':id_localisation', $this->idLocalisation);
			oci_bind_by_name($stid, ':id_groupe', $this->idGroupe);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else 
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Vérifie si l'utilisateur est membre de cet SLG
	 * @param integer $idMembre
	 */
	public function estMembre($idMembre)
	{
		if (($this->id > 0) && ($idMembre > 0))
		{
			$sql = "SELECT * FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_UTILISATEUR=:id_membre AND ID_LIAISON_LOC_GROUP_SERV=:id_slg";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_slg', $this->id);
			oci_bind_by_name($stid, ':id_membre', $idMembre);
			
			if (oci_execute($stid))
			{
				oci_fetch($stid);
				
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else 
		{
			return -1;
		}
	}
	/**
	 * 
	 * Permet d'ajouter un utilisateur dans cet SLG
	 * @param integer $idMembre
	 */
	public function ajouterMembre($idMembre)
	{
		if (($this->id > 0) && ($idMembre > 0))
		{
			$sql = "INSERT INTO SSC_LIAISON_UTILISAT_DROITS(ID_UTILISATEUR, ID_LIAISON_LOC_GROUP_SERV) VALUES(:id_membre, :id_slg)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_slg', $this->id);
			oci_bind_by_name($stid, ':id_membre', $idMembre);
				
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Enlève l'utilisateur de cet SLG
	 * @param integer $idMembre
	 */
	public function supprimerMembre($idMembre)
	{
		if (($this->id > 0) && ($idMembre > 0))
		{
			$sql = "DELETE FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_UTILISATEUR = :id_membre AND ID_LIAISON_LOC_GROUP_SERV = :id_slg";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_slg', $this->id);
			oci_bind_by_name($stid, ':id_membre', $idMembre);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Enlève TOUS les utilisateurs de cet SLG
	 */
	public function supprimerMembres()
	{
		if ($this->id > 0)
		{
			$sql = "DELETE FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_LIAISON_LOC_GROUP_SERV = :id_slg";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_slg', $this->id);
			
			if (oci_execute($stid))
			{
				$nbMembres = oci_num_rows($stid);
				
				// Libération des stids
				oci_free_statement($stid);
				return $nbMembres;
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else
		{
			return -1;
		}
	}
	/**
	 * 
	 * Vérifie si cet SLG a les droits 72 sur la fenêtre
	 */
	public function aLesDroitsFenetre()
	{
		if ($this->id > 0)
		{
			$sql = "SELECT * FROM SSC_LIAISON_FENETRE WHERE ID_LIAISON_LOC_GROUP_SERV=:id_slg AND ID_DROIT_FENETRE=72";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_slg', $this->id);
			
			if (oci_execute($stid))
			{
				oci_fetch($stid);
				
				if (oci_num_rows($stid) == 1)
				{
					// Libération des stids
					oci_free_statement($stid);
					return true;
				}
				else
				{
					// Libération des stids
					oci_free_statement($stid);
					return false;
				}
			}
			else
			{
				// Libération des stids
				oci_free_statement($stid);
				return -1;
			}
		}
		else 
		{
			return -1;
		}
	}
	
	//
	// FONCTIONS STATIQUES
	//
	/**
	 * 
	 * Fonction statique permettant de récupérer les groupes (array) depuis la base de données
	 * 
	 * @param oci_connection $connexion
	 */
	public static function getFromDatabase($connexion, $where="")
	{
		$objets = array();
		
		$sql = "SELECT SSC_LIAISON_LOC_GROUP_SERV.ID_LIAISON_LOC_GROUP_SERV FROM SSC_LIAISON_LOC_GROUP_SERV WHERE ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		if (!empty($where))
		{
			$sql .= " AND ".$where;
		}
		$sql .= " ORDER BY 
			(
			        SELECT SSC_SERVICE.NOM
			        FROM SSC_SERVICE
			        WHERE SSC_SERVICE.ID_SERVICE=SSC_LIAISON_LOC_GROUP_SERV.ID_SERVICE
			) ASC,
			(
			        SELECT SSC_GROUPES.NOM
			        FROM SSC_GROUPES
			        WHERE SSC_GROUPES.ID_GROUPE=SSC_LIAISON_LOC_GROUP_SERV.ID_GROUPE
			) ASC,
			(
			        SELECT SSC_GROUPES.NOM
			        FROM SSC_GROUPES
			        WHERE SSC_GROUPES.ID_GROUPE=SSC_LIAISON_LOC_GROUP_SERV.ID_GROUPE
			) ASC";
		
		$stid = oci_parse($connexion, $sql);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows > 0)
			{
				foreach ($res as $i=>$rec)
				{
					$objets[$i] = new ServiceLocalisationGroupe($connexion);
					$objets[$i]->setFromDatabase($rec['ID_LIAISON_LOC_GROUP_SERV']);
				}
			}
		}
		
		return $objets;
	}
	/**
	 * 
	 * Vérifie si le slg existe dans la base de données
	 * 
	 * @param oci_connection $connexion
	 * @param integer $id_service
	 * @param integer $id_localisation
	 * @param integer $id_groupe
	 */
	public static function existe($connexion, $id_service, $id_localisation, $id_groupe)
	{
		$sql = "SELECT ID_LIAISON_LOC_GROUP_SERV FROM SSC_LIAISON_LOC_GROUP_SERV WHERE ID_SERVICE=:id_service AND ID_LOCALISATION=:id_localisation AND ID_GROUPE=:id_groupe";
		$stid = oci_parse($connexion, $sql);
		oci_bind_by_name($stid, ':id_service', $id_service);
		oci_bind_by_name($stid, ':id_localisation', $id_localisation);
		oci_bind_by_name($stid, ':id_groupe', $id_groupe);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows == 1)
			{
				return $res[0]['ID_LIAISON_LOC_GROUP_SERV'];
			}
		}
		else
		{
			return -1;
		}
		
		return 0;
	}
}
