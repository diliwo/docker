 <?php
 
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class TaxiAsFlux extends SoaFlux
{
	/**
	 * Récupération des revenus disponible IPCAL
	 *
	 * @param type $rn
	 * @param type $langue
	 * @param type $historique
	 * @return Exception
	 */
	public function getRevenusDisponible($rn, $contexteLegal="SOCIAL_INVESTIGATION_OF_PCSA")
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		$this->arguments['legalContext'] = $contexteLegal;
		$this->arguments['searchCriteria'] = array(
			"ssin" =>$rn,
			"taxAssessmentDataSelection" => "NET_INCOME"
		);
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
		try {
			$data = $this->soapClient->getTaxAssessmentData($this->arguments);

			switch ($data->status->code) {
				case 'MSG00000':
					$ret['error'] = false;
					$ret['message'] = "";
					$ret['data'] = $data->taxAssessmentData;

					break;

				case 'TAXA0007':
					$ret['error'] = false;
					$ret['message'] = "Aucune donnée relative à une déclaration fiscale n'a été trouvée pour le NISS auprès du SPF Finances pour une année de revenus jusqu'à trois ans dans le passé";

					break;

				case 'MSG00005':
					$ret['error'] = true;
					$ret['message'] = "Aucune personne avec NISS n'a été trouvée";

					break;

				case 'MSG00006':
					$ret['error'] = true;
					$ret['message'] = "NISS remplacé";

					break;

				case 'MSG00007':
					$ret['error'] = true;
					$ret['message'] = "NISS annulé";

					break;

				case 'MSG00011':
					$ret['error'] = true;
					$ret['message'] = "La structure du NISS n'est pas valide";

					break;

				case 'MSG00012':
					$ret['error'] = true;
					$ret['message'] = "NISS pas  intégré suffisamment";

					break;

				case 'MSG00013':
					$ret['error'] = true;
					$ret['message'] = "Contexte légal non valide pour ce service, cette opération et ce client";

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