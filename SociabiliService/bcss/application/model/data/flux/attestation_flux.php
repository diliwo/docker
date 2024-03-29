<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';

class AttestationFlux extends OldFlux
{
	/**
	 * Récupère les exonerations avec l'information supplémentaire sur les ART35
	 * 
	 * @param  int    $rn        Numéro de registre natianla
	 * @param  string $dateDebut Date de début
	 * @param  string $dateFin   Date de fin
	 * @param  string $langue    Langue du flux
	 * @return Array
	 */
	public function getExonerationsArt35($rn, $dateDebut = '', $dateFin = '', $langue="fr")
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
		// Recherche de la période
		if (empty($dateDebut)) {
			if (empty($dateFin)) {
				$dateFin = new DateTime(date('Y') . "-12-31");
				
			}
			$dateDebut = clone $dateFin;
			$dateDebut->modify("-10 years");
			$dateDebut->modify("+1 day");
			
		} else {
			$dateDebut = DateTime::createFromFormat ("d/m/Y", $dateDebut);
			
			if (empty($dateFin)) {
				$dateFin = clone $dateDebut;
				$dateFin->modify("+10 years");
				$dateFin->modify("-1 day");
				 
			} else {
				$dateFin = DateTime::createFromFormat ("d/m/Y", $dateFin);
			}
		}
			
		$xml = 
		"<?xml version='1.0' encoding='UTF-8' standalone='yes'?>" .
		"<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>" .
		$this->arguments .
			"<ServiceRequest>" .
				"<ServiceId>OCMWCPASListOfAttestations</ServiceId>" .
				"<Version>20080317</Version>" .
				"<ns1:ListOfAttestationsRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAttests' xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>" .
					"<ns1:SocialSecurityUser>" . $rn . "</ns1:SocialSecurityUser>" .
					"<ns1:RequestType>EXONERATIONSART35</ns1:RequestType>" .
					"<ns1:SearchPeriod>" .
						"<ns2:StartDate>" . $dateDebut->format("Y-m-d") . "</ns2:StartDate>" .
						"<ns2:EndDate>" . $dateFin->format("Y-m-d") . "</ns2:EndDate>" .
					"</ns1:SearchPeriod>" .
				"</ns1:ListOfAttestationsRequest>" .
			"</ServiceRequest>" .
		"</SSDNRequest>";

		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";

