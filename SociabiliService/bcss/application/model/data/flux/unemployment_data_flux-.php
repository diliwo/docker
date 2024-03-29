<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class UnemploymentData extends SoaFlux
{
	/**
	 * Permet de récupérer les données de la dernière situation ou de la situation à une date pour laquelle 
	 * il existe des paiements
	 *
	 * @param int $rn
	 * @param string $date
	 * @return array
	 */
	public function getSituation($rn, $date='')
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments["legalContext"] = "SOCIAL_INVESTIGATION_OF_PCSA";
		if (empty($date)) {

			$this->arguments["searchCriteria"] = array(
				"ssin" => $rn,
				"lastKnownPayments" => true
			);

		} else {
			$this->arguments["searchCriteria"] = array(
				"ssin" => $rn,
				"date" => $date
			);
		}
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "";

		try {
			$data = $this->soapClient->getSituation($this->arguments);
			
			switch ($data->status->code) {
				case 'MSG00000':
					$ret['error'] = false;
					//$ret['message'] = "Des données conformes aux critères de recherche ont été trouvées.";

					break;

				case 'MSG00001':
					$ret['error'] = true;
					$ret['message'] = "Le service (BCSS) est momentanément indisponible. Veuillez réessayer plus tard.";

					break;

				case 'MSG00002':
					$ret['error'] = true;
					$ret['message'] = "Le service externe est indisponible (ONEM ou répertoire sectoriel). Veuillez réessayer plus tard.";

					break;

				case 'MSG00003':
					$ret['error'] = true;
					$ret['message'] = "Erreur interne (BCSS) inattendue";

					break;

				case 'MSG00005':
					$ret['error'] = true;
					$ret['message'] = "NISS n’est pas connu";

					break;

				case 'MSG00006':
					$ret['error'] = true;
					$ret['message'] = "NISS remplacé";

					break;

				case 'MSG00007':
					$ret['message'] = "NISS annulé";

					break;

				case 'MSG00011':
					$ret['error'] = true;
					$ret['message'] = "Format NISS invalide";

					break;

				case 'MSG00012':
					$ret['error'] = true;
					$ret['message'] = "NISS inconnu auprès du CPAS dans le contexte légalcorrect. (Intégration)";

					break;

				case 'MSG00013':
					$ret['error'] = true;
					$ret['message'] = "Contexte légal invalide";

					break;

				case 'UD000001':
					$ret['error'] = true;
					$ret['message'] = "Communication avec service externe non valide (ONEM).";

					break;

				case 'UD000011':
					$ret['error'] = true;
					$ret['message'] = "Des données répondant aux critères de recherche n’ont pas été trouvées.";

					break;

				case 'UD000012':
					$ret['error'] = true;
					$ret['message'] = "NISS inconnu auprès de l’ONEM dans le contexte légal de la BCSS. (Intégration)";

					break;

				case 'UD000013':
					$ret['error'] = true;
					$ret['message'] = "Paiement sans droit connu à la date demandée (Ceci est anormal. Le paiement n’est pas communiqué dans ce cas.)";

					break;

				case 'UD000017':
					$ret['error'] = false;
					$ret['message'] = "La situation du droit est connue, mais aucun paiement n’est connu.";

					break;

				case 'UD000018':
					$ret['error'] = false;
					$ret['message'] = "Le dossier n’est pas migré et cette personne n'est donc pas chômeuse";

					break;

				case 'UD000031':
					$ret['error'] = true;
					$ret['message'] = "Indication de temps incorrecte dans la demande";

					break;

				case 'UD000033':
					$ret['error'] = true;
					$ret['message'] = "La personne n'a plus droit aux allocations d'insertion";

					break;
				
				default:
					$ret['error'] = true;
					$ret['message'] = "ERREUR INCONNUE";

					break;
			}

			if ($ret['error'] == false) {
				$ret['data'] = $data->situation;

			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";
			
		}
		
		return $ret;
	}

	/**
	 * Permet de récupérer les sommes payées par les organismes de paiement ainsi que le montant approuvé 
	 * par l'ONEM pour les mois pendant une période spécifiée, pour chaque type de chômage
	 * 
	 * @param  integer 	$rn 		Numéro de registre national
	 * @param  string 	$moisDebut 	Mois de début de la période
	 * @param  string 	$moisFin 	Mois de fin de la période
	 * @return array
	 */
	public function getSommesPayees($rn, $moisDebut, $moisFin)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		$today = new DateTime();
		$dateDebut = DateTime::createFromFormat('Y-m-d', $moisDebut . "-01", new DateTimeZone("Europe/Brussels"));
		$dateFin = DateTime::createFromFormat('Y-m-d', $moisFin . "-01", new DateTimeZone("Europe/Brussels"));
		$diff = $dateFin->diff($dateDebut);
		$nbMois = (12 * ((int) $diff->y) + ((int) $diff->m)) + 1;

		// On ne peut revenir plus de 3 ans en arrière
		if ($nbMois > 36)
			$nbMois = 36;

		$sommesPayees = array();
		for ($i=0; $i<($nbMois/3); $i++) {
			if ($i > 0) {
				$dateDebut = clone $dateFin;
				$dateDebut->modify("+1 month");
			}
			$dateFin = clone $dateDebut;
			$dateFin->modify("+2 months");

			if ($dateFin > $today)
				$dateFin = $today;

			//echo $i . ") " . $dateDebut->format('d/m/Y') . " - " . $dateFin->format('d/m/Y') . "<br />";
			$this->arguments["legalContext"] = "SOCIAL_INVESTIGATION_OF_PCSA";
			$this->arguments["searchCriteria"] = array(
				"ssin" => $rn,
				"period" => array(
					"startMonth" => $dateDebut->format('Y-m'),
					"endMonth" => $dateFin->format('Y-m')
				)
			);

			// Gestion des valeurs de retour
			$ret['error'] = true;
			$ret['message'] = "";

			try {
				$data = $this->soapClient->getPayedSums($this->arguments);
				if ((isset($data->payedSums->payedSum) ) && is_array($data->payedSums->payedSum)) {
					$sommesPayees = array_merge($sommesPayees, $data->payedSums->payedSum);

				} else {
				    $sommesPayees[] = (isset( $data->payedSums->payedSum) ? $data->payedSums->payedSum : NULL) ;

				}
				$sommesPayees = array_filter($sommesPayees);

			} catch (Exception $e) {
				$ret['message'] = "Impossible de se connecter au flux";
				
			}
			
		}
		$ret['data']['payedSum'] = $sommesPayees;
		echo '<pre>';
		
		print_r($sommesPayees);
		echo '</pre>';
		return $ret;
	}

	/**
	 * Permet de récupérer les montants d'activation alloué et du numéro BCE de l'employeur
	 * 
	 * @param  integer 	$rn 		Numéro de registre national
	 * @param  string 	$moisDebut 	Mois de début de la période
	 * @param  string 	$moisFin 	Mois de fin de la période
	 * @return array
	 */
	public function getSommesPayeesAllocationsActivation($rn, $moisDebut, $moisFin)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		$today = new DateTime();
		$dateDebut = DateTime::createFromFormat('Y-m-d', $moisDebut . "-01", new DateTimeZone("Europe/Brussels"));
		$dateFin = DateTime::createFromFormat('Y-m-d', $moisFin . "-01", new DateTimeZone("Europe/Brussels"));
		$diff = $dateFin->diff($dateDebut);
		$nbMois = (12 * ((int) $diff->y) + ((int) $diff->m)) + 1;

		// On ne peut revenir plus de 3 ans en arrière
		if ($nbMois > 36)
			$nbMois = 36;

		$sommesPayees = array();
		for ($i=0; $i<($nbMois/4); $i++) {
			if ($i > 0) {
				$dateDebut = clone $dateFin;
				$dateDebut->modify("+1 month");
			}
			$dateFin = clone $dateDebut;
			$dateFin->modify("+3 months");

			if ($dateFin > $today)
				$dateFin = $today;

			$quadrimestre = ceil(((int) $dateFin->format('m')) / 4);
			$annee = $dateFin->format('Y');

			$this->arguments["legalContext"] = "SOCIAL_INVESTIGATION_OF_PCSA";
			$this->arguments["searchCriteria"] = array(
				"ssin" => $rn,
				"quarter" => array(
					"quarterNumber" => $quadrimestre,
					"year" => $annee
				)
			);

			// Gestion des valeurs de retour
			$ret['error'] = true;
			$ret['message'] = "";

			try {
				$data = $this->soapClient->getPayedActivationSums($this->arguments);
				
				if (is_array($data->payedActivationSums)) {
					$sommesPayees = array_merge($sommesPayees, $data->payedActivationSums);

				} else {
					$sommesPayees[] = $data->payedActivationSums;

				}
				$sommesPayees = array_filter($sommesPayees);
				

			} catch (Exception $e) {
				$ret['message'] = "Impossible de se connecter au flux";
				
			}
			
		}
		$ret['data']['payedActivationSum'] = $sommesPayees;
		 
		return $ret;
	}
	
	public static function getMessageErreur($code)
	{
		$message = "";

		switch ($code) {
			case 'MSG00000':
				$message = "Des données conformes aux critères de recherche ont été trouvées.";

				break;

			case 'MSG00001':
				$message = "Le service (BCSS) est momentanément indisponible. Veuillez réessayer plus tard.";

				break;

			case 'MSG00002':
				$message = "Le service externe est indisponible (ONEM ou répertoire sectoriel). Veuillez réessayer plus tard.";

				break;

			case 'MSG00003':
				$message = "Erreur interne (BCSS) inattendue";

				break;

			case 'MSG00005':
				$message = "NISS n’est pas connu";

				break;

			case 'MSG00006':
				$message = "NISS n’est pas connu";

				break;

			case 'MSG00007':
				$message = "NISS n’est pas connu";

				break;

			case 'MSG00011':
				$message = "Format NISS invalide";

				break;

			case 'MSG00012':
				$message = "NISS inconnu auprès du CPAS dans le contexte légalcorrect. (Intégration)";

				break;

			case 'MSG00013':
				$message = "Contexte légal invalide";

				break;

			case 'UD000001':
				$message = "Communication avec service externe non valide (ONEM).";

				break;

			case 'UD000011':
				$message = "Des données répondant aux critères de recherche n’ont pas été trouvées.";

				break;

			case 'UD000012':
				$message = "NISS inconnu auprès de l’ONEM dans le contexte légal de la BCSS. (Intégration)";

				break;

			case 'UD000013':
				$message = "Paiement sans droit connu à la date demandée (Ceci est anormal. Le paiement n’est pas communiqué dans ce cas.)";

				break;

			case 'UD000017':
				$message = "La situation du droit est connue, mais aucun paiement n’est connu.";

				break;

			case 'UD000018':
				$message = "Le dossier n’est pas migré et cette personne n'est donc pas chômeuse";

				break;

			case 'UD000031':
				$message = "Indication de temps incorrecte dans la demande";

				break;
			
			default:
				$message = "Des données conformes aux critères de recherche ont été trouvées.";

				break;
		}

		return $message;
	}
}
