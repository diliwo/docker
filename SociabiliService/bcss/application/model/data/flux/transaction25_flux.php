<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class Transaction25Flux extends SoaFlux
{
	
	const AUCUNE_DONNEE = "NO_DATA_FOUND";
	const CODE_DOSSIER_INACCESSIBLE = "RTIPC001";
	const CODE_OK = "MSG00000";
	const CODE_SSIN_INCORRECT = "MSG00008";
	const CODE_NON_INTEGRE = "MSG00012";
	const CODE_ERREUR_INTERNE = "MSG00003";
	const CODE_FOURNISSEUR_INACCESSIBLE = "MSG00002";

	/**
	 * Récupère un objet de type Personne
	 *
	 * @param type $rn
	 * @param type $langue
	 * @param type $historique
	 * @return Personne
	 */
	public function getData($rn, $langue='fr', $historique=true)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments['legalContext'] = "PCSA:SOCIAL_INQUIRY";
		$this->arguments['searchInformation'] = array(
            'ssin' => $rn,
            'language' => $langue,
            'history' => $historique
		);

		try
		{
			return $this->soapClient->retrieveTI($this->arguments);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	public function getDataArray($rn, $langue='fr', $historique=true)
	{
		$this->arguments['legalContext'] = "PCSA:SOCIAL_INQUIRY";
		$this->arguments['searchInformation'] = array(
				'ssin' => $rn,
				'language' => $langue,
				'history' => $historique
		);
	
		try
		{
			return $this->objectToArray($this->soapClient->retrieveTI($this->arguments));
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	public function getDataXml($rn, $langue='fr', $historique=true)
	{
		if ($this->getData($rn, $langue, $historique))
		{
			return $this->soapClient->__getLastResponse();
		}
		else
		{
			return false;
		}
	}
	public function getTis($rn, $nomTis, $langue='fr', $historique=true)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments['legalContext'] = "PCSA:SOCIAL_INQUIRY";
		$this->arguments['searchInformation'] = array(
				'ssin' => $rn,
				'language' => $langue,
				'history' => $historique
		);
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$data = $this->soapClient->retrieveTI($this->arguments);
			
			if ($data->status->code == self::CODE_OK) {
				$ret['error'] = false;
				$ret['message'] = "";
				$ret['data'] = array();
				foreach ($nomTis as $num=>$nom) {
					if (!empty($nom)) {
						$ret['data'][$num]['name'] = $nom;
				
					}
				}
				
				$tis = $data->rrn_it_implicit;
				
				foreach ($tis as $name=>$ti) {
					if (isset($ti->Type)) {
						if (!isset($ret['data'][$ti->Type]['name']))
							$ret['data'][$ti->Type]['name'] = $name;
						
						$ret['data'][$ti->Type]['data'][] = $ti;
						
					} else {
						foreach ($ti as $value) {
							if (is_array($value)) {
								$tab = $value;
								
								foreach ($tab as $i=>$value2) {
									if (!isset($ret['data'][$value2->Type]['name']))
										$ret['data'][$value2->Type]['name'] = $name;
									
									$ret['data'][$value2->Type]['data'][] = $value2;
									
								}
							} else {
								if (!isset($ret['data'][$value->Type]['name']))
										$ret['data'][$value->Type]['name'] = $name;
								
								$ret['data'][$value->Type]['data'][] = $value;
								
							}
							
						}
						
					}
					
				}
				
			} else {
				$ret['error'] = true;
				$ret['message'] = "Aucune donnée disponible";
				
			}
			
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";
			
		}
		
		return $ret;
		
		/*
		// Récupération des données provenant du flux
		$data = self::getData($rn, $langue, $historique);
		if ($data->status->code == self::CODE_OK) {
			$tis = $data->rrn_it_implicit;
			
			foreach ($tis as $name=>$ti) {
				if (isset($ti->Type)) {
					if (!isset($retour[$ti->Type]['name']))
						$retour[$ti->Type]['name'] = $name;
					$retour[$ti->Type]['data'][] = $ti; //self::objectToArray( $ti );
				} else {
					foreach ($ti as $value) {
						if (is_array($value)) {
							$tab = $value;
							foreach ($tab as $i=>$value) {
								if (!isset($retour[$value->Type]['name']))
									$retour[$value->Type]['name'] = $name;
								$retour[$value->Type]['data'][] = $value; //self::objectToArray( $value );
							}
						} else {
							if (!isset($retour[$value->Type]['name']))
									$retour[$value->Type]['name'] = $name;
							$retour[$value->Type]['data'][] = $value; //self::objectToArray( $value );
						}
						
					}
				}
			}
		}
		
		return $retour;
		*/
	}
	
	private function objectToArray($d)
	{
		if (is_object($d)) {
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			return array_map(__FUNCTION__, $d);
		}
		else {
			return $d;
		}
	}
	
	private function testTi($ti)
	{
		$retour = array();
		$test = get_object_vars($ti);
		
		echo "<pre>";
		print_r($ti);
		echo "</pre>";
	}
}
?>