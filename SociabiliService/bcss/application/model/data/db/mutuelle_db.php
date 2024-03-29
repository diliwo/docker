<?php

require_once realpath(dirname(__FILE__)) . '/base_db.php';

class MutuelleDb extends BaseDb
{
	public function getNomFromId($id)
	{
		$sql = "SELECT NOM_MUTUELLE FROM SSC_MUTUELLE WHERE id = :id";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();

			$res = $sth->fetchAll();
				
			if (count($res) == 1) {
				return $res[0]['NOM_MUTUELLE'];
		
			} else {
				return "";
		
			}
				
		} catch (Exception $e) {
			return NULL;
				
		}
	}
	public function getNomFromNumeroSection($numeroSection)
	{
		$sql = "SELECT NOM_MUTUELLE FROM SSC_MUTUELLE WHERE NUM_SECTION_MUTUELLE = :numeroSection";
	
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':numeroSection', $numeroSection, PDO::PARAM_INT);
			$sth->execute();

			$res = $sth->fetchAll();
	
			if (count($res) == 1) {
				return $res[0]['NOM_MUTUELLE'];
	
			} else {
				return "mutuelle avec numéro de section " . $numeroSection;
	
			}
	
		} catch (Exception $e) {
			return NULL;
	
		}
	}
}