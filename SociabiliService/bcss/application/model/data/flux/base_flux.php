<?php

class BaseFlux
{
	// CONSTANTES
	const TYPE_OLD = 0;
	const TYPE_SOA = 1;

	/**
	 * Type de flux: OLD(=0) ou SOA(=1)
	 *
	 * @var integer
	 */
	protected $type;
	/**
	 * Environnement du flux: prod, acpt ou test
	 *
	 * @var string
	 */
	protected $env;
	protected $cbeNumber;
	protected $secteur;
	protected $institution;
    protected $numeroOrganisation;
	protected $baseReference;
	protected $langue;
	
	/**
	 * Arguments de base à passer au flux
	 *
	 * @var array
	 */
	protected $arguments;
	
	/**
	 * Constructeur
	 *
	 * @param string $env
	 * @param integer $cbeNumber
	 * @param integer $secteur
	 * @param integer $institution
	 * @param string $langue
	 */
	public function __construct($env, $cbeNumber, $secteur, $institution, $numeroOrganisation, $langue="fr")
	{
		$this->env = $env;
		$this->cbeNumber = $cbeNumber;
		$this->secteur = $secteur;
		$this->institution = $institution;
        $this->numeroOrganisation = $numeroOrganisation;
        $this->baseReference = $numeroOrganisation . "8";
		$this->langue = $langue;
	}
	/**
	 * Destructeur
	 */
	public function __destruct()
	{
	}
	
	/**
	 * Connexion au flux de la BCSS
	 *
	 * @return boolean
	 */
	protected function connexion()
	{
		return self::testConnexion($this->env);
	}
	
	/**
	 * Méthode permettant de lire la référence actuelle et de l"incrémenter dans le fichier
	 *
	 * @return string
	 */
	protected function lectureReference()
	{
		$base = $this->baseReference;
		if (file_exists("includes/soap/reference.txt")) {
			$fp = fopen ("includes/soap/reference.txt", "r+");
			$reference = fgets ($fp, 10);
			$new_reference = $reference + 1;
			fseek ($fp, 0);
			fputs ($fp, $new_reference);
			fclose ($fp); 

		} else {
			$reference = rand(0,9);

		}
		
		for ($i=strlen($reference); $i<9; $i++)
			$base .= "0";
		
		return $base.$reference;
	}
	
	/**
	 * Méthode statique permettant de tester la connexion à la BCSS
	 *
	 * @param string $env
	 * @param string $wsdl
	 * @return boolean
	 */
	public static function testConnexion($env, $wsdl="")
	{
		if (empty($wsdl))
			$wsdl = "includes/soap/autres/" . $env . "/TestConnectionService.wsdl";
		
		try {
        	ini_set("default_socket_timeout", 15);
            $soapClient = new SoapClient($wsdl, array("trace"=>true, "connection_timeout"=>10, "soap_version"=>SOAP_1_1));
            
            // Connexion au WS
            $res = $soapClient->sendTestMessage(array("echo"=> "test"));
            unset ($soapClient);
            
            // Test de la réponse
            if ($res->echo == "test") {
				return true;
				
            } else {
				return false;
				
			}
			
        } catch (Exception $e) {
			return false;
			
		}
		
	}

}
