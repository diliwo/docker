<?php

require_once realpath(dirname(__FILE__)) . '/old_flux.php';
require_once realpath(dirname(__FILE__)) . '/../../integration.php';

class ManageAccessFlux extends OldFlux
{
	const CODE_DOSSIER_EN_COURS = 1;
	const CODE_MINIMEX = 2;
	const CODE_EQUIVALENT_MINIMEX = 3;
	const CODE_AUTRE_AIDE = 4;
	const CODE_SANS_DOMICILE = 5;
	const CODE_ARTICLE_60 = 6;
	const CODE_FOND_MAZOUT = 40;
	
	const CODE_RIS = 2;
	const CODE_EQUIVALENT_RIS = 3;
	const CODE_SANS_AIDE = 5;
	
	public function estIntegre($rn, $nomFamille, $dateNaissance)
    {
    	$today = date('d/m/Y');
    	if (count($this->getIntegrationsArray($rn, $nomFamille, $dateNaissance, $today, $today)) == 0) {
    		return false;
    		
    	} else {
    		return true;
    		
    	}
	}
    public function estIntegreEnCours($rn, $nomFamille, $dateNaissance)
    {
        $today = date('d/m/Y');
        $integrations = $this->getIntegrationsArray($rn, $nomFamille, $dateNaissance, $today, $today);
        foreach ($integrations as $integration) {
            if (($integration['code_qualite'] == ManageAccessFlux::CODE_DOSSIER_EN_COURS) && ($integration['numero_organisation'] == $this->numeroOrganisation)) {
                return true;
            }
        }

        return false;
    }
	
	public function getIntegrations($rn, $nomFamille, $dateNaissance, $dateDebut='', $dateFin='', $codeQualite=self::CODE_DOSSIER_EN_COURS) {
		// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Remplacement des caractères spéciaux pour le nom de famille
        $nomFamille = mb_strtolower($nomFamille, 'UTF-8');
        $nomFamille = str_replace(
            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ',)
            ,
            array( 'a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',)
            ,
            $nomFamille
        );
        $nomFamille = mb_strtoupper($nomFamille, 'UTF-8');
    	
    	// Reformatage des dates
    	$dateTemp = explode("/", $dateNaissance);
    	$dateNaissance = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	// Si date_debut est vide alors on prend la date d'aujourd'hui comme réference
		if (empty($dateDebut)) {
			$dateDebut = date('Y-m-d');
		} else {
			$dateTemp = explode("/", $dateDebut);
			$dateDebut = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
		}
		
		// Génération du XML
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=	"<ServiceRequest>";
		$xml .=		"<ServiceId>OCMWCPASManageAccess</ServiceId>";
		$xml .=		"<Version>20050930</Version>";
		$xml .= 		"<ns1:ManageAccessRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAccess'>";
		$xml .=			"<ns1:SSIN>".$rn."</ns1:SSIN>";
		$xml .=			"<ns1:Purpose>".$codeQualite."</ns1:Purpose>";
		$xml .=			"<ns1:Period>";
		$xml .=				"<ns2:StartDate xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateDebut."</ns2:StartDate>";
		if (!empty($dateFin)) {
			$dateTemp = explode("/", $dateFin);
			$dateFin = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
			$xml .=	"<ns3:EndDate xmlns:ns3='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateFin."</ns3:EndDate>";
		}
		$xml .=			"</ns1:Period>";
		$xml .=			"<ns1:Action>LIST</ns1:Action>";
		$xml .=			"<ns1:Sector>17</ns1:Sector>";
		$xml .=			"<ns1:QueryRegister>SECONDARY</ns1:QueryRegister>";
		$xml .=				"<ns1:ProofOfAuthentication>";
		$xml .=					"<ns1:PersonData>";
		$xml .=						"<ns1:LastName>".$nomFamille."</ns1:LastName>";
		$xml .=						"<ns1:BirthDate>".$dateNaissance."</ns1:BirthDate>";
		$xml .=					"</ns1:PersonData>";
		$xml .=				"</ns1:ProofOfAuthentication>";
		$xml .= 		"</ns1:ManageAccessRequest>";
		$xml .=	"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
        
        try {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
        	$dom = new DomDocument();
			$dom->loadXML(utf8_encode($res));
				
			$codeErreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
			if ($codeErreur > 1) {
				return array();
				
			} else {
				$integrations = $dom->getElementsByTagName('Registrations');
				
				foreach ($integrations as $i=>$integration) {
					$dateTemp = new Datetime($integration->getElementsByTagName('StartDate')->item(0)->nodeValue);
					$tab['date_debut'] = $dateTemp->format('d/m/Y');
					$dateTemp = new Datetime($integration->getElementsByTagName('EndDate')->item(0)->nodeValue);
					$tab['date_fin'] = $dateTemp->format('d/m/Y');
					$tab['numero_organisation'] = $integration->getElementsByTagName('OrgUnit')->item(0)->nodeValue;
					$tab['code_qualite'] = $integration->getElementsByTagName('Purpose')->item(0)->nodeValue;
					$tab['type'] = $integration->getElementsByTagName('Register')->item(0)->nodeValue;
					
					$ret[$i] = new Integration($tab);
				}
				usort($ret, array("Integration", "compareDecroissant"));
	
				return $ret;
			}
				
		} catch (Exception $e) {
			return array();
	
		}
	}
    
