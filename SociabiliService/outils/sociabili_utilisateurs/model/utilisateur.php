<?php

require_once 'model/service_localisation_groupe.php';

class Utilisateur
{
	//
	// ATTRIBUTS
	//
	private $connexion;
	private $id = 0;
	private $nom;
	private $prenom;
	private $codeAs;
	private $samaccountname;
	private $idSLGs;
	
	/**
	 * 
	 * Constructeur de la classe
	 * 
	 * @param oci_connection $connexion
	 * @param string $nom
	 * @param string $prenom
	 * @param string $codeAs
	 * @param string $samaccountname
	 */
	public function __construct($connexion, $nom="", $prenom="", $codeAs="", $samaccountname="", $idSLGs=array())
	{
		$this->connexion = $connexion;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->codeAs = $codeAs;
		$this->samaccountname = $samaccountname;
		$this->idSLGs = $idSLGs;
	}
	
	//
	// GETTERS
	//
	public function getId()
	{
		return $this->id;
	}
	public function getNom()
	{
		return $this->nom;
	}
	public function getPrenom()
	{
		return $this->prenom;
	}
	public function getCodeAs()
	{
		return $this->codeAs;
	}
	public function getSamaccountname()
	{
		return $this->samaccountname;
	}
	public function getIdSLGs()
	{
		return $this->idSLGs;
	}
	public function getSLGs()
	{
		$slgs = array();
		
		foreach ($this->idSLGs as $idSLG)
		{
			$slg = new ServiceLocalisationGroupe($this->connexion);
			$slg->setFromDatabase($idSLG);
			$slgs[] = $slg;
			
			unset($slg);
		}
		
		return $slgs;
	}
	
