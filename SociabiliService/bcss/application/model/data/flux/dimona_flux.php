<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';
require_once 'includes/lib/cpas/XMLToArray.class.php';
//require_once 'dimona/activite.php';
//require_once 'dimona/entreprise.php';

class DimonaFlux extends OldFlux
{
	const CODE_ACTION_ENTREE = 1;
	const CODE_ACTION_SORTIE = 2;
	const CODE_ACTION_MODIFICATION = 3;
	const CODE_ACTION_ANNULATION = 4;
	
    /**
     * 
     * Récupère les activités de la personne 
     * 
     * @param integer $rn
     * @param string $dateDebut
     * @param string $dateFin
     * @param integer $nbReponses
     */
	public function getActivites($rn, $dateDebut="", $dateFin="", $nbReponses=32, $nbPremiereLigne=0, $numTicket=0)
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
    		$dateDebut = DateTime::createFromFormat("d/m/Y", $dateDebut);
    		
    		if (empty($dateFin)) {
    			$dateFin = clone $dateDebut;
    			$dateFin->modify("+10 years");
    			$dateFin->modify("-1 day");
    			 
    		} else {
    			$dateFin = DateTime::createFromFormat("d/m/Y", $dateFin);
    		}
    	}
    	$qqch = "001";
    	
    	// XML envoyé
    	$xml  = "";
		if (($nbPremiereLigne == 0) && ($numTicket == 0)) {
			$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
			$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
			$xml .=		$this->arguments;
			$xml .=		"<ServiceRequest>";
			$xml .=			"<ServiceId>XMLite</ServiceId>";
			$xml .=			"<Version>20051206</Version>";
			$xml .=			"<ns1:Message xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/Message'>";
			$xml .=				"<ns1:Header>";
			$xml .=					"<ns1:ClassicPrefix>U62NA1017001" . $this::lectureReference() . $this->userId . "O0C".$rn."L950                                ".date('ymdHi')."M03S000100" . $dateDebut->format("Ymd") . $dateFin->format("Ymd") ."19950101".date('Ymd')."      </ns1:ClassicPrefix>";
			$xml .=				"</ns1:Header>";
			$xml .=				"<ns1:Data>";
			$xml .= 				"<ns1:XML>";
			$xml .=						"<L950 processType='L' version='001' xmlns='http://www.ksz-bcss.fgov.be/XmlSchema'>";
			$xml .=							"<Request>";
			$xml .=								"<NaturalPerson>";
			$xml .=									"<INSS>" . $rn ."</INSS>";
			$xml .=								"</NaturalPerson>";
			$xml .=								"<SearchPeriod>";
			$xml .=									"<BeginDate>1995-01-01</BeginDate>";
			$xml .=									"<EndDate>" . date("Y-m-d") . "</EndDate>";
			$xml .=								"</SearchPeriod>";
			$xml .=								"<ActiveWorker>1</ActiveWorker>";
			$xml .=								"<CanceledContract>0</CanceledContract>";
			$xml .=								"<NbrOfAnswer>" . $nbReponses . "</NbrOfAnswer>";
			$xml .=							"</Request>";
			$xml .= 					"</L950>";
			$xml .= 				"</ns1:XML>";
			$xml .=				"</ns1:Data>";
			$xml .=			"</ns1:Message>";
			$xml .=		"</ServiceRequest>";
			$xml .= "</SSDNRequest>";
		} else {
			$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
			$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
			$xml .=		$this->arguments;
			$xml .=		"<ServiceRequest>";
			$xml .=			"<ServiceId>XMLite</ServiceId>";
			$xml .=			"<Version>20051206</Version>";
			$xml .=			"<ns1:Message xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/Message'>";
			$xml .=				"<ns1:Header>";
			$xml .=					"<ns1:ClassicPrefix>U62NA1017001" . $this::lectureReference() . $this->userId . "O0C" . $rn . "L950                                " . date('ymdHi') . "M03S000100" . $dateDebut->format('Ymd') . $dateFin->format('Ymd') . "                      </ns1:ClassicPrefix>";
			$xml .=				"</ns1:Header>";
			$xml .=				"<ns1:Data>";
			$xml .= 				"<ns1:XML>";
			$xml .=						"<L950 processType='L' version='001' xmlns='http://www.ksz-bcss.fgov.be/XmlSchema'>";
			$xml .=							"<Request>";
			$xml .=								"<NaturalPerson>";
			$xml .=									"<INSS>" . $rn ."</INSS>";
			$xml .=								"</NaturalPerson>";
			$xml .=								"<ActiveWorker>1</ActiveWorker>";
			$xml .=								"<CanceledContract>0</CanceledContract>";
			$xml .=								"<NbrOfAnswer>" . $nbReponses . "</NbrOfAnswer>";
			$xml .=								"<Scrolling>";
			$xml .=									"<FirstLineNbr>" . $nbPremiereLigne . "</FirstLineNbr>";
			$xml .=									"<Ticket>" . $numTicket .  "</Ticket>";
			$xml .=								"</Scrolling>";
			$xml .=							"</Request>";
			$xml .= 					"</L950>";
			$xml .= 				"</ns1:XML>";
			$xml .=				"</ns1:Data>";
			$xml .=			"</ns1:Message>";
			$xml .=		"</ServiceRequest>";
			$xml .= "</SSDNRequest>";
		}
	
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
		try
		{
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
		
			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->Detail->Diagnostic[0];
		
			} else {
				if (isset($simpleXml->ServiceReply->children("ns3", true)->Message->Data)) {
					$nbActivites = (int) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->L950->AnswerOK->Reference->NbrOfAvailableAnswer;
					$nbActivitesIncluses = (int) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->L950->AnswerOK->Reference->NbrOfIncludedAnswer;
					$numeroPremiereLigne = (string) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->L950->AnswerOK->Reference->NextScrolling->FirstLineNbr;
					$ticket = (string) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->L950->AnswerOK->Reference->NextScrolling->Ticket;
					
					$ret['error'] = false;
					$ret['nb_activites'] = $nbActivites;
					$ret['nb_activites_incluses'] = $nbActivitesIncluses;
					$ret['numero_premiere_ligne'] = $numeroPremiereLigne;
					$ret['ticket'] = $ticket;
					$ret['message'] = $nbActivitesIncluses . "/" . $nbActivites . " activité(s) visibles";
					
					$activites = $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->L950->AnswerOK->Activity;
					$i=0;
					if (count($activites) > 0) {
						foreach ($activites as $activite) {
							$ret['data'][$i]->Employer->FirmID->NLOSSRegistrationNbr = (string) $activite->Employer->FirmID->NLOSSRegistrationNbr;
							$ret['data'][$i]->Employer->FirmID->CompanyID = (string) $activite->Employer->FirmID->CompanyID;
							$ret['data'][$i]->Employer->PLAIndicator = (int) $activite->Employer->PLAIndicator;
							
							$ret['data'][$i]->NaturalPerson->INSS = (string) $activite->NaturalPerson->INSS;
							$ret['data'][$i]->NaturalPerson->Name = (string) $activite->NaturalPerson->Name;
							$ret['data'][$i]->NaturalPerson->FirstName = (string) $activite->NaturalPerson->FirstName;
							$ret['data'][$i]->NaturalPerson->OriolusValidationCode = (int) $activite->NaturalPerson->OriolusValidationCode;
							$ret['data'][$i]->NaturalPerson->BirthDate = (string) $activite->NaturalPerson->BirthDate;
							$ret['data'][$i]->NaturalPerson->Sex = (int) $activite->NaturalPerson->Sex;
							$ret['data'][$i]->NaturalPerson->NationalityCode = (int) $activite->NaturalPerson->NationalityCode;
							
							$ret['data'][$i]->Worker->OccupationPeriod->BeginDate = (string) $activite->Worker->OccupationPeriod->BeginDate;
							if (isset($activite->Worker->OccupationPeriod->EndDate))
								$ret['data'][$i]->Worker->OccupationPeriod->EndDate = (string) $activite->Worker->OccupationPeriod->EndDate;
							$ret['data'][$i]->Worker->JointCommissionNbr = (int) $activite->Worker->JointCommissionNbr;
							
							$typeTravailleur = trim( (string) $activite->Worker->KindOfWorker );
							if (!empty($typeTravailleur))
								$ret['data'][$i]->Worker->KindOfWorker = $typeTravailleur;
							
							$ret['data'][$i]->Worker->DimonaNbr = (string) $activite->Worker->DimonaNbr;
							$ret['data'][$i]->Worker->ValidityStatus = (int) $activite->Worker->ValidityStatus;
							$ret['data'][$i]->Worker->LastDimonaAction = (int) $activite->Worker->LastDimonaAction;

							if (isset($activite->InterimUser)) {
								$ret['data'][$i]->InterimUser->CompanyID = (int) $activite->InterimUser->CompanyID;
								if (!empty($activite->InterimUser->name))
									$ret['data'][$i]->InterimUser->name = (string) $activite->InterimUser->name;
							}
							
							$i++;
						}
					} else {
						$ret['error'] = true;
						$ret['message'] = "Aucune donnée dimona disponible";
					}
					
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée dimona disponible";
					
				}
				
			}
		}
		catch (Exception $e)
		{
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";
		}
		
		return $ret;
    }
	
    /**
     * 
     * Permet de récupérer les données d'une entreprise grâce à son immatriculation
     * 
     * @param integer $immatriculationEntreprise
     */
    public function getEntreprise($immatriculationEntreprise)
    {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	$retour = array("CODE_ERREUR" => "", "ENTREPRISE" => null);
    	
    	// XML envoyé
		$xml  = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=		$this->arguments;
		$xml .=		"<ServiceRequest>";
		$xml .=			"<ServiceId>XMLite</ServiceId>";
		$xml .=			"<Version>20051206</Version>";
		$xml .=			"<ns1:Message xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/Message'>";
		$xml .=				"<ns1:Header>";
		$xml .=					"<ns1:ClassicPrefix>U62NA1017001".$this->lectureReference() . $this->userId . "O0L           A701                                ".date('ymdHi')."M03S0                                           </ns1:ClassicPrefix>";
		$xml .=				"</ns1:Header>";
		$xml .=				"<ns1:Data>";
		$xml .= 				"<ns1:XML>";
		$xml .=						"<A701 processType='L' version='001' xmlns='http://www.ksz-bcss.fgov.be/XmlSchema'>";
		$xml .=							"<Request>";
		$xml .=								"<Employer>";
		$xml .=									"<FirmID>";
		$xml .=										"<NLOSSRegistrationNbr>".$immatriculationEntreprise."</NLOSSRegistrationNbr>";
		$xml .=									"</FirmID>";
		$xml .=								"</Employer>";
		$xml .=							"</Request>";
		$xml .= 					"</A701>";
		$xml .= 				"</ns1:XML>";
		$xml .=				"</ns1:Data>";
		$xml .=			"</ns1:Message>";
		$xml .=		"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
		
		// Gestion des valeurs de retour
		$ret['error'] = true;
		$ret['message'] = "Erreur inconnue";
		
		try
		{
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
			//$xta = new XMLToArray($res);
			//$xta->afficherEnHtml();
		
			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->Detail->Diagnostic[0];
		
			} else {
				if (isset($simpleXml->ServiceReply->children("ns3", true)->Message->Data)) {
					$ret['error'] = false;
					$ret['message'] = "";
					
					$ret['data']->NLOSSRegistrationNbr = (int) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->A701->Attestation->Employer->FirmID->NLOSSRegistrationNbr;
					$ret['data']->CompanyID = (int) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->A701->Attestation->Employer->FirmID->CompanyID;
					$ret['data']->Name = (string) $simpleXml->ServiceReply->children("ns3", true)->Message->Data->XML->children("ns4", true)->A701->Attestation->Employer->RegisteredOffice->Name;
					
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée disponible";
						
				}
		
			}
		}
		catch (Exception $e)
		{
			$ret['error'] = true;
			$ret['message'] = "Impossible de se connecter au flux";
		}
		
		return $ret;
		
    }
}