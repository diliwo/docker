<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class DolsisFlux extends SoaFlux
{
	const CODE_ACTION_ENTREE = "in";
	const CODE_ACTION_SORTIE = "out";
	const CODE_ACTION_MODIFICATION = "modification";
	const CODE_ACTION_ANNULATION = "cancel";

	/**
	 * Récupère les activités Dimona via Dolsis
	 *
	 * @param  string 	$rn 	Registre national de la personne
	 * @param  string 	$scope 	Vision de la recherche (Active, ActiveInPeriod ou Mutations)
	 * @return array
	 */
	public function getActivites($rn, $scope="active", $dateDebut="", $dateFin="")
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		// On récupère la date et l'heure de maintenant avec le timezone correct
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone('Europe/Brussels'));

		$testPeriode = false;
		if ( in_array($scope, array("activeInPeriod", "mutations")) ) {
			$testPeriode = true;

			$dateDebutTemp = clone $now;
			$dateDebutTemp->modify("-100 years");
			if ($dateDebut != "") {
				$dateDebutTemp = DateTime::createFromFormat("d/m/Y", $dateDebut, new DateTimeZone('Europe/Brussels'));
			}
			$dateFinTemp = clone $now;
			if ($dateFin != "") {
				$dateFinTemp = DateTime::createFromFormat("d/m/Y", $dateFin, new DateTimeZone('Europe/Brussels'));
			}

		}

		$this->arguments["securityContext"] = array(
			"service" => "WELFARE",
			"legalContext" => "SOCIAL_INVESTIGATION_OF_PCSA",
			"role" => "Agent"
		);
		$this->arguments["criteria"] = array(
			"ssin" => $rn,
			"scope" => $scope
		);

		if ($testPeriode == true) {
			$this->arguments["criteria"]["period"] = array(
				"beginDate" => $dateDebutTemp->format("Y-m-d"),
				"endDate" => $dateFinTemp->format("Y-m-d")
			);

		}

		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
		try {
			$data = $this->soapClient->findEmployersByWorker($this->arguments);
            
			switch ($data->status->value) {
				case "DATA_FOUND":
					$ret['error'] = false;
					$ret['data'] = ( ( isset($data->result->employment) ) ? $data->result->employment : NULL );   
					
					switch ($data->status->code) {
						case "DOLS0000":
							$ret['message'] = "no match from NR and CBSS";

							break;

						case "MSG00006":
							$ret['message'] = "Le numéro de registre national a été remplacé";

							break;

						default:
							$ret['message'] = "";

							break;
					}

					break;

				case "NO_DATA_FOUND":
					$ret['error'] = true;

					switch ($data->status->code) {
						case "DOLS0000":
							$ret['message'] = "no match from NR and CBSS/no match from the NR, only CBSS/no match from CBSS, only NR";

							break;

						case "DOLS0004":
							$ret['message'] = "Partial result, no data from authentic source NR (too results)";

							break;

						case "DOLS0005":
							$ret['message'] = "Partial result, no data from authentic source CBSS (too results)é";

							break;

						case "DOLS0009":
							$ret['message'] = "error detected during composition family processé";

							break;

						default:
							$ret['message'] = "";

							break;
					}

					break;

				case "NO_RESULT":
					$ret['error'] = true;
					$ret['message'] = "Aucune données trouvées";

					break;

				default:
					$ret['error'] = true;
					$ret['message'] = "Erreur inconnue";

					break;
			}

		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";

		}

		return $ret;
	}
}
