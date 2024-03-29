<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';
require_once realpath(dirname(__FILE__)) . '/../../integration_hors_cpas.php';

class ReferenceManagerFacadeFlux extends OldFlux
{
	public function getIntegrationsHorsCpas($rn, $dateDebutIntegration, $dateFinIntegration, $dateDebut, $dateFin, $codeQualite, $avecDescription='true')
	{
		$integrations = array();
		$res = $this->getIntegrationsHorsCpasArray($rn, $dateDebutIntegration, $dateFinIntegration, $dateDebut, $dateFin, $codeQualite, $avecDescription);
		if ( ( isset ($res['error']))  && ($res['error'] == false) ) {
			if (count($res['data'])>0) {
				foreach ($res['data'] as $i=>$rec) {
					$dateDebut = "";
					if (isset($rec->Period->StartDate)) {
						$dateTemp = new DateTime($rec->Period->StartDate);
						$dateDebut = $dateTemp->format('d/m/Y');
					}
					$dateFin = "";
					if (isset($rec->Period->EndDate)) {
						$dateTemp = new DateTime($rec->Period->EndDate);
						$dateFin = $dateTemp->format('d/m/Y');
					}
					
					$tab['date_debut'] = $dateDebut;
					$tab['date_fin'] = $dateFin;
					$tab['numero_secteur'] = $rec->Sector;
					$tab['description_secteur'] = $rec->SectorDescriptionFr;
					$tab['code_qualite'] = $rec->QualityCode;
					$tab['description_code_qualite'] = $rec->QualityCodeDescriptionFr;
					
					$integrations[] = new IntegrationHorsCpas($tab);
					
				}
				usort($integrations, array("IntegrationHorsCpas", "compareDecroissant"));
				
			}
			
		}
		
		return $integrations;
		
	}
	public function getIntegrationsHorsCpasArray($rn, $dateDebutIntegration, $dateFinIntegration, $dateDebut, $dateFin, $codeQualite, $avecDescription='true')
	{
		// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Reformatage des dates
    	$dateTemp = explode("/", $dateDebutIntegration);
    	$dateDebutIntegration = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	$dateTemp = explode("/", $dateFinIntegration);
    	$dateFinIntegration = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	$dateTemp = explode("/", $dateDebut);
    	$dateDebut = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	$dateTemp = explode("/", $dateFin);
    	$dateFin = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
		
		// Génération du XML
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=	"<ServiceRequest>";
		$xml .=		"<ServiceId>ReferenceManager.consult</ServiceId>";
		$xml .=		"<Version>20050525</Version>";
		$xml .= 		"<ReferenceManagerRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/ReferenceManagerFacade' xmlns:common='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>";
		$xml .=				"<ConsultOtherSectorsCriteria>";
		$xml .=					"<QualityCodeRequestor>" . $codeQualite . "</QualityCodeRequestor>";
		$xml .= 				"<RequestedSsin>" . $rn . "</RequestedSsin>";
		$xml .=					"<IntegratedPeriod>";
		$xml .=						"<common:StartDate>" . $dateDebutIntegration . "</common:StartDate>";
		$xml .=						"<common:EndDate>" . $dateFinIntegration . "</common:EndDate>";
		$xml .=					"</IntegratedPeriod>";
		$xml .=					"<RequestedPeriod>";
		$xml .=						"<common:StartDate>" . $dateDebut . "</common:StartDate>";
		$xml .=						"<common:EndDate>" . $dateFin . "</common:EndDate>";
		$xml .=					"</RequestedPeriod>";
		$xml .=					"<FetchDescriptions>" . $avecDescription . "</FetchDescriptions>";
		$xml .=				"</ConsultOtherSectorsCriteria>";
		$xml .=			"</ReferenceManagerRequest>";
		$xml .=	"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
        
        try
		{
			$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
			
			/*
			echo "<pre>";
			print_r(htmlentities($xml));
			echo "</pre>";
			
			echo "<pre>";
			print_r(htmlentities($res));
			echo "</pre>";
			*/
		
			$simpleXml = new SimpleXMLElement($res);
			$codeErreur = (int) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->ReturnCode[0];
			if ($codeErreur > 0) {
				$ret['error'] = true;
				$ret['message'] = (string) $simpleXml->ServiceReply->children("ns2", true)->ResultSummary->Detail->Diagnostic[0];
		
			} else {
				$ret['error'] = false;

				if (isset($simpleXml->ServiceReply->children("ns3", true)->ReferenceManagerReply->ConsultOtherSectorsResult)) {
					$consultations = $simpleXml->ServiceReply->children("ns3", true)->ReferenceManagerReply->ConsultOtherSectorsResult->Consultation;
					$i=0;
					if (count($consultations) > 0) {
						foreach ($consultations as $consultation) {
						     
						    $ret['data'][$i] = new stdClass();
						    $ret['data'][$i]->Sector = (int) $consultation->Sector ;
							$ret['data'][$i]->QualityCode = (int) $consultation->QualityCode;
							
							$namespaces = array_keys($consultation->Period->getNamespaces(true));
							if (isset($namespaces[1])) {

							    $ret['data'][$i]->Period = new stdClass();
							    $ret['data'][$i]->Period->StartDate = (string) $consultation->Period->children($namespaces[1], true)->StartDate;

							}
							
							if (isset($namespaces[2])) {
							    
							    $ret['data'][$i]->Period = new stdClass();
							    $ret['data'][$i]->Period->EndDate = (string) $consultation->Period->children($namespaces[2], true)->EndDate;
							    
							}
								
							$ret['data'][$i]->SectorDescriptionNl = (string) $consultation->SectorDescriptionNl;
							$ret['data'][$i]->SectorDescriptionFr = (string) $consultation->SectorDescriptionFr;
							$ret['data'][$i]->QualityCodeDescriptionNl = (string) $consultation->QualityCodeDescriptionNl;
							$ret['data'][$i]->QualityCodeDescriptionFr = (string) $consultation->QualityCodeDescriptionFr;
							
							$i++;
							
						}
					} else {
						$ret['error'] = true;
						$ret['message'] = "Aucune donnée intégration hors secteur disponible";
						
					}
					
				} else {
					$ret['error'] = true;
					$ret['message'] = "Aucune donnée intégration hors secteur disponible";
					
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