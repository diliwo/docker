<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class HandiFlux extends SoaFlux
{
	/**
	 * Permet de récupérer toutes les données.
	 *
	 * @param int $rn
	 * @param string $date
	 * @return array
	 */
	public function getData($rn, $date)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		$datePaiementDebut = new DateTime($date);
		$datePaiementFin = clone $datePaiementDebut;
		$datePaiementDebut->modify("-1 year");
		$datePaiementDebut->modify("-11 month");

		$this->arguments["legalContext"] = "social inquiry";
		$this->arguments["wantedInformation"] = array(
			"ssin" => $rn,
			"informationAtReferenceDate" => array(
				"referenceDate" => $date,
				"evolutionOfRequest" => true,
				"handicapRecognition" => true,
				"rights" => true,
				"socialCards" => true
			),
			"paymentsAtPeriod" => array(
				"startDate" => $datePaiementDebut->format("Y-m-d"),
				"endDate" => $datePaiementFin->format("Y-m-d")
			)
		);

		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "";

		try {
			$data = $this->soapClient->consultFile($this->arguments);

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

				case 'SSK00003':
				case 'MSG00021':
					$ret['error'] = true;
					$ret['message'] = "Personne non connue auprès de la DGPH.";

					break;

				case 'HAN00010':
					$ret['error'] = true;
					$ret['message'] = "Le client n'est pas autorisé.";

					break;

				case 'HAN00011':
					$ret['error'] = true;
					$ret['message'] = "Les informations ne sont pas autorisées.";

					break;

				case 'HAN00020':
					$ret['error'] = true;
					$ret['message'] = "La période de paiement est suppérieur à deux ans.";

					break;

				case 'HAN00021':
					$ret['error'] = true;
					$ret['message'] = "La période de paiement n'est pas ascendante.";

					break;

				case 'HAN00022':
					$ret['error'] = false;
					$ret['message'] = "Aucune information n'a été demandée.";

					break;

				case 'HAN00023':
					$ret['error'] = false;
					$ret['message'] = "Toutes les informations demandées sont à faux.";

					break;

				case 'HAN00030':
				case 'HAN00033':
					$ret['error'] = true;
					$ret['message'] = "Requête à la DGPH : erreur de validation avec le schéma.";

					break;

				case 'HAN00031':
					$ret['error'] = true;
					$ret['message'] = "Une erreur s'est produite à la DGPH.";

					break;

				case 'HAN00032':
					$ret['error'] = true;
					$ret['message'] = "Pas de résultat reçu de la DGPH.";

					break;

				default:
					$ret['error'] = true;
					$ret['message'] = "ERREUR INCONNUE";

					break;
			}

			if ($ret['error'] == false) {
				$ret['data'] = $data->file;
			}

		} catch (Exception $e) {
			echo $e->getMessage();
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";

		}

		return $ret;
	}

	/**
	 * Permet de récupérer les sommes payées par la DGPH.
	 *
	 * @param  integer 	$rn 		Numéro de registre national
	 * @param  string 	$dateDebut 	Date de début de la période
	 * @param  string 	$dateFin 	Date de fin de la période
	 * @return array
	 */
	public function getSommesPayees($rn, $dateDebut, $dateFin)
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		return array();
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

			case 'SSK00003':
			case 'MSG00021':
				$ret['error'] = true;
				$ret['message'] = "Personne non connue auprès de la DGPH.";

				break;					

			case 'HAN00010':
				$ret['message'] = "Le client n'est pas autorisé.";

				break;

			case 'HAN00011':
				$ret['message'] = "Les informations ne sont pas autorisées.";

				break;

			case 'HAN00020':
				$ret['message'] = "La période de paiement est suppérieur à deux ans.";

				break;

			case 'HAN00021':
				$ret['message'] = "La période de paiement n'est pas ascendante.";

				break;

			case 'HAN00022':
				$ret['message'] = "Aucune information n'a été demandée.";

				break;

			case 'HAN00023':
				$ret['message'] = "Toutes les informations demandées sont à faux.";

				break;

			case 'HAN00030':
			case 'HAN00033':
				$ret['message'] = "Requête à la DGPH : erreur de validation avec le schéma.";

				break;

			case 'HAN00031':
				$ret['message'] = "Une erreur s'est produite à la DGPH.";

				break;

			case 'HAN00032':
				$ret['message'] = "Pas de résultat reçu de la DGPH.";

				break;

			default:
				$message = "Des données conformes aux critères de recherche ont été trouvées.";

				break;
		}

		return $message;
	}
}
