<?php

require_once realpath(dirname(__FILE__)) . '/base_db.php';

class InstitutionDb extends BaseDb
{
	public function getNomFromId($id)
	{
		$sql = "SELECT NOM FROM BCSS_INSTITUTIONS WHERE ID = :id";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
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