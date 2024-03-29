 <?php
 
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';
$path =  implode('/',explode('/', str_replace('\\', '/',getcwd().'/includes/soapConnect/soapConnect.php')));
require_once($path);

class ChildBenefits  
{
    private $args;
    private $soap = NULL;
    private $rn;
    private $source;
    
    public $localisation = '{"source" : { 
                                "0" : "WALLONIA",
                                "1" : "FEDERAL",
                                "2" : "BRUSSELS",
                                "3" : "EASTBELGIUM",
                                "4" : "FLANDERS" } 
    }';
    
	const CODE_DONNEES_TROUVEES = "MSG00000";
	
	const ROLE_ATTRIBUTAIRE = "ATTRIBUTED";
	const ROLE_ALLOCATAIRE = "ALLOCATED";
	const ROLE_ENFANT_BENEFICIAIRE = "BENEFICIARY_CHILD";
	
	/**
	 * Récupération du dossier ChildBenefits
	 *
	 * @param type sring $rn
	 */
	public function getDossiers($rn)
	{
	    
	    $this->soap = new soapConnect(NULL);
	    $this->rn = $rn;
	    
	    $this->soap->buildPath("/includes/soap/childbenefits/" . ENV . "/be/fgov/kszbcss/intf/ChildBenefitsService/ChildBenefitsV1.wsdl");
	    $this->soap->checkPathWSDL();
	    
    }
    
    public function getDataSoapSingle($key = 0) 
    {
        
        $loc = json_decode($this->localisation);
        $this->source = $loc->source->{$key};
        $obj = $this->soap->getResultSoap('consultFilesBySsin', $this->isArguments());
        
        if( is_object($obj) ) {
            
            return $obj;
            
        }
        
        return self::getError('Impossible de se connecter au flux - getDataSoapSingle()');
        
    }
    
    public function getDataSoap() 
    {
 
        $obj = $this->authSource( );
        
        if( is_array($obj) && sizeof($obj) > 0 ) {
          
            return $obj;
            
        } 
            
        return self::getError('Impossible de se connecter au flux - getDataSoap()');
         
    }
    
    private function authSource( $deep = 0, $ret = array() ) 
    {
        
        $loc = json_decode($this->localisation, true);
        $size = (sizeof($loc['source']) - $deep) ;
        
        if($size > 0 ) {
            
            $this->source = $loc['source'][$deep]; 
            
            $ret[$loc['source'][$deep]] = $this->soap->getResultSoap('consultFilesBySsin', $this->isArguments());
            
            return $this->authSource ( ++$deep, $ret);
            
        }
        
        if(sizeof($ret) <= 0) {
            
            return self::getError('Statut de la source et vide: ');
            
        }
        
        return $ret;
        
    }
    
    private function isArguments() 
    {
         
        $now = $this->soap::getDate('NOW') ;
        
        $now->modify('-59 months');
        
        return array(
            "informationCustomer" => array(
                "ticket" => $this->soap->getReferenceFile(),
                "timestampSent" => $this->soap::getDate(),
                "customerIdentification" => array(
                    "cbeNumber" => CBENUMBER,
                    "sector" => SECTOR,
                    "institution" => INST
                )
            ),
            "legalContext" => LEGAL_CONTEXT,
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

    private static function getError($msg) {
        
        trigger_error($msg,
            E_USER_ERROR
        );
        
    }
    
}

?>

