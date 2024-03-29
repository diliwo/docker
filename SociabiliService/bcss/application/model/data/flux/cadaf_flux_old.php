 <?php
 
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class CadafFlux extends SoaFlux
{
	const CODE_DONNEES_TROUVEES = "MSG00000";
	
	const ROLE_ATTRIBUTAIRE = "ATTRIBUTED";
	const ROLE_ALLOCATAIRE = "ALLOCATED";
	const ROLE_ENFANT_BENEFICIAIRE = "BENEFICIARY_CHILD";
	
	/**
	 * Récupération du dossier CADAF
	 *
	 * @param type $rn
	 * @param type $langue
	 * @param type $historique
	 * @return Exception
	 */
	public function getDossiers($rn, $dateDebut, $dateFin="", $contexteLegal="FAMILY_ALLOWANCE_ADVANCE_CONSULTATION")
	{
	    
	    
	    
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments['legalContext'] = $contexteLegal;
		$this->arguments['ssin'] = $rn;
		
		// Reformatage des dates
		$dateTemp = explode("/", $dateDebut);
		$dateDebut = $dateTemp[2] . "-" . $dateTemp[1];
		if (!empty($dateFin)) {
			$dateTemp = explode("/", $dateFin);
			$dateFin = $dateTemp[2] . "-" . $dateTemp[1];
			
			$this->arguments['searchPeriod'] = array(
				'beginDate' => $dateDebut,
				'endDate' => $dateFin
			);
			
		} else {
			$this->arguments['searchPeriod'] = array(
				'beginDate' => $dateDebut
			);
			
		}
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
		try {
			$data = $this->soapClient->familyAllowancesConsult($this->arguments);
			
			if ($data->status->code == self::CODE_DONNEES_TROUVEES) {
				$ret['error'] = false;
				$ret['message'] = "";
				
				if (is_array($data->cadafDossier)) {
					$ret['data'] = $data->cadafDossier;
					
				} else {
					$ret['data'][] = $data->cadafDossier;
					
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
	}
}