    /**
     * Récupère les intégrations sous forme de tableau (format des date: d/m/Y)
     * 
     * @param unknown $rn
     * @param unknown $nomFamille
     * @param unknown $dateNaissance
     * @param string $dateDebut
     * @param string $dateFin
     * @param unknown $codeQualite
     * 
     * @return NULL|multitype:|unknown
     */
	public function getIntegrationsArray($rn, $nomFamille, $dateNaissance, $dateDebut='', $dateFin='', $codeQualite=self::CODE_DOSSIER_EN_COURS) {
		// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Remplacement des caractères spéciaux pour le nom de famille
    	$nomFamille = mb_strtolower($nomFamille, 'UTF-8');
        $nomFamille = str_replace(
            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ',)
            ,
            array( 'a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',)
            ,
            $nomFamille
        );
        $nomFamille = mb_strtoupper($nomFamille, 'UTF-8');
    	
    	// Reformatage des dates
    	$dateTemp = explode("/", $dateNaissance);
    	$dateNaissance = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	// Si date_debut est vide alors on prend la date d'aujourd'hui comme réference
		if (empty($dateDebut)) {
			$dateDebut = date('Y-m-d');
		} else {
			$dateTemp = explode("/", $dateDebut);
			$dateDebut = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
		}
		
		// Génération du XML
		$xml = "";
		$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
		$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
		$xml .=	$this->arguments;
		$xml .=	"<ServiceRequest>";
		$xml .=		"<ServiceId>OCMWCPASManageAccess</ServiceId>";
		$xml .=		"<Version>20050930</Version>";
		$xml .= 		"<ns1:ManageAccessRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAccess'>";
		$xml .=			"<ns1:SSIN>".$rn."</ns1:SSIN>";
		$xml .=			"<ns1:Purpose>".$codeQualite."</ns1:Purpose>";
		$xml .=			"<ns1:Period>";
		$xml .=				"<ns2:StartDate xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateDebut."</ns2:StartDate>";
		if (!empty($dateFin)) {
			$dateTemp = explode("/", $dateFin);
			$dateFin = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
			$xml .=	"<ns3:EndDate xmlns:ns3='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateFin."</ns3:EndDate>";
		}
		$xml .=			"</ns1:Period>";
		$xml .=			"<ns1:Action>LIST</ns1:Action>";
		$xml .=			"<ns1:Sector>17</ns1:Sector>";
		$xml .=			"<ns1:QueryRegister>SECONDARY</ns1:QueryRegister>";
		$xml .=				"<ns1:ProofOfAuthentication>";
		$xml .=					"<ns1:PersonData>";
		$xml .=						"<ns1:LastName>".$nomFamille."</ns1:LastName>";
		$xml .=						"<ns1:BirthDate>".$dateNaissance."</ns1:BirthDate>";
		$xml .=					"</ns1:PersonData>";
		$xml .=				"</ns1:ProofOfAuthentication>";
		$xml .= 		"</ns1:ManageAccessRequest>";
		$xml .=	"</ServiceRequest>";
		$xml .= "</SSDNRequest>";
        
        try {
            $res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
        	$dom = new DomDocument();
			$dom->loadXML(utf8_encode($res));
				
			$codeErreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
			if ($codeErreur > 1) {
				return array();
				
			} else {
				$integrations = $dom->getElementsByTagName('Registrations');
				
				foreach ($integrations as $i=>$integration) {
					$ret[$i]['code_qualite'] = $integration->getElementsByTagName('Purpose')->item(0)->nodeValue;
					$dateTemp = new Datetime($integration->getElementsByTagName('StartDate')->item(0)->nodeValue);
					$ret[$i]['date_debut'] = $dateTemp->format('d/m/Y');
					$dateTemp = new Datetime($integration->getElementsByTagName('EndDate')->item(0)->nodeValue);
					$ret[$i]['date_fin'] = $dateTemp->format('d/m/Y');
					$ret[$i]['numero_organisation'] = $integration->getElementsByTagName('OrgUnit')->item(0)->nodeValue;
					$ret[$i]['type'] = $integration->getElementsByTagName('Register')->item(0)->nodeValue;
				}

				return $ret;
			}
			
        } catch (Exception $e) {
            return array();
            
        }
    }
    
