<?php

require_once dirname(__FILE__) . "/base_flux.php";

class OldFlux extends BaseFlux
{
	protected $soapClient;
	protected $userId;
	protected $email;

	/**
	 * Constructeur de la classe
	 * 
	 * @param integer 	$type 		"Type de webservice: OLD ou SOA"
	 * @param array 	$config 	"Tableau des données de configuration du flux"
	 * @param string 	$env 		"Environnement de connexion: test, acpt ou prod"
	 */
	public function __construct($env, $cbeNumber, $secteur, $institution, $numeroOrganisation, $userId, $email, $langue="fr")
	{
		// On récupère la date et l'heure de maintenant avec le timezone correct
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone("Europe/Brussels"));

		parent::__construct($env, $cbeNumber, $secteur, $institution, $numeroOrganisation, $langue);
		$this->type = BaseFlux::TYPE_OLD;
		$this->userId = $userId;
		$this->email = $email;
		$this->arguments = 
			"<RequestContext>" .
				"<AuthorizedUser>" .
					"<UserID>" . str_pad($this->userId, 11, "0") . "</UserID>" .
					"<Email>" . $this->email . "</Email>" .
					"<OrgUnit>" . $this->cbeNumber . "</OrgUnit>" .
					"<MatrixID>" . $this->secteur . "</MatrixID>" .
					"<MatrixSubID>" . $this->institution . "</MatrixSubID>" .
				"</AuthorizedUser>" .
				"<Message>" .
					"<Reference>" . $this->lectureReference() . "</Reference>" .
					"<TimeRequest>" . $now->format("Ymd") . "T" . $now->format("His") . "</TimeRequest>" .
					"<Language>fr</Language>" .
				"</Message>" .
			"</RequestContext>";

	}

	/**
	 * Destructeur
	 */
	public function __destruct()
	{
		unset($this->soapClient);
	}

	/**
	 * Connexion au web service de la BCSS
	 *
	 * @return boolean
	 */
	public function connexion($wsdl="")
	{
		if (empty($wsdl))
			$wsdl = "includes/soap/autres/" . $this->env . "/KSZBCSSWebServiceConnectorPort.wsdl";

		$testConnexion = parent::connexion();
		if ($testConnexion) {
			try {
	        	ini_set("default_socket_timeout", 15);
				$this->soapClient = new SoapClient($wsdl, array("trace" => true, "connection_timeout" => 10, "soap_version" => SOAP_1_1));
				
				return true;
				
	        } catch (Exception $e) {
				return false;
				
			}
			
		} else {
			return false;

		}

	}

	// GETTERS SOAPCLIENT
	public function getTypes()
	{
		return $this->soapClient->__getTypes();
	}
	public function getFonctions()
	{
		return $this->soapClient->__getFunctions();
	}
	public function getReponse()
	{
		return htmlentities($this->soapClient->__getLastResponse());
	}
	public function getRequete()
	{
		return htmlentities($this->soapClient->__getLastRequest());
	}
	public function getHeader()
	{
		return htmlentities($this->soapClient->__getLastRequestHeaders());
	}

}
