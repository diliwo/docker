 <?php
 //error_reporting(E_ALL);
 //ini_set('display_errors', 1);
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class CadafFlux extends SoaFlux
{
    
    private $args;
    private $soap = NULL;
    private $rn;
    private $source;
    private $contexteLegal;
    
    public $localisation = '{"source" : {
                                "0" : "WALLONIA",
                                "1" : "FEDERAL",
                                "2" : "BRUSSELS",
                                "3" : "EASTBELGIUM",
                                "4" : "FLANDERS" }
    }';
    
    /**
     * Récupération du dossier CADAF
     *
     * @param type int $rn
     * @param type string contexteLegal
     * @return ArrayObject 
     */
    public function getDossiers($rn, $contexteLegal="PCSA:SOCIAL_INQUIRY")
	{
		// Vérification de la bonne connexion au SOAP
		if (is_null($this->soapClient))
			return null;
		
        $this->soap = $this->soapClient;
        $this->rn = $rn;
        $this->contexteLegal = $contexteLegal;
        //$this->getDataSoapSingle(0) ;
        return $this->getDataSoap() ;
		 
	}

	public function getDataSoapSingle($key = 0)
	{
	    
	    $loc = json_decode($this->localisation);
	    $this->source = $loc->source->{$key};
	    $obj = $this->soap->getResultSoap('consultFilesBySsin', $this->isArguments());
	    
	    if( is_object($obj) ) {
	        
	        return $obj;
	        
	    }
	    
	    return self::getError('Impossible de se connecter au flux: ERREUR::getDataSoapSingle()');
	    
	}
	
	public function getDataSoap()
	{
	    
	    $obj = $this->authSource( );
	    
	    if( is_array($obj) && sizeof($obj) > 0 ) {
	        
	        return $obj;
	        
	    }
	    
	    self::getError('Impossible de se connecter au flux: ERREUR::getDataSoap()');
	    
	}
	
	private function authSource( $deep = 0, $ret = array() )
	{
	    
	    $loc = json_decode($this->localisation, true);
	    $size = (sizeof($loc['source']) - $deep) ;
	    
	    if($size > 0 ) {
	        
	        $this->source = $loc['source'][$deep];
	        
	        $ret[$loc['source'][$deep]] =  $this->soap->consultFilesBySsin($this->isArguments());
	        
	        return $this->authSource ( ++$deep, $ret);
	        
	    }
	    
	    if(sizeof($ret) <= 0) {
	        
            self::getError('Source est vide: ERREUR::authSource() ');
	        
	    }
	    
	    return $ret;
	    
	}
	
	private function isArguments()
	{
	    $now = self::getDate('NOW') ;
	    
	    $now->modify('-59 months');
	    
	    return array(
	        "informationCustomer" => array(
	            "ticket" => $this->lectureReference(),
	            "timestampSent" => self::getDate(),
	            "customerIdentification" => array(
	                "cbeNumber" => str_pad($this->cbeNumber, 10, "0"),
	                "sector" => $this->secteur,
	                "institution" => $this->institution
	            )
	        ),
	        "legalContext" => $this->contexteLegal,
	        "criteria" => array(
	            "ssin" => $this->rn ,
	            "period" => array(
	                "beginMonth" => $now->format('Y-m'),
	                "endMonth" =>  date('Y-m')
	            ),
	            "authenticSources"=> array(
	                "authenticSource" => $this->source
	            )
	        )
	    );
	    
	}
	
	public static function getDate($param = NULL) {
	    
	    $now = new DateTime();
	    $now->setTimezone(new DateTimeZone("Europe/Brussels"));
	    
	    if(is_null($param) )
	        return $now->format("Y-m-d")."T".$now->format("H:i:s")."Z";
	        else
	            return $now;
	            
	}
	
	private static function getError($msg) {
	    
	    trigger_error($msg,
	        E_USER_ERROR
	        );
	    
	}
}