    /**
     * Permet d'intéger la personne à la BCSS
     * 
     * @param unknown $rn
     * @param unknown $nomFamille
     * @param unknown $dateNaissance
     * @param string $dateDebut
     * @param string $dateFin
     * @param unknown $codeQualite
     * @return NULL|boolean|unknown
     */
    public function integrer($rn, $nomFamille, $dateNaissance, $dateDebut='', $dateFin='', $codeQualite=self::CODE_DOSSIER_EN_COURS) {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Remplacement des caractères spéciaux pour le nom de famille
    	$nomFamille = mb_strtolower($nomFamille, 'UTF-8');
        $nomFamille = str_replace(
            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ',)
            ,
            array( 'a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',)
            ,
            $nomFamille
        );
        $nomFamille = mb_strtoupper($nomFamille, 'UTF-8');
    	 
    	// Reformatage des dates
    	$dateTemp = explode("/", $dateNaissance);
    	$dateNaissance = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	// Si date_debut est vide alors on prend la date d'aujourd'hui comme réference
    	if (empty($dateDebut)) {
    		$dateDebut = date('Y-m-d');
    	} else {
    		$dateTemp = explode("/", $dateDebut);
    		$dateDebut = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	}
    
    	// Génération du XML
    	$xml = "";
    	$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
    	$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
    	$xml .=	$this->arguments;
    	$xml .=	"<ServiceRequest>";
    	$xml .=		"<ServiceId>OCMWCPASManageAccess</ServiceId>";
    	$xml .=		"<Version>20050930</Version>";
    	$xml .= 		"<ns1:ManageAccessRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAccess'>";
    	$xml .=			"<ns1:SSIN>".$rn."</ns1:SSIN>";
    	$xml .=			"<ns1:Purpose>".$codeQualite."</ns1:Purpose>";
    	$xml .=			"<ns1:Period>";
    	$xml .=				"<ns2:StartDate xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateDebut."</ns2:StartDate>";
    	if (!empty($dateFin)) {
    		$dateTemp = explode("/", $dateFin);
    		$dateFin = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    		$xml .=			"<ns3:EndDate xmlns:ns3='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateFin."</ns3:EndDate>";
    	}
    	$xml .=			"</ns1:Period>";
    	$xml .=			"<ns1:Action>REGISTER</ns1:Action>";
    	$xml .=			"<ns1:Sector>17</ns1:Sector>";
    	$xml .=			"<ns1:QueryRegister>SECONDARY</ns1:QueryRegister>";
    	$xml .=				"<ns1:ProofOfAuthentication>";
    	$xml .=					"<ns1:PersonData>";
    	$xml .=						"<ns1:LastName>".$nomFamille."</ns1:LastName>";
    	$xml .=						"<ns1:BirthDate>".$dateNaissance."</ns1:BirthDate>";
    	$xml .=					"</ns1:PersonData>";
    	$xml .=				"</ns1:ProofOfAuthentication>";
    	$xml .= 		"</ns1:ManageAccessRequest>";
    	$xml .=	"</ServiceRequest>";
    	$xml .= "</SSDNRequest>";

    	try {
    		$res = $this->soapClient->sendXML(new SoapParam($xml, 'xmlString'));
    		$dom = new DomDocument();
    		$dom->loadXML(utf8_encode($res));
    
    		$codeErreur = $dom->getElementsByTagName('ReturnCode')->item(0)->nodeValue;
    		if ($codeErreur > 1) {
    			return false;
    
    		} else {
    			$integrations = $dom->getElementsByTagName('Registrations');
    			
    			foreach ($integrations as $i=>$integration) {
    				$ret[$i]['code_qualite'] = $integration->getElementsByTagName('Purpose')->item(0)->nodeValue;
    				$dateTemp = new Datetime($integration->getElementsByTagName('StartDate')->item(0)->nodeValue);
    				$ret[$i]['date_debut'] = $dateTemp->format('d/m/Y');
    				$dateTemp = new Datetime($integration->getElementsByTagName('EndDate')->item(0)->nodeValue);
    				$ret[$i]['date_fin'] = $dateTemp->format('d/m/Y');
    				$ret[$i]['numero_organisation'] = $integration->getElementsByTagName('OrgUnit')->item(0)->nodeValue;
    				$ret[$i]['type'] = $integration->getElementsByTagName('Register')->item(0)->nodeValue;
    			}
    
    			return $ret;
    		}
    	} catch (Exception $e) {
    		return false;
    
    	}
    }
    
