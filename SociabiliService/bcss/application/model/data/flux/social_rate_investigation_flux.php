<?php

require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class SocialRateInvestigationFlux extends SoaFlux
{
    const CODE_DONNEES_TROUVEES = "MSG00000";

	public function getData($rn, $contexteLegal="Social Rate Investigation")
	{
        // Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;

		$this->arguments['legalContext'] = $contexteLegal;
		$this->arguments['criterion'] = array(
			"ssin" => $rn
		);

		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$data = $this->soapClient->consultExchangedData($this->arguments);

			if ($data->status->code == self::CODE_DONNEES_TROUVEES) {
				$ret['error'] = false;
				$ret['message'] = "";

				if (is_array($data->result)) {
					$ret['data'] = $data->result;

				} else {
					$ret['data'][] = $data->result;

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
