<?php

require_once realpath(dirname(__FILE__)) . '/base_db.php';

class EntrepriseDb extends BaseDb
{
	public function ajouter($immatriculation, $numero, $nom)
	{
		$sql = "INSERT INTO BCSS_ENTREPRISES (IMMATRICULATION, NUMERO, NOM) VALUES (:immatriculation, :numero, :nom)";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':immatriculation', $immatriculation, PDO::PARAM_INT);
			$sth->bindParam(':numero', $numero, PDO::PARAM_INT);
			$sth->bindParam(':nom', $nom);
			$sth->execute();
		
			if ($sth->rowCount() == 1) {
				return true;
		
			} else {
				return false;
		
			}
		
		} catch (Exception $e) {
			return NULL;
		
		}
	}
	public function getNomFromImmatriculation($immatriculation)
	{
		$sql = "SELECT NOM FROM BCSS_ENTREPRISES WHERE IMMATRICULATION = :immatriculation";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':immatriculation', $immatriculation, PDO::PARAM_INT);
			$sth->execute();

			$res = $sth->fetchAll();
				
			if (count($res) == 1) {
				return $res[0]['NOM'];
		
			} else {
				return "";
		
			}
				
		} catch (Exception $e) {
			return NULL;
				
		}
	}
	public function getNomFromNumero($numero)
	{
		$sql = "SELECT NOM FROM BCSS_ENTREPRISES WHERE NUMERO = :numero";
	
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':numero', $numero, PDO::PARAM_INT);
			$sth->execute();

			$res = $sth->fetchAll();
	
			if (count($res) == 1) {
				return $res[0]['NOM'];
	
			} else {
				return "";
	
			}
	
		} catch (Exception $e) {
			return NULL;
	
		}
	}
}