		try {
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));

			//echo htmlentities($res);

			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->ReturnCode[0];

			if ($codeErreur > 1) {
				$ret['error'] = true;
				$diagnostique = explode("|", $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0]);
				$ret['message'] = $diagnostique[0];

			} else {
				$ret['error'] = false;
				$ret['message'] = "";

				$listeAttestationsXml = $simpleXml->ServiceReply->children("ns3", true)->ListOfAttestationsReply;

				if (isset($listeAttestationsXml->ExonerationArt35)) {
					$attributs = $listeAttestationsXml->ExonerationArt35[0]->attributes();
					if ((string) $attributs["hasExoneration"] == "true") {
						$ret['data']['ExonerationArt35']['FirstExonerationDate'] = (string) $listeAttestationsXml->ExonerationArt35->FirstExonerationDate[0];
						$ret['data']['ExonerationArt35']['PaymentExoneratedDays'] = (int) $listeAttestationsXml->ExonerationArt35->PaymentExoneratedDays[0];
						
					}

				}

				if (isset($listeAttestationsXml->Attestation)) {
					foreach ($listeAttestationsXml->Attestation as $attestationXml) {
						$ret['data']['Attestation'][] = array(
							'SocialSecurityUser' 	=> (string) $attestationXml->SocialSecurityUser[0],
							'CPAS_KBOBCE_code'		=> (string) $attestationXml->CPAS_KBOBCE_code[0],
							'EntryDate'				=> (string) $attestationXml->EntryDate[0],
							'AttestType'			=> array(
								'Code'			=> (int) $attestationXml->AttestType->Code[0],
								'Description'	=> (string) $attestationXml->AttestType->Description[0]
							),
							'FormType'			=> array(
								'Code'			=> (int) $attestationXml->FormType->Code[0],
								'Description'	=> (string) $attestationXml->FormType->Description[0]
							),
							'Duration'			=> array(
								'Days'		=> (int) $attestationXml->Duration->Days[0],
								'Weeks'		=> (int) $attestationXml->Duration->Weeks[0],
								'Months' 	=> (int) $attestationXml->Duration->Months[0]
							),
							'DecisionDate'			=> (string) $attestationXml->DecisionDate[0],
							'Reference'				=> (int) $attestationXml->Reference[0],
							'Status'				=> (int) $attestationXml->DecisionDate[0],
							'RelationType'			=> array(
								'Code'			=> (int) $attestationXml->RelationType->Code[0],
								'Description'	=> (string) $attestationXml->RelationType->Description[0]
							)
						);

					}

				}

			}

		} catch (Exception $e) {
			$ret['succes'] = "0";
			$ret['data']['status']['description']  = $e->getMessage();

		}
		
		return $ret;
	}
    
    /**
     * Récupère la prime unique d'installation
     * 
     * @param integer $rn "Numéro de registre national"
     */
    public function getPrimeInstallation($rn, $dateDebut = '', $dateFin = '', $langue="fr")
    {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Recherche de la période
    	if (empty($dateDebut)) {
    		if (empty($dateFin)) {
    			$dateFin = new DateTime(date('Y') . "-12-31");
    			
    		}
    		$dateDebut = clone $dateFin;
    		$dateDebut->modify("-10 years");
    		$dateDebut->modify("+1 day");
    		
    	} else {
    		$dateDebut = DateTime::createFromFormat ("d/m/Y", $dateDebut);
    		
    		if (empty($dateFin)) {
    			$dateFin = clone $dateDebut;
    			$dateFin->modify("+10 years");
    			$dateFin->modify("-1 day");
    			 
    		} else {
    			$dateFin = DateTime::createFromFormat ("d/m/Y", $dateFin);
    		}
    	}
    		
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASListOfAttestations</ServiceId>";
 		$xml .=			"<Version>20080317</Version>";
		$xml .=			"<ns1:ListOfAttestationsRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAttests' xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>";
 		$xml .=				"<ns1:SocialSecurityUser>" . $rn . "</ns1:SocialSecurityUser>";
 		$xml .=				"<ns1:RequestType>PRIME_INSTALLATION</ns1:RequestType>";
 		$xml .=				"<ns1:SearchPeriod>";
 		$xml .=					"<ns2:StartDate>" . $dateDebut->format("Y-m-d") . "</ns2:StartDate>";
 		$xml .=					"<ns2:EndDate>" . $dateFin->format("Y-m-d") . "</ns2:EndDate>";
 		$xml .=				"</ns1:SearchPeriod>";
 		$xml .=			"</ns1:ListOfAttestationsRequest>";
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
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$diagnostique = explode("|", $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0]);
				$ret['message'] = $diagnostique[0];
            
			} else {
				$attestation = $simpleXml->ServiceReply->children("ns3", true)->ListOfAttestationsReply->Attestation[0];

				if (isset($attestation)) {
					$ret['error'] = false;
					$ret['message'] = "";
					
				$data = new stdClass(); 
					$data->SocialSecurityUser = (string) $attestation->SocialSecurityUser;
					$data->CPAS_KBOBCE_code = (int) $attestation->CPAS_KBOBCE_code;
					$data->EntryDate = (string) $attestation->EntryDate;
					$data->AttestType = new stdClass();
					$data->AttestType->Code = (string) $attestation->AttestType->Code;
					$data->AttestType->Description = new stdClass();
					$description = explode("/", (string) $attestation->AttestType->Description);
					$data->AttestType->Description->fr = rtrim($description[0]);
					$data->AttestType->Description->nl = ltrim($description[1]);
					$data->FormType = new stdClass();
					$data->FormType->Code = (string) $attestation->FormType->Code;
					$data->FormType->Description = new stdClass();
					$description = explode("/", (string) $attestation->FormType->Description);
					$data->FormType->Description->fr = rtrim($description[0]);
					$data->FormType->Description->nl = ltrim($description[1]);
					$data->Reference = (int) $attestation->Reference;
					$data->Status = (int) $attestation->Status;
					$data->RelationType = new stdClass();
					$data->RelationType->Code = (string) $attestation->RelationType->Code;
					$data->RelationType->Description = new stdClass();
					$description = explode("/", (string) $attestation->RelationType->Description);
					$data->RelationType->Description->fr = rtrim($description[0]);
					$data->RelationType->Description->nl = ltrim($description[1]);
					$ret['data'] = $data;
            
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée";
				}
			}
			
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "impossible de se connecter au flux";
			
		}
            
		return $ret;
    }

    /**
     * Récupère les attestations A036
     * 
     * @param integer $rn "Numéro de registre national"
     */
    public function getArttestationsA036($rn, $dateDebut = '', $dateFin = '', $langue="fr", $nextAnswerReference = '')
    {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Recherche de la période
    	if (empty($dateDebut)) {
    		if (empty($dateFin)) {
    			$dateFin = new DateTime(date('Y') . "-12-31");
    			
    		}
    		$dateDebut = clone $dateFin;
    		$dateDebut->modify("-10 years");
    		$dateDebut->modify("+1 year");
    		
    	} 
		else {
    		$dateDebut = DateTime::createFromFormat ("d/m/Y", $dateDebut);
    		
    		if (empty($dateFin)) {
    			$dateFin = clone $dateDebut;
    			$dateFin->modify("+10 years");
    			$dateFin->modify("-1 year");
    			 
    		} else {
    			$dateFin = DateTime::createFromFormat ("d/m/Y", $dateFin);
    		}
    	}
		// Récupération du RequestContext dans une variable intermédiaire
		$xml_arguments = $this->arguments;

		// Récupération d'infos dans le RequestContext car elle doit être passées une seconde
		// fois dans la partie ServiceRequest
		preg_match_all('/<Reference>(.*?)<\/Reference>/s', $xml_arguments, $xml_uniqueReference);
		$xml_uniqueReference = $xml_uniqueReference[1][0];
		preg_match_all('/<UserID>(.*?)<\/UserID>/s', $xml_arguments, $xml_authorizedUser_userID);
		$xml_authorizedUser_userID = $xml_authorizedUser_userID[1][0];
		preg_match_all('/<Email>(.*?)<\/Email>/s', $xml_arguments, $xml_authorizedUser_email);
		$xml_authorizedUser_email = $xml_authorizedUser_email[1][0];
		preg_match_all('/<MatrixID>(.*?)<\/MatrixID>/s', $xml_arguments, $xml_authorizedUser_matrixID);
		$xml_authorizedUser_matrixID = $xml_authorizedUser_matrixID[1][0];
		preg_match_all('/<MatrixSubID>(.*?)<\/MatrixSubID>/s', $xml_arguments, $xml_authorizedUser_matrixSubID);
		$xml_authorizedUser_matrixSubID = $xml_authorizedUser_matrixSubID[1][0];
    		
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$xml_arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASL036</ServiceId>";
 		$xml .=			"<Version>20060315</Version>";
		$xml .=			"<ns1:L036RequestReply xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/L036'>";

		if(!empty($nextAnswerReference)){
			$xml .=				"<ns1:L036 processType='L'>";
			$xml .=					"<ns1:Request>";
			$xml .=						"<ns1:NextAnswerReference>" . $nextAnswerReference . "</ns1:NextAnswerReference>";
			$xml .=					"</ns1:Request>";
			$xml .=				"</ns1:L036>";
		}
		else{
			$xml .=				"<ns1:L036 processType='L'/>";
		}
		$xml .=				"<ns1:UniqueReference>" . $xml_uniqueReference . "</ns1:UniqueReference>";
 		$xml .=				"<ns1:INSS>" . $rn . "</ns1:INSS>";
 		$xml .=				"<ns1:Period>";
 		$xml .=					"<ns1:BeginDate>" . $dateDebut->format("Y-m-d") . "</ns1:BeginDate>";
 		$xml .=					"<ns1:EndDate>" . $dateFin->format("Y-m-d") . "</ns1:EndDate>";
 		$xml .=				"</ns1:Period>";
		$xml .=				"<ns1:AuthorizedUser>";
		$xml .=					"<UserID>" . $xml_authorizedUser_userID . "</UserID>";
		$xml .=					"<Email>" . $xml_authorizedUser_email . "</Email>";
		$xml .=					"<MatrixID>" . $xml_authorizedUser_matrixID . "</MatrixID>";
		$xml .=					"<MatrixSubID>" . $xml_authorizedUser_matrixSubID . "</MatrixSubID>";
		$xml .=				"</ns1:AuthorizedUser>";
 		$xml .=			"</ns1:L036RequestReply>";
 		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
            
		// Gestion des valeurs de retour
		$ret = array();
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
            
		try {
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
			$nextAnswerReference = "";
			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$diagnostique = explode("|", $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0]);
				$ret['message'] = $diagnostique[0];
			} else {
				
				$nextAnswerReference = (string) $simpleXml->ServiceReply->children("ns3", true)->L036RequestReply->L036->AnswerOK->NextAnswerReference;
				$attestations = $simpleXml->ServiceReply->children("ns3", true)->L036RequestReply->L036->AnswerOK->A036;
				
				if (count($attestations)) {
					$ret['error'] = false;
					$ret['message'] = "";
					$ret['data'] = array();
					$ret['data']['nextAnswerReference'] =  $nextAnswerReference;
					foreach($attestations as $attestation) {
						$ret['data']['attestations'][] = array(
							'RecentAnswer' => (string) $attestation->RecentAnswer,
							'OcmwCpas' => (int) $attestation->OcmwCpas,
							'AttestationStatus' => (string) $attestation->Attestation->AttestationIdentification->AttestationStatus,
							'AttestationID' => (string) $attestation->Attestation->AttestationIdentification->AttestationID,
							'UpdateAttestationID' => (string) $attestation->Attestation->AttestationIdentification->UpdateAttestationID,
							'CreationDate' => new DateTime( (string) $attestation->Attestation->AttestationIdentification->CreationDate ),
							'ValidityPeriod' => array(
								'BeginDate' => new DateTime( (string) $attestation->Attestation->Details->ValidityPeriod->BeginDate ),
								'EndDate' => new DateTime( (string) $attestation->Attestation->Details->ValidityPeriod->EndDate )
							),
							'CategoryCode' => (int) $attestation->Attestation->Details->CategoryCode							
						);
					}
					$ret['data'] = array_reverse($ret['data']);
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée.";
				}
			}
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux. $e";
			
		}
        foreach ($ret['data']['attestations'] as $key => $row) {

			
			$date_debut[$key]  = $row['ValidityPeriod']['BeginDate'];
			$date_fin[$key]  = $row['ValidityPeriod']['EndDate'];
			$date_creation[$key] = $row['CreationDate'];

		}

			array_multisort($date_debut, SORT_ASC, $date_fin, SORT_ASC, $date_creation, SORT_DESC, $ret['data']['attestations']); 
			
		return $ret;
	}
	
	/**
	 * Récupère les informations Piis
	 *
	 * @param string $rn
	 * @return array
	 */
	public function getPiis($rn)
	{
		
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    		
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>OCMWCPASListOfAttestations</ServiceId>";
 		$xml .=			"<Version>20080317</Version>";
		$xml .=			"<ns1:ListOfAttestationsRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAttests' xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>";
 		$xml .=				"<ns1:SocialSecurityUser>" . $rn . "</ns1:SocialSecurityUser>";
 		$xml .=				"<ns1:RequestType>GPMI_PIIS</ns1:RequestType>";
 		$xml .=			"</ns1:ListOfAttestationsRequest>";
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
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$diagnostique = explode("|", $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->children("ns2", true)->Detail->children("ns2", true)->Diagnostic[0]);
				$ret['message'] = $diagnostique[0];
            
			} else {
				$listeAttestationsXml = $simpleXml->ServiceReply->children("ns3", true)->ListOfAttestationsReply;

				if (isset($listeAttestationsXml)) {
					$ret['error'] = false;
					$ret['message'] = "";

					$data = new stdClass(); 

					// Infos du PIIS
					if (isset($listeAttestationsXml->GpmiPiis)) {
						$attributs = $listeAttestationsXml->GpmiPiis->attributes();
						
						$data->GpmiPiis = new stdClass();
							$data->GpmiPiis->hasAttestation = (boolean) false;
							if ($attributs["hasAttestation"] == "true") {
								$data->GpmiPiis->hasAttestation = (boolean) true;

							}

						$data->GpmiPiis->period = new stdClass();
							if(isset($listeAttestationsXml->GpmiPiis->period)){
								$data->GpmiPiis->period->StartDate = (string) $listeAttestationsXml->GpmiPiis->period->children("", true)->StartDate[0];
							}
							else{
								$data->GpmiPiis->period->StartDate = "";
							}
							if(isset($listeAttestationsXml->GpmiPiis->period)){
								$data->GpmiPiis->period->EndDate = (string) $listeAttestationsXml->GpmiPiis->period->children("", true)->EndDate[0];
							}
							else{
								$data->GpmiPiis->period->EndDate = "";
							}
							
						$data->GpmiPiis->prolongationPeriod = new stdClass();
							if(isset($listeAttestationsXml->GpmiPiis->prolongationPeriod)){
								$data->GpmiPiis->prolongationPeriod->StartDate = (string) $listeAttestationsXml->GpmiPiis->prolongationPeriod->children("", true)->StartDate[0];
							}
							else{
								$data->GpmiPiis->prolongationPeriod->StartDate = "";
							}
							if(isset($listeAttestationsXml->GpmiPiis->prolongationPeriod)){
								$data->GpmiPiis->prolongationPeriod->EndDate = (string) $listeAttestationsXml->GpmiPiis->prolongationPeriod->children("", true)->EndDate[0];
							}
							else{
								$data->GpmiPiis->prolongationPeriod->EndDate = "";
							}
							
							
					}
					$data->Attestations = array();

					$i = 0;
					//$attestation = $listeAttestationsXml->Attestation[0];
					foreach( $listeAttestationsXml->Attestation as $attestation){
							$attestationData = new stdClass();	
					// Infos attestations

							$attestationData->SocialSecurityUser = (string) $attestation->SocialSecurityUser;
							$attestationData->CPAS_KBOBCE_code = (int) $attestation->CPAS_KBOBCE_code;
							$attestationData->EntryDate = (string) $attestation->EntryDate;
							$attestationData->AttestType = new stdClass();
							$attestationData->AttestType->Code = (string) $attestation->AttestType->Code;
							$attestationData->AttestType->Description = new stdClass();
							$description = explode("/", (string) $attestation->AttestType->Description);
							$attestationData->AttestType->Description->fr = rtrim($description[0]);
							$attestationData->AttestType->Description->nl = ltrim($description[1]);
							$attestationData->FormType = new stdClass();
							$attestationData->FormType->Code = (string) $attestation->FormType->Code;
							$attestationData->FormType->Description = new stdClass();
							$description = explode("/", (string) $attestation->FormType->Description);
							$attestationData->FormType->Description->fr = rtrim($description[0]);
							$attestationData->FormType->Description->nl = ltrim($description[1]);
							$attestationData->Duration = new stdClass();
							$attestationData->Duration->Days = (int) $attestation->Duration->Days;
							$attestationData->Duration->Weeks = (int) $attestation->Duration->Weeks;
							$attestationData->Duration->Months = (int) $attestation->Duration->Months;
							$attestationData->DecisionDate = (string) $attestation->DecisionDate;
							$attestationData->Reference = (int) $attestation->Reference;
							$attestationData->Status = (int) $attestation->Status;
							$attestationData->RelationType = new stdClass();
							$attestationData->RelationType->Code = (string) $attestation->RelationType->Code;
							$attestationData->RelationType->Description = new stdClass();
							$description = explode("/", (string) $attestation->RelationType->Description);
							$attestationData->RelationType->Description->fr = rtrim($description[0]);
							$attestationData->RelationType->Description->nl = ltrim($description[1]);
							$data->Attestations[$i] = $attestationData;
							$i++;
					}
						
						
						$ret['data'] = $data;
					
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée";
				}

			}
			
		} catch (Exception $e) {
			$ret['error'] = true;
			$ret['message'] = "impossible de se connecter au flux";
			
		}
            
		return $ret;
	}
}