<?php

class Localisation
{
	//
	// ATTRIBUTS
	//
	private $connexion;
	private $id = 0;
	private $nom;
	
	/**
	 * 
	 * Constructeur de la classe
	 * 
	 * @param oci_connection $connexion
	 * @param string $nom
	 */
	public function __construct($connexion, $nom="")
	{
		$this->connexion = $connexion;
		$this->nom = $nom;
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
			$sql = "SELECT * FROM SSC_LOCALISATION WHERE ID_LOCALISATION=:id_localisation AND ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_localisation', $this->id);
			
			if (oci_execute($stid))
			{
				$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
				
				if ($nrows == 1)
				{
					$this->nom = $res[0]['NOM'];
					
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
			$sql = "INSERT INTO SSC_LOCALISATION(NOM) VALUES(:nom)";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':nom', $this->nom);
			
			if (oci_execute($stid))
			{
				if (oci_num_rows($stid) == 1)
				{
					$sql2 = "SELECT SSC_LOCALISATION_SEQ.CURRVAL FROM DUAL";
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
			//$sql = "UPDATE SSC_LOCALISATION SET SOFTDELETE = 1 WHERE ID_LOCALISATION=:id";
			$sql = "DELETE FROM SSC_LOCALISATION WHERE ID_LOCALISATION=:id";
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
			$sql = "UPDATE SSC_LOCALISATION SET NOM = :nom WHERE ID_LOCALISATION=:id_localisation";
			$stid = oci_parse($this->connexion, $sql);
			oci_bind_by_name($stid, ':id_localisation', $this->id);
			oci_bind_by_name($stid, ':nom', $this->nom);
			
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
		
		$sql = "SELECT ID_LOCALISATION FROM SSC_LOCALISATION WHERE ((SOFTDELETE IS NULL) OR (SOFTDELETE = 0))";
		if (!empty($where))
		{
			$sql .= " AND ".$where;
		}
		$sql .= " ORDER BY SSC_LOCALISATION.NOM ASC";
		$stid = oci_parse($connexion, $sql);
		
		if (oci_execute($stid))
		{
			$nrows = oci_fetch_all($stid, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($nrows > 0)
			{
				foreach ($res as $i=>$rec)
				{
					$objets[$i] = new Localisation($connexion);
					$objets[$i]->setFromDatabase($rec['ID_LOCALISATION']);
				}
			}
		}
		
		// Libération des stids
		oci_free_statement($stid);
		return $objets;
	}
}