<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class HealthcareInsuranceFlux extends SoaFlux
{
	const INSURING_ORGANIZATION				= 1;
	const REIMBURSEMENT_RIGHT				= 2;
	const CT1_CT2							= 4;
	const PAYING_THIRD_PARTY				= 8;
	const MAXIMUM_CHARGE					= 16;
	const MEDICAL_HOUSE						= 32;
	const INCREASED_INTERVENTION			= 64;
	const STATUS_COMPLEMENTARY_INSURANCE	= 128;
	const GLOBAL_MEDICAL_FILE				= 256;
	const SFDF_L891							= 512;

	public function getAssurabilites($rn, $date="", $donnees=null)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		// Récupération de la date du jour
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone("Europe/Brussels"));

		// Récupération de la date dans le critère de temps
		if (!empty($date)) {
			$critereTemps = array("date" => $date);

		} else {
			$critereTemps = array("today" => "true");

		}

		// Récupération des données
		$nomDonnees = array(
			"insuringOrganization",
			"reimbursementRight",
			"ct1ct2",
			"payingThirdParty",
			"maximumCharge",
			"medicalHouse",
			"increasedIntervention",
			"statusComplementaryInsurance",
			"globalMedicalFile",
			"sfdfL891"
		);

		$donneesDemandees = array();
		if (!is_null($donnees)) {
			foreach ($nomDonnees as $key) {
				$donneesDemandees[$key] = false;
			}
			foreach ($donnees as $key) {
				if (in_array($key, $nomDonnees))
					$donneesDemandees[$key] = true;
			}

		} else {
			foreach ($nomDonnees as $key) {
				$donneesDemandees[$key] = true;
			}
		}
		
		// Génération des arguments à envoyer
		$this->arguments["legalContext"] = "social inquiry and financial help";
		$this->arguments["criterion"] = array(
			"ssin" => $rn,
			"temporalCriteria" => $critereTemps,
			"desiredData" => $donneesDemandees
		);
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$data = $this->soapClient->getInsuranceOrganizationInformations($this->arguments);

			$ret['error'] = false;
			$ret['message'] = $data->status->description;
			if (isset($data->status->information)) {
				$ret['message'] .= ": ";
				if (is_array($data->status->information)) {
					foreach ($data->status->information as $key => $value) {
						$ret['message'] .= (string) $value->fieldName ."->" . (string) $value->fieldValue . " - ";
					}

				} else {
					$ret['message'] = $data->status->information;

				}
				
			}
			$ret['data'] = $data->result;
			
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";
			
		}
		
		return $ret;
	}
}
