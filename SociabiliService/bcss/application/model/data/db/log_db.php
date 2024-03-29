<?php

require_once realpath(dirname(__FILE__)) . '/base_db.php';

class LogDb extends BaseDb
{
	public function afficher($ip, $samaccountname, $rn)
	{
		$now = new Datetime();
		$now->setTimezone(new DateTimeZone('Europe/Brussels'));
		
		// Requête SQL
		$sql =	"INSERT INTO BCSS_LOG(IP_UTILISATEUR, SAMACCOUNTNAME_UTILISATEUR, RN, DATE_HEURE, ACTION) VALUES(:ip_utilisateur, :samaccountname_utilisateur, :rn, :date_heure, :action)";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(":ip_utilisateur", $ip);
			$sth->bindParam(":samaccountname_utilisateur", $samaccountname);
			$sth->bindParam(":rn", $rn);
			$temp = $now->format("Y-m-d H:i:s");
			$sth->bindParam(":date_heure", $temp);
			$action = "AFFICHER";
			$sth->bindParam(":action", $action);
			
		} catch (Exception $e) {
			return NULL;
		
		}
		
		// Libération de $now
		unset($now);
		
		// On exécute la requête
		return $sth->execute();
	}
	
	public function integrer($ip, $samaccountname, $rn, $date_debut, $date_fin)
	{
		$now = new Datetime();
		$now->setTimezone(new DateTimeZone('Europe/Brussels'));
		
		// Requête SQL
		$sql =	"INSERT INTO BCSS_LOG(IP_UTILISATEUR, SAMACCOUNTNAME_UTILISATEUR, RN, DATE_HEURE, ACTION) VALUES(:ip_utilisateur, :samaccountname_utilisateur, :rn, :date_heure, :action)";
		
		// Exécution de la requête
		try {
			$sth = $this->db->prepare($sql);
			$sth->bindParam(":ip_utilisateur", $ip);
			$sth->bindParam(":samaccountname_utilisateur", $samaccountname);
			$sth->bindParam(":rn", $rn);
			$temp = $now->format("Y-m-d H:i:s");
			$sth->bindParam(":date_heure", $temp);
			$action = "INTEGRER DU " . $date_debut . " AU " . $date_fin;
			$sth->bindParam(":action", $action);
		
		} catch (Exception $e) {
			return NULL;
		
		}
		
		// Libération de $now
		unset($now);
		
		// On exécute la requête
		return $sth->execute();
	}
}