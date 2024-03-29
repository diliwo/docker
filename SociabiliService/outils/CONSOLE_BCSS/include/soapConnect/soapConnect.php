<?php

ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);

ini_set("default_socket_timeout", 15);
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('CBENUMBER', $_config["flux"]["cbe_number"]);
define('SECTOR', $_config["flux"]["secteur"]);
define('INST', '1');

define('USERNAME', $_config["flux"]["usernamer"]);

define('PASSWORD', 'p4350415330B4474DD5238F01EBE4');
define('LEGAL_CONTEXT', 'PCSA:SOCIAL_INQUIRY');

class soapConnect
{

    private $urlWSDL;
    
    private $soapClient;
    private $soapParam;
    private $soapOperation;
    
    private $auth = array();
    private $reference;
    private $request;
    
    // Cr�er un constructor 
    public function __construct($request)
    {
        // Quelle methode il faut utiliser GET ou POST
        $this->request = (( is_null($request) ) ? $_GET : $_POST);
 
        $this->authentification( );
                
    }
    //Etablir une connexion au service SOAP
    private function getSoapClient() {
        
       // $opt = array('trace'=>true, 'connection_timeout'=>10, 'soap_version'=>SOAP_1_1);
        $opt = array (
            'login'    => $this->auth['username'] ,
             'password' => $this->auth['password'],
             'trace'    => true,
            'soap_version'=>SOAP_1_1,
             'connection_timeout' => 10,
             'stream_context'     => stream_context_create (
                    array (
                        'ssl'=> array (
                            'verify_peer'     => false,
                            'verify_peer_name' => false
                    )
                )
             )
        );
        
        echo $this->urlWSDL;
        try {
             
            $this->soapClient = new SoapClient($this->urlWSDL, $opt);
            
        } catch (SoapFault $fault) {
            
            self::triggerError($fault);
            
        }
        
    }
    // D�finir le mot de code et renvoyer un tableau 
    private function authentification() 
    {
       
        $this->auth['username'] =  ( 
            ( isset( $this->request['username'] ) ) ?
            $this->request['username'] : 
            USERNAME
        );
        $this->auth['password'] = ( 
            ( isset( $this->request['password'] ) ) ?
            $this->request['password'] :
            PASSWORD
        );
        
        return $this->auth;
        
    }
    // V�rifier le chemin - par exemple trouve le fichier  wsdl sinon afficher une page d'erreur 
    public function checkPathWSDL() 
    {
        
        $handle = curl_init($this->urlWSDL);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        if($httpCode == 404) {
 
             print_r($response);
            return false;
            
        }
        
        curl_close($handle);
        return true;
    }
   //Construire le chemin 
   public  function buildPath($path) 
   {
        
        $url = parse_url($_SERVER["PHP_SELF"]);
        
        if(isset( $url['path'] )) {
            
            $key = preg_split("/[\/]+/", $url['path'], PREG_SPLIT_OFFSET_CAPTURE);
            $wsdl_file =  $_SERVER["HTTP_HOST"].'/'.implode('/', array_slice($key, 1, -1)).$path;
 
            return $this->urlWSDL = 'http://'.$wsdl_file;
            
        }
        
        return false;
        
    }
     
    public static function getDate() {
        
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone("Europe/Brussels"));
        return $now->format("Y-m-d")."T".$now->format("H:i:s")."Z";
        
    }
    
    public function getNature() {
        
        if( filter_var(isset($this->request['nature_personnes']), FILTER_VALIDATE_INT) ){
            
            return $this->request['nature_personne'];
        }
        
        return 1;
        
    }
    
    public function getEnvironment() 
    {
       
        $env = preg_grep('/^(|acpt|prod|test|)$/i' , $this->request );
        return ( (isset($env['env']) ) ? $env['env'] :  'test'); 
         
    }
    
    public function getLang()
    {
        
        $lang = preg_grep ("/^(|fr|en|)$/i" , $this->request );
        return ( (isset($lang['langue']) ) ? strtoupper($lang['langue']) :  'FR'); 
        
    }

    public function checkMethod() 
    {
        
        if( filter_input( INPUT_SERVER, 'REQUEST_METHOD' ) )   
            return true;
        else
            return false;
        
    }
    
    public function getReferenceFile($ref = '../../reference.txt') 
    {
        
        $referenceFile = $ref;
        if (file_exists($referenceFile)) 
        {
            
            $fp = fopen ($referenceFile, "r+");
            $reference = fgets ($fp, 10);
            $newReference = $reference + 1;
            fseek ($fp, 0);
            fputs ($fp, $newReference);
            fclose ($fp);
            
        } else {
            
            $random = rand(0,9);
            
        }
        
        return "520118" . str_pad($random, 9, "0", STR_PAD_LEFT);
        
    }
    
    public function getResultSoap($method, $arg = array() ) 
    {
         
        $this->getSoapClient();
        
        $result = NULL;
        try {
            
             
            
            $soapClient = new SoapClient($this->urlWSDL, array (
                'login'    => $this->auth['username'] ,
                'password' => $this->auth['password'],
                'trace'    => true,
                'soap_version'=>SOAP_1_1,
                'connection_timeout' => 10,
                'stream_context'     => stream_context_create (
                    array (
                        'ssl'=> array (
                            'verify_peer'     => false,
                            'verify_peer_name' => false
                        )
                    )
                    )
            ));
            
            print_r( $arg );
            
              $result = $soapClient->__soapCall($method,   $arg ); 
            
            
            
            
            //$result =  $this->soapClient->consultContributions( $this->isArguments());
            //$result =  $this->soapClient->__call('consultContributions', $this->isArguments());
            
  
        } catch (SoapFault $fault) {
           
            self::triggerError($fault );
            
        }
        return  $result;
        
    }
    
    public static function triggerError($fault)
    {
        
        trigger_error(
            "SOAP Fault: (
                faultcode: { $fault->faultcode },
                faultstring: { $fault->faultstring },
                faultline: {$fault->getLine() }
            )",
            E_USER_ERROR
        );
        
    }
    
    
}

