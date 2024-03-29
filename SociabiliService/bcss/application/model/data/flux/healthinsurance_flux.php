<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';

class HealthinsuranceFlux extends OldFlux
{	
	/**
	 * Récupère les assurabilités
	 * 
	 * @param unknown_type $rn
	 * @param unknown_type $dateDebut
	 * @param unknown_type $dateFin
	 */
    public function getAssurabilites($rn, $dateDebut='', $dateFin='')
    {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Recherche de la période
    	if (empty($dateDebut)) {
    		if (empty($dateFin)) {
    			$dateFin = new DateTime();
    			
    		}
    		$dateDebut = clone $dateFin;
    		$dateDebut->modify("-5 years");
    	} else {
    		$dateDebut = DateTime::createFromFormat ("d/m/Y", $dateDebut);
    		
    		if (empty($dateFin)) {
    			$dateFin = clone $dateDebut;
    			$dateFin->modify("+5 years");
    			 
    		} else {
    			$dateFin = DateTime::createFromFormat ("d/m/Y", $dateFin);
    		}
    	}
    	
    	// XML envoyé
		$xml  = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=		$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASHealthInsurance</ServiceId>";
		$xml .=			"<Version>20070509</Version>";
		$xml .=			"<ns1:HealthInsuranceRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/HealthInsurance'>";
		$xml .=				"<ns1:SSIN>" . $rn . "</ns1:SSIN>";
		$xml .=				"<ns1:Assurability>";
		$xml .=					"<ns1:Period>";
		$xml .=						"<ns1:StartDate>" . $dateDebut->format("Y-m-d") . "</ns1:StartDate>";
		$xml .=						"<ns1:EndDate>" . $dateFin->format("Y-m-d") . "</ns1:EndDate>";
		$xml .=					"</ns1:Period>";
		$xml .=				"</ns1:Assurability>";
		$xml .=			"</ns1:HealthInsuranceRequest>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
		
		// Gestion des valeurs de retour
        $ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
        try
        {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
            
            $simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0];
            
			} else {
            	$assurabilites = $simpleXml->ServiceReply->children("ns3", true)->HealthInsuranceReply->children("ns3", true)->Insurance;
            	if (!empty($assurabilites)) {
            		$ret['error'] = false;
            		$ret['message'] = "";
            		
            		$i=0;
            		foreach ($assurabilites as $assurabilite) {
	            		$ret['data'][$i]->HolderRights->YearApplicationMaximumToBeInvoiced[0] = (string) $assurabilite->HolderRights->YearApplicationMaximumToBeInvoiced[0];
	            		$ret['data'][$i]->HolderRights->YearApplicationMaximumToBeInvoiced[1] = (string) $assurabilite->HolderRights->YearApplicationMaximumToBeInvoiced[1];
	            		$ret['data'][$i]->HolderRights->PayingThirdIndicator = (string) $assurabilites->HolderRights->PayingThirdIndicator;
	            		
	            		$ret['data'][$i]->InsurancePart->HealthServiceIdentification = (string) $assurabilite->InsurancePart->HealthServiceIdentification;
	            		$ret['data'][$i]->InsurancePart->HealthServiceRegistrationNumber = (string) $assurabilite->InsurancePart->HealthServiceRegistrationNumber;
	            		
	            		$ret['data'][$i]->InsurancePart->HolderCode[1]->Regime = (int) $assurabilite->InsurancePart->HolderCode1->Regime;
	            		$ret['data'][$i]->InsurancePart->HolderCode[1]->SocialStatus = (int) $assurabilite->InsurancePart->HolderCode1->SocialStatus;
	            		$ret['data'][$i]->InsurancePart->HolderCode[1]->IncreasedIntervention = (int) $assurabilite->InsurancePart->HolderCode1->IncreasedIntervention;
	            		
	            		$ret['data'][$i]->InsurancePart->HolderCode[2]->Regime = (int) $assurabilite->InsurancePart->HolderCode2->Regime;
	            		$ret['data'][$i]->InsurancePart->HolderCode[2]->SocialStatus = (int) $assurabilite->InsurancePart->HolderCode2->SocialStatus;
	            		$ret['data'][$i]->InsurancePart->HolderCode[2]->IncreasedIntervention = (int) $assurabilite->InsurancePart->HolderCode2->IncreasedIntervention;
	            		
	            		$dateTemp = explode("+", (string) $assurabilite->InsurancePart->InsurancePeriod->StartDate);
	            		$ret['data'][$i]->InsurancePart->InsurancePeriod->StartDate = $dateTemp[0];
	            		$dateTemp = explode("+", (string) $assurabilite->InsurancePart->InsurancePeriod->EndDate);
	            		$ret['data'][$i]->InsurancePart->InsurancePeriod->EndDate = $dateTemp[0];
	            		
	            		$i++;
            		}
            		
            	} else {
            		$ret['error'] = true;
            		$ret['message'] = "Aucune donnée";
            	}
            }
        }
        catch (Exception $e)
        {
            $ret['error'] = true;
			$ret['message'] = "impossible de se connecter au flux";
        }
        
        return $ret;
    }
    
    /**
     * Récupére les indemnités
     * 
     * @param unknown_type $rn
     * @param unknown_type $dateDebut
     * @param unknown_type $dateFin
     */
    public function getIndemnites($rn, $dateDebut='', $dateFin='')
    {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Recherche de la période
    	if (empty($dateDebut)) {
    		if (empty($dateFin)) {
    			$dateFin = new DateTime();
    			
    		}
    		$dateDebut = clone $dateFin;
    		$dateDebut->modify("-5 years");
    	} else {
    		$dateDebut = DateTime::createFromFormat ("d/m/Y", $dateDebut);
    		
    		if (empty($dateFin)) {
    			$dateFin = clone $dateDebut;
    			$dateFin->modify("+5 years");
    			 
    		} else {
    			$dateFin = DateTime::createFromFormat ("d/m/Y", $dateFin);
    		}
    	}
    	
    	// XML envoyé
		$xml  = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=		$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASHealthInsurance</ServiceId>";
		$xml .=			"<Version>20070509</Version>";
		$xml .=			"<ns1:HealthInsuranceRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/HealthInsurance'>";
		$xml .=				"<ns1:SSIN>" . $rn . "</ns1:SSIN>";
		//$xml .=				"<ns1:Assurability>";
		//$xml .=					"<ns1:Period>";
		//$xml .=						"<ns1:StartDate>" . $dateDebut->format("Y-m-d") . "</ns1:StartDate>";
		//$xml .=						"<ns1:EndDate>" . $dateFin->format("Y-m-d") . "</ns1:EndDate>";
		//$xml .=					"</ns1:Period>";
		//$xml .=				"</ns1:Assurability>";
		$xml .=				"<ns1:Indemnity>";
		$xml .=					"<ns1:Period>";
		$xml .=						"<ns1:StartDate>" . $dateDebut->format("Y-m-d") . "</ns1:StartDate>";
		$xml .=						"<ns1:EndDate>" . $dateFin->format("Y-m-d") . "</ns1:EndDate>";
		$xml .=					"</ns1:Period>";
		$xml .=				"</ns1:Indemnity>";
		$xml .=			"</ns1:HealthInsuranceRequest>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
		
        // Gestion des valeurs de retour
        $ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
        try
        {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
            
            $simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0];
            
			} else {
				$ret['error'] = true;
				$ret['message'] = "";
				
            }
        }
        catch (Exception $e)
        {
            $ret['error'] = true;
			$ret['message'] = "impossible de se connecter au flux";
        }
        
        return $ret;
    }
    
	/**
     * Récupére les indemnités
     * 
     * @param unknown_type $rn
     * @param unknown_type $date_debut
     * @param unknown_type $date_fin
     */
    public function getAssurabilitesIndemnites($rn, $date_debut=null, $date_fin=null)
    {
    	$retour = array("CODE_ERREUR" => "", "ASSURABILITES_INDEMNITES" => null);
    	
    	// Recherche de la période
    	if (is_null($date_fin))
    	{
    		$date_fin = date("Y-m-d");
	    	if (is_null($date_debut))
	    	{
	    		$date_debut = (date("Y")-5)."-".date("m-d");
	    	}
    	}
    	
    	// XML envoyé
		$xml  = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=		$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASHealthInsurance</ServiceId>";
		$xml .=			"<Version>20070509</Version>";
		$xml .=			"<ns1:HealthInsuranceRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/HealthInsurance'>";
		$xml .=				"<ns1:SSIN>".$rn."</ns1:SSIN>";
		$xml .=				"<ns1:Indemnity>";
		$xml .=					"<ns1:Period>";
		$xml .=						"<ns1:StartDate>".$date_debut."</ns1:StartDate>";
		$xml .=						"<ns1:EndDate>".$date_fin."</ns1:EndDate>";
		$xml .=					"</ns1:Period>";
		$xml .=				"</ns1:Indemnity>";
		$xml .=			"</ns1:HealthInsuranceRequest>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
		
        try
        {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
        	$dom = new DomDocument();
			$dom->loadXML(utf8_encode($res));
							
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
					$indemnite = new AssurabiliteIndemnite();
					$indemnite->setDataFromXml($res);
					
					$retour["ASSURABILITES_INDEMNITES"][] = $indemnite;
					return $retour;
				}
			}
        }
        catch (Exception $e)
        {
            return null;
        }
    }
    
    /**
     * Récupère les données
     * 
     * @param integer $rn "Numéro de registre national"
     */
    public function getData($rn, $date_debut_assurabilite, $date_fin_assurabilite, $date_debut_indemnite, $date_fin_indemnite)
    {
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=		$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASHealthInsurance</ServiceId>";
		$xml .=			"<Version>20070509</Version>";
		$xml .=			"<ns1:HealthInsuranceRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/HealthInsurance'>";
		$xml .=				"<ns1:SSIN>".$rn."</ns1:SSIN>";
		
		$xml .=				"<ns1:Assurability>";
		$xml .=					"<ns1:Period>";
		$xml .=						"<ns1:StartDate>".$date_debut_assurabilite."</ns1:StartDate>";
		$xml .=						"<ns1:EndDate>".$date_fin_assurabilite."</ns1:EndDate>";
		$xml .=					"</ns1:Period>";
		$xml .=				"</ns1:Assurability>";
		
		/*
		$xml .=				"<ns1:Indemnity>";
		$xml .=					"<ns1:Period>";
		$xml .=						"<ns1:StartDate>".$date_debut_indemnite."</ns1:StartDate>";
		$xml .=						"<ns1:EndDate>".$date_fin_indemnite."</ns1:EndDate>";
		$xml .=					"</ns1:Period>";
		$xml .=				"</ns1:Indemnity>";
		*/
		
		$xml .=			"</ns1:HealthInsuranceRequest>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
		
        try
        {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
        	$dom = new DomDocument();
			$dom->loadXML(utf8_encode($res));
							
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
					
				}
				return $params;
			}
        }
        catch (Exception $e)
        {
            return null;
        }
    }
}