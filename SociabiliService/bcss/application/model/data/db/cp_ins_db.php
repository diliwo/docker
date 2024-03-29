<?php

require_once realpath(dirname(__FILE__)) . '/base_db.php';

class CpInsDb extends BaseDb
{
	public function getNomFromId($id)
	{
		$sql = "SELECT NOM FROM BCSS_CP_INS WHERE ID = :id";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();
				
			$res = $sth->fetchAll();
	
			if (count($res) == 1) {
				return $res[0]['NOM'];
		
			} else {
				return '';
		
			}
				
		} catch (Exception $e) {
			return '';
				
		}
	}
	public function getNomFromCp($cp)
	{
		$sql = "SELECT NOM FROM BCSS_CP_INS WHERE CP = :cp";
	
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':cp', $cp, PDO::PARAM_INT);
			$sth->execute();
	
			$res = $sth->fetchAll();
	
			if (count($res) == 1) {
				return $res[0]['NOM'];
	
			} else {
				return '';
	
			}
	
		} catch (Exception $e) {
			return '';
	
		}
	}
	public function getNomFromIns($ins)
	{
		$sql = "SELECT NOM FROM BCSS_CP_INS WHERE INS = :ins";
	
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(':ins', $ins, PDO::PARAM_INT);
			$sth->execute();

			$res = $sth->fetchAll();
	
			if (count($res) == 1) {
				return $res[0]['NOM'];
	
			} else {
				return '';
	
			}
	
		} catch (Exception $e) {
			return '';
	
		}
	}
}