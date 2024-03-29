<?php

require_once dirname(__FILE__) . "/base_flux.php";

class SoaFlux extends BaseFlux
{
	protected $soapClient;
	protected $username;
	protected $password;

	/**
	 * Constructeur
	 *
	 * @param string $env
	 * @param integer $cbeNumber
	 * @param integer $secteur
	 * @param integer $institution
	 * @param string $username
	 * @param string $password
	 * @param string $langue
	 */
	public function __construct($env, $cbeNumber, $secteur, $institution, $baseReference, $username, $password, $langue="fr")
	{
		// On récupère la date et l'heure de maintenant avec le timezone correct
		$now = new DateTime();
		$now->setTimezone(new DateTimeZone("Europe/Brussels"));

		parent::__construct($env, $cbeNumber, $secteur, $institution, $baseReference, $langue);
		$this->type = BaseFlux::TYPE_SOA;
		$this->username = $username;
		$this->password = $password;
		$this->arguments = array(
			"informationCustomer" => array(
				"ticket" => $this->lectureReference(),
				"timetampSent" => $now->format("Y-m-d") . "T" . $now->format("H:i:s") . "Z",
				"customerIdentification" => array(
					"cbeNumber" => str_pad($this->cbeNumber, 10, "0"),
					"sector" => $this->secteur,
					"institution" => $this->institution
				)
			)
		);
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
	public function connexion($wsdl)
	{
		$testConnexion = parent::connexion();
		if ($testConnexion) {
			try {
	        	ini_set("default_socket_timeout", 15);
				$this->soapClient = new SoapClient($wsdl, array("login" => $this->username, "password" => $this->password, "trace" => true, "connection_timeout" => 10));

				 return true;
				
	        } catch (Exception $e) {
				return false;
				
			}
			
		} else {
			return false;

		}

	}

	/**
	 * Appel à une fonction du WebService
	 * @param type $fonction
	 * @param type $arguments
	 */
	public function call($fonction, $arguments=array())
	{
		try {
			$this->arguments = array_merge($this->arguments, $arguments);
			return $this->soapClient->$fonction($this->arguments);

		} catch (Exception $e) {
			return $e;
			
		}
	}

}