    //TODO
    public function desintegrer($rn, $nomFamille, $dateNaissance, $dateDebut='', $dateFin='', $codeQualite=self::CODE_DOSSIER_EN_COURS) {
    	// Vérification de la bonne connexion au SOAP
    	if (is_null($this->soapClient))
    		return null;
    	
    	// Remplacement des caractères spéciaux pour le nom de famille
    	$nomFamille = mb_strtolower($nomFamille, 'UTF-8');
        $nomFamille = str_replace(
            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ',)
            ,
            array( 'a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n',)
            ,
            $nomFamille
        );
        $nomFamille = mb_strtoupper($nomFamille, 'UTF-8');
    	 
    	// Reformatage des dates
    	$dateTemp = explode("/", $dateNaissance);
    	$dateNaissance = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	// Si date_debut est vide alors on prend la date d'aujourd'hui comme réference
    	if (empty($dateDebut)) {
    		$dateDebut = date('Y-m-d');
    	} else {
    		$dateTemp = explode("/", $dateDebut);
    		$dateDebut = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    	}
    	
    	// Génération du XML
    	$xml = "";
    	$xml .= "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>";
    	$xml .= "<SSDNRequest xmlns='http://www.ksz-bcss.fgov.be/XSD/SSDN/Service'>";
    	$xml .=	$this->arguments;
    	$xml .=	"<ServiceRequest>";
    	$xml .=		"<ServiceId>OCMWCPASManageAccess</ServiceId>";
    	$xml .=		"<Version>20050930</Version>";
    	$xml .= 		"<ns1:ManageAccessRequest xmlns:ns1='http://www.ksz-bcss.fgov.be/XSD/SSDN/OCMW_CPAS/ManageAccess'>";
    	$xml .=			"<ns1:SSIN>".$rn."</ns1:SSIN>";
    	$xml .=			"<ns1:Purpose>".$codeQualite."</ns1:Purpose>";
    	$xml .=			"<ns1:Period>";
    	$xml .=				"<ns2:StartDate xmlns:ns2='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateDebut."</ns2:StartDate>";
    	if (!empty($dateFin)) {
    		$dateTemp = explode("/", $dateFin);
    		$dateFin = $dateTemp[2] . "-" . $dateTemp[1] . "-" . $dateTemp[0];
    		$xml .=			"<ns3:EndDate xmlns:ns3='http://www.ksz-bcss.fgov.be/XSD/SSDN/Common'>".$dateFin."</ns3:EndDate>";
    	}
    	$xml .=			"</ns1:Period>";
    	$xml .=			"<ns1:Action>UNREGISTER</ns1:Action>";
    	$xml .=			"<ns1:Sector>17</ns1:Sector>";
    	$xml .=			"<ns1:QueryRegister>SECONDARY</ns1:QueryRegister>";
    	$xml .=				"<ns1:ProofOfAuthentication>";
    	$xml .=					"<ns1:PersonData>";
    	$xml .=						"<ns1:LastName>".$nomFamille."</ns1:LastName>";
    	$xml .=						"<ns1:BirthDate>".$dateNaissance."</ns1:BirthDate>";
    	$xml .=					"</ns1:PersonData>";
    	$xml .=				"</ns1:ProofOfAuthentication>";
    	$xml .= 		"</ns1:ManageAccessRequest>";
    	$xml .=	"</ServiceRequest>";
    	$xml .= "</SSDNRequest>";
    
    	return $xml;
    }
}