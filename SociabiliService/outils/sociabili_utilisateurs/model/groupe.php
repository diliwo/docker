<?php

class Groupe
{
	//
	// ATTRIBUTS
	//
	private $connexion;
	private $id = 0;
	private $nom;
	private $niveau;
	private $systeme;
	
	/**
	 * 
	 * Constructeur de la classe
	 * 
	 * @param oci_connection $connexion
	 * @param string $nom
	 * @param string $niveau
	 * @param string $systeme
	 */
	public function __construct($connexion, $nom="", $niveau="", $systeme="")
	{
		$this->connexion = $connexion;
		$this->nom = $nom;
		$this->niveau = $niveau;
		$this->systeme = $systeme;
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
	public function getNiveau()
	{
		return $this->niveau;
	}
	public function getSysteme()
	{
		return $this->systeme;
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
		return $this->nom = $nom;
	}
	public function setNiveau($niveau)
	{
		$this->niveau = $niveau;
	}
	public function setSysteme($systeme)
	{
		$this->systeme = $systeme;
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
		
		if ($this->id > 0)
		{
			$sql = "SELECT * FROM SSC_GROUPES WHERE ID_GROUPE=:id_groupe AND ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_groupe', $this->id);
			
			if (oci_execute($stid))
			{
				$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
				
				if ($nrows == 1)
				{
					$this->nom = $res[0]['NOM'];
					$this->niveau = $res[0]['NIVEAU'];
					$this->systeme = $res[0]['SYSTEME'];
					
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
			$sql = "INSERT INTO SSC_GROUPES(NOM, NIVEAU, SYSTEME) VALUES(:nom, :niveau, :systeme)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':nom', $this->nom);
			oci_bind_by_name($stid, ':niveau', $this->niveau);
			oci_bind_by_name($stid, ':systeme', $this->systeme);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					$sql2 = "SELECT SSC_GROUPES_SEQ.CURRVAL FROM DUAL";
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
	 * Supprime le groupe dans la base de données
	 * 
	 */
	public function supprimer()
	{
		if ($this->id > 0)
		{
			//$sql = "UPDATE SSC_GROUPES SET SOFTDELETE = 1 WHERE ID_GROUPE=:id_groupe";
			$sql = "DELETE FROM SSC_GROUPES WHERE ID_GROUPE=:id_groupe";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_groupe', $this->id);
			
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
			$sql = "UPDATE SSC_GROUPES SET NOM = :nom, NIVEAU = :niveau, SYSTEME = :systeme WHERE ID_GROUPE=:id_groupe";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_groupe', $this->id);
			oci_bind_by_name($stid, ':nom', $this->nom);
			oci_bind_by_name($stid, ':niveau', $this->niveau);
			oci_bind_by_name($stid, ':systeme', $this->systeme);
			
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
	
	//
	// FONCTIONS STATIQUES
	//
	/**
	 * 
	 * Fonction statique permettant de récupérer les groupes (array) depuis la base de données
	 * 
	 * @param oci_connection $connexion
	 */
	public static function getFromDatabase($connexion)
	{
		$objets = array();
		
		$sql = "SELECT ID_GROUPE FROM SSC_GROUPES WHERE ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		if (!empty($where))
		{
			$sql .= " AND ".$where;
		}
		$sql .= " ORDER BY SSC_GROUPES.NOM ASC";
		$stid = oci_parse($connexion, $sql);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows > 0)
			{
				foreach ($res as $i=>$rec)
				{
					$objets[$i] = new Groupe($connexion);
					$objets[$i]->setFromDatabase($rec['ID_GROUPE']);
				}
			}
		}
		
		// Libération des stids
		oci_free_statement($stid);
		return $objets;
	}
}