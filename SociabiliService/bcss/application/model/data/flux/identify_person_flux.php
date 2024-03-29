<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';

class IdentifyPersonFlux extends OldFlux
{
    /**
     * Récupère les données
     *
     * @param string $rn "Numéro de registre national"
     */
	public function getPersonneParRn($rn)
    {
    	if (is_null($this->soapClient))
    		return null;

		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASIdentifyPerson</ServiceId>";
		$xml .=			"<Version>20050930</Version>";
		$xml .=			"<ns1:IdentifyPersonRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/IdentifyPerson'>";
		$xml .=				"<ns1:SearchCriteria>";
		$xml .=					"<ns1:SSIN>". $rn ."</ns1:SSIN>";
		$xml .=				"</ns1:SearchCriteria>";
		$xml .=			"</ns1:IdentifyPersonRequest>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";

		// Gestion des valeurs de retour
		$ret = array();
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));

			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->ReturnCode[0];
            $data = $simpleXml->ServiceReply->children("ns3", true)->IdentifyPersonReply->SearchResults->LimitedLegalData;
			if ($codeErreur > 1) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic;

			}

			if (isset($data)) {	
				$ret['error'] = false;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic;

				$ret['data'] = new stdClass;
				$ret['data']->Basic = new stdClass;
				$ret['data']->Basic->SocialSecurityUser = (string) $data->Basic->SocialSecurityUser;
				$ret['data']->Basic->LastName = (string) $data->Basic->LastName;
				$ret['data']->Basic->FirstName = (string) $data->Basic->FirstName;
				$ret['data']->Basic->BirthDate = (string) $data->Basic->BirthDate;
				$ret['data']->Basic->Gender = (int) $data->Basic->Gender;

				$ret['data']->Basic->Address = new stdClass;
				$ret['data']->Basic->Address->CountryCode = (int) $data->Basic->Address->CountryCode;
				$ret['data']->Basic->Address->MunicipalityCode = (int) $data->Basic->Address->MunicipalityCode;
				$ret['data']->Basic->Address->Municipality = (string) $data->Basic->Address->Municipality;
				$ret['data']->Basic->Address->PostalCode = (string) $data->Basic->Address->PostalCode;
				$ret['data']->Basic->Address->StreetCode = (int) $data->Basic->Address->StreetCode;
				$ret['data']->Basic->Address->Street = (string) $data->Basic->Address->Street;
				$ret['data']->Basic->Address->HouseNumber = (int) $data->Basic->Address->HouseNumber;
				if (isset($data->Basic->Address->Box))
					$ret['data']->Basic->Address->Box = (int) $data->Basic->Address->Box;

			}

		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "impossible de se connecter au flux";

		}

		return $ret;

		/*
        try
        {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
        	$dom = new DomDocument();
			$dom->loadXML(utf8_encode($res));

			$code_erreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
			if ($code_erreur > 1)
			{
				return null;
			}
			else
			{
				return $dom->saveXML($dom->getElementsByTagName('ServiceReply')->item(0));
			}
        }
        catch (Exception $e)
        {
            return null;
        }
        */
    }

    /**
     * Récupère les données formatées dans un tableau
     *
     * @param string $rn "Numéro de registre national"
     */
    public function getDataArray($rn)
    {
    	if (is_null($this->soapClient)) {
    		return null;
    	}

    	$dom = new DomDocument();
		$dom->loadXML($this->getPersonneParRn($rn));

		$code_erreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
		if ($code_erreur>1)
		{
			return null;
		}
		else
		{
			$reply = $dom->getElementsByTagName('ServiceReply');
			$params = array();
			if ($reply->length > 0)
			{
				$params['rn'] = $reply->item(0)->getElementsByTagName('SocialSecurityUser')->item(0)->nodeValue;
				$params['nom'] = $reply->item(0)->getElementsByTagName('LastName')->item(0)->nodeValue;
				$params['prenom'] = $reply->item(0)->getElementsByTagName('FirstName')->item(0)->nodeValue;

				$date_anniversaire_tmp = explode('-', $reply->item(0)->getElementsByTagName('BirthDate')->item(0)->nodeValue);
				$params['date_naissance'] = $date_anniversaire_tmp[2].'/'.$date_anniversaire_tmp[1].'/'.$date_anniversaire_tmp[0];
				$params['sexe'] = ($reply->item(0)->getElementsByTagName('Gender')->item(0)->nodeValue==1)?'MASCULIN':'FEMININ';
				$node_adresse = $reply->item(0)->getElementsByTagName('Address');
				if ($node_adresse->length > 0)
				{
					$params['adresse'] = $node_adresse->item(0)->getElementsByTagName('Street')->item(0)->nodeValue;
					$params['adresse'] .= ", " . $node_adresse->item(0)->getElementsByTagName('HouseNumber')->item(0)->nodeValue;
					if (isset($node_adresse->item(0)->getElementsByTagName('Box')->item(0)->nodeValue)) {
						$params['adresse'] .= "/" . $node_adresse->item(0)->getElementsByTagName('Box')->item(0)->nodeValue;
					}

					$params['adresse'] .= " - " . $node_adresse->item(0)->getElementsByTagName('PostalCode')->item(0)->nodeValue;
					$params['adresse'] .= " " . $node_adresse->item(0)->getElementsByTagName('Municipality')->item(0)->nodeValue;


				}
				else
				{
					$node_adresse = $reply->item(0)->getElementsByTagName('DiplomaticPost');
					if ($node_adresse->length > 0)
					{
						$params['adresse'] = $node_adresse->item(0)->getElementsByTagName('AddressPlainText')->item(0)->nodeValue;
					}
				}

			}
			return $params;
		}
    }
}
