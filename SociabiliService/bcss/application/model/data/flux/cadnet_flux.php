<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class CadnetFlux extends SoaFlux
{
	const DEMANDEUR = 1;
	const COHABITANT_DEMANDEUR = 2;
	const DEBITEUR_ALIMENTAIRE_DEMANDEUR = 3;
	
	/**
	 * TEST
	 *
	 * @param type $rn
	 * @param type $naturePersonne
	 * @param type $langue
	 * @return Exception
	 */
	public function getProprietes($rn, $naturePersonne=1, $langue='FR')
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments['searchCriterion'] = array(
			'naturalPerson' => array(
				'ssin' => $rn
			),
			'naturePerson' => $naturePersonne,
			'language' => $langue
		);
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$data = $this->soapClient->findProperties($this->arguments);

			//echo "<pre>"; print_r($data); echo "</pre>";
			
			switch ($data->status->code) {
				case "PERSON_WITH_PROPERTIES_AND_PARTNER":
					$ret['error'] = false;
					$ret['message'] = "La réponse contient les données du partenaire du propriétaire ainsi que les données des biens immobiliers de la personne interrogée.";
					$ret['data'] = $data->businessData;
					
					break;
					
				case "PERSON_WITHOUT_PARTNER_WITH_PROPERTIES":
					$ret['error'] = false;
					$ret['message'] = "La réponse contient les données des biens immobiliers de la personne interrogée mais pas celles de son partenaire.";
					$ret['data'] = $data->businessData;
					
					break;
					
				case "PERSON_WITHOUT_PARTNER_AND_PROPERTIES":
					$ret['error'] = false;
					$ret['message'] = "La réponse ne contient ni les données du partenaire ni celles des biens immobiliers de la personne interrogée.";
					$ret['data'] = $data->businessData;
					
					break;
					
				case "PERSON_WITH_PARTNER_WITHOUT_PROPERTIES":
					$ret['error'] = false;
					$ret['message'] = "La réponse contient les données du partenaire mais pas celles des biens immobiliers de la personne interrogée.";
					$ret['data'] = $data->businessData;
					
					break;
					
				case "PERSON_UNKNOWN_FODFIN":
					$ret['error'] = true;
					$ret['message'] = "La personne interrogée n’est pas connue du SPF Finances.";
					
					break;
					
				case "INVALID_RESPONSE_FODFIN":
					$ret['error'] = true;
					$ret['message'] = "La réponse à la requête du SPF-Finances ne peut pas être interprétée.";
					
					break;
					
				case "ERROR_FODFIN":
					$ret['error'] = true;
					$ret['message'] = "Une erreur a été renvoyée par le SPF-Finances.";
					
					break;
					
				case "VALIDATION_ERROR":
					$ret['error'] = true;
					$ret['message'] = "Une erreur de validation du schéma s'est produite.";
					
					break;
					
				case "INSZ_UNKNOW_IN_LEGAL_CONTEXT_CBSS":
					$ret['error'] = true;
					$ret['message'] = "Le NISS est inconnu pour le CPAS dans le contexte légal approprié de la BCSS.";
					
					break;
					
				case "INSZ_UNKNOW_IN_LEGAL_CONTEXT_PPSSI":
					$ret['error'] = true;
					$ret['message'] = "Le NISS est inconnu pour le CPAS dans le contexte légal approprié du SPP-IS.";
					
					break;
					
				case "SSIN_PROBLEM":
					$ret['error'] = true;
					$ret['message'] = "Problème rencontré avec le NISS.";
					
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