	//
	// SETTERS
	//
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setNom($nom)
	{
		$this->nom = $nom;
	}
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
	}
	public function setCodeAs($codeAs)
	{
		$this->codeAs = $codeAs;
	}
	public function setSamaccountname($samaccountname)
	{
		$this->samaccountname = $samaccountname;
	}
	public function setIdSLGs($idSLGs)
	{
		$this->idSLGs = $idSLGs;
	}
	public function setSLGs($slgs)
	{
		foreach ($slgs as $slg)
		{
			$this->idSLGs[] = $slg->getId();
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
		
		$sql = "SELECT * FROM SSC_UTILISATEURS WHERE ID_UTILISATEUR=:id_utilisateur AND ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		$stid = oci_parse($this->connexion, $sql);
		oci_bind_by_name($stid, ':id_utilisateur', $this->id);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows == 1)
			{
				$this->nom = $res[0]['NOM'];
				$this->prenom = $res[0]['PRENOM'];
				$this->codeAs = $res[0]['CODE_AS'];
				$this->samaccountname = $res[0]['SAMACCOUNTNAME'];
				
				// Recherche des idSLGs
				$sql2 = "SELECT SSC_LIAISON_LOC_GROUP_SERV.ID_LIAISON_LOC_GROUP_SERV 
						FROM SSC_LIAISON_LOC_GROUP_SERV
						INNER JOIN SSC_LIAISON_UTILISAT_DROITS ON SSC_LIAISON_UTILISAT_DROITS.ID_LIAISON_LOC_GROUP_SERV = SSC_LIAISON_LOC_GROUP_SERV.ID_LIAISON_LOC_GROUP_SERV
						INNER JOIN SSC_UTILISATEURS ON SSC_UTILISATEURS.ID_UTILISATEUR = SSC_LIAISON_UTILISAT_DROITS.ID_UTILISATEUR
						WHERE SSC_UTILISATEURS.ID_UTILISATEUR = :id_utilisateur";
				$stid2 = oci_parse($this->connexion, $sql2);
				oci_bind_by_name($stid2, ':id_utilisateur', $this->id);
				
				if (oci_execute($stid2))
				{
					$nrows2 = oci_fetch_all($stid2, $res2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
					
					foreach ($res2 as $rec)
					{
						$this->idSLGs[] = $rec['ID_LIAISON_LOC_GROUP_SERV'];
					}
				}
				
				oci_free_statement($stid2);
			}
		}
		
		oci_free_statement($stid);
	}
	
	// 
	// GESTION BDD 
	//
	/**
	 * 
	 * Ajoute l'utilisateur dans la base de données
	 * 
	 */
	public function ajouter()
	{
		if ($this->id == 0)
		{
			$sql = "INSERT INTO SSC_UTILISATEURS(NOM, PRENOM, CODE_AS, SAMACCOUNTNAME, MENU_SIGNAL) VALUES(:nom, :prenom, :code_as, :samaccountname, 1)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':nom', $this->nom);
			oci_bind_by_name($stid, ':prenom', $this->prenom);
			oci_bind_by_name($stid, ':code_as', $this->codeAs);
			oci_bind_by_name($stid, ':samaccountname', $this->samaccountname);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					$sql2 = "SELECT SSC_UTILISATEURS_SEQ.CURRVAL FROM DUAL";
					$stid2 = oci_parse($this->connexion, $sql2);
					oci_define_by_name($stid2, 'CURRVAL', $this->id);
					
					if (oci_execute($stid2))
					{
						oci_fetch($stid2);
						
						// Libération des stids
						oci_free_statement($stid);
						oci_free_statement($stid2);
						return true;
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
	 * Supprime l'utilisateur dans la base de données
	 * 
	 */
	public function supprimer()
	{
		if ($this->id > 0)
		{
			$sql = "UPDATE SSC_UTILISATEURS SET SOFTDELETE = 1 WHERE ID_UTILISATEUR=:id_utilisateur";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			
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
	 * Modifie l'utilisateur dans la base données
	 * 
	 */
	public function modifier()
	{
		if ($this->id > 0)
		{
			$sql = "UPDATE SSC_UTILISATEURS SET NOM = :nom, PRENOM = :prenom, CODE_AS = :code_as, SAMACCOUNTNAME = :samaccountname WHERE ID_UTILISATEUR=:id_utilisateur";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			oci_bind_by_name($stid, ':nom', $this->nom);
			oci_bind_by_name($stid, ':prenom', $this->prenom);
			oci_bind_by_name($stid, ':code_as', $this->codeAs);
			oci_bind_by_name($stid, ':samaccountname', $this->samaccountname);
			
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
	public static function existe($connexion, $nom, $prenom, $samaccountname)
	{
		$sql = "SELECT ID_UTILISATEUR FROM SSC_UTILISATEURS WHERE UPPER(NOM) LIKE UPPER(:nom) AND UPPER(PRENOM) LIKE UPPER(:prenom) AND SAMACCOUNTNAME LIKE :samaccountname";
		$stid = oci_parse($connexion, $sql);
		oci_bind_by_name($stid, ':nom', $nom);
		oci_bind_by_name($stid, ':prenom', $prenom);
		oci_bind_by_name($stid, ':samaccountname', $samaccountname);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows == 1)
			{
				return $res[0]['ID_UTILISATEUR'];
			}
		}
		else
		{
			return -1;
		}
		
		return 0;
	}
	public function aPourSLG($idSLG)
	{
		if (($this->id > 0) && ($idSLG > 0))
		{
			$sql = "SELECT * FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_UTILISATEUR=:id_utilisateur AND ID_LIAISON_LOC_GROUP_SERV=:id_slg";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			oci_bind_by_name($stid, ':id_slg', $idSLG);
			
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
	public function ajouterSLG($idSLG)
	{
		if (($this->id > 0) && ($idSLG > 0))
		{
			$sql = "INSERT INTO SSC_LIAISON_UTILISAT_DROITS(ID_UTILISATEUR, ID_LIAISON_LOC_GROUP_SERV) VALUES(:id_utilisateur, :id_slg)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			oci_bind_by_name($stid, ':id_slg', $idSLG);
			
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
	public function supprimerSLG($idSLG)
	{
		if (($this->id > 0) && ($idSLG > 0))
		{
			$sql = "DELETE FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_UTILISATEUR=:id_utilisateur AND ID_LIAISON_LOC_GROUP_SERV=:id_slg";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			oci_bind_by_name($stid, ':id_slg', $idSLG);
			
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
	public function supprimerSLGs()
	{
		if ($this->id > 0)
		{
			$sql = "DELETE FROM SSC_LIAISON_UTILISAT_DROITS WHERE ID_UTILISATEUR=:id_utilisateur";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_utilisateur', $this->id);
			
			if (oci_execute($stid))
			{
				$nbSLGs = oci_num_rows($stid);
				
				// Libération des stids
				oci_free_statement($stid);
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
		
		$sql = "SELECT ID_UTILISATEUR FROM SSC_UTILISATEURS WHERE ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		if (!empty($where))
		{
			$sql .= " AND ".$where;
		}
		$sql .= " ORDER BY SSC_UTILISATEURS.NOM ASC, SSC_UTILISATEURS.PRENOM ASC";
		$stid = oci_parse($connexion, $sql);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows > 0)
			{
				foreach ($res as $i=>$rec)
				{
					$objets[$i] = new Utilisateur($connexion);
					$objets[$i]->setFromDatabase($rec['ID_UTILISATEUR']);
				}
			}
		}
		
		// Libération des stids
		oci_free_statement($stid);
		return $objets;
	}
}
