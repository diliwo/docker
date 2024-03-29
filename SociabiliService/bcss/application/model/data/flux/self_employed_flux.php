<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1); 

 require_once realpath(dirname(__FILE__)) . '/soa_flux.php';
 ini_set('soap.wsdl_cache_enabled',0);
 ini_set('soap.wsdl_cache_ttl',0);

 class SelfEmployed extends SoaFlux {
    
     private $args = NULL; // Preparation des arguments pour envoyer au serveur SOAP  
     private $soap = NULL; // Object soap
     private $rn; // Registre national 
     private $contexteLegal; // Context de CPAS
     
     private $dateFee = array(); // Créer un tableau de date pour comparer entre d'une reponse SOAP et fichier translate 
     
     private $response = array(); //  Une réponse SOAP 
   
     // Toutes les methodes SOAP sont fournis par BCSS
     public $soapFunction = '{"functions" : {
            "0": {"name" : "consultCareer", "show": true},
            "1": {"name" : "consultCareerAndContributions", "show": false},
            "2": {"name" : "consultContributions", "show": false}
        }
    }';	
     
     // Ne pas afficher de résultat de SOAP ( suppression des tags )
     public $removeWasteFromElems = array (
         'ticket',
         'timestampSent',
         'ticketCBSS',
         'timestampReceive',
         'timestampReply',
         'legalContext',
         'ssin',
         'value',
         'description'
     );
     
     public function getDossiers($rn, $contexteLegal="PCSA:SOCIAL_INQUIRY")
     {
         
        // Vérification de la bonne connexion au SOAP
        if (is_null($this->soapClient))
            return null;
             
        $this->soap = $this->soapClient;
        $this->rn = $rn;
        $this->contexteLegal = $contexteLegal;
             
        return $this->getDataSoap() ;
     }
     
     public function getDataSoap()
     {
         $obj = $this->authSource( );
         
         if( is_array($obj) || is_object($obj) ) {
             return $obj;
             
         }
         
         self::getError( $this->translate('fluxError') . ' ::getDataSoap()');
         
     }
     
     // Méthodes de processus - ajout toutes les donnees d'une réponse SOAP dans une variable ( response )
     private function authSource( $deep = 0 )
     {
         $func = json_decode( $this->soapFunction, true );
         $size = ( sizeof($func['functions']) - $deep ) ;
         
         if( !$func['functions'][$deep]['show'] ) {
              
             if( isset( $func['functions'][++$deep]) ) {     
                 return $this->authSource( $deep );
                 
             } else {
                 return $this->response;
                  
             }
              
         }

         $this->args = $this->isArguments( $deep , $func['functions'][$deep]) ;

         $data =   (
             is_null( $this->args ) ?
             NULL :
             $this->getResponseSOAP( $func['functions'][$deep]['name'] )
        );  
             
        $this->response[$func['functions'][$deep]['name']] = $data;

        if( $size >= $deep) {
               
            if( isset( $func['functions'][++$deep]) ) { 
               return  $this->authSource( $deep );
            } 
           
        }
        
        return $this->response;
        
     }
     
     // Méthodes d'exécution - Résultat de réponse SOAP 
     public function getResponseSOAP( $func )
     {
         try {
             return $this->soap->{$func}( $this->args );

         } catch ( SoapFault $e ) {       
             self::getError($this->translate('fluxError') . " ::getResponseSOAP() {$func} ");
             
         }
         
     }

     private function isArguments( $deep, $func )
     {
         $now = self::getDate('NOW') ;
         
         $begin = clone $now;
         $end = clone $now;
          
         $begin->modify('-124 months');
         
         switch($deep) {
           
             case 0:
                 $arguments = array(
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
                        "ssin" => $this->rn,
                        "period" => array(
                            "beginDate" => '1976-07-01',
                            "endDate" => $end->format("Y-m-d")
                     
                        )
                    )
                 );
                break;
                
             case 1:
                $arguments = NULL;
                break;
             
             case 2:
                $arguments = NULL;
                break;
         }

         return $arguments;
         
     }
     
     // Les données sont générées ici de manière récursive. Utilisé comme display 
     public function getResult( $name = null)
     {
        if( !isset($this->response[$name]->result) || (!is_object($this->response[$name]) ) ) return $this->noData ( ' ' );
        
        $field = '';
        try {
            
            $iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator( $this->response[$name]->result ) );

            foreach ( $iterator  as $ik => $iv ) {
                
                if( in_array( $ik,  $this->removeWasteFromElems ) ) continue; 
                
                //------ Debut date --------//
                if($iterator->key() == 'beginDate') {
                    
                    $iterator->offsetSet($iterator->key(), $this->getNewDate( $iv )  );
                    $this->dateFee['beginDate'] = $iv;
                    $iterator->next(); 
                    
                    $field .= $this->getHTML(
                        'period',
                        ' du ' . $this->getNewDate( $iv ) . ' au ' . $this->getNewDate( ($iterator->key() != 'endDate') ? '...' :  $iterator->current() ), 'date'
                    );
  
                    if($iterator->key() == 'endDate') {
                        
                        $iterator->offsetSet($iterator->key(), $this->getNewDate( $iv) );
                        $this->dateFee['endDate'] = $iv;
                        continue;
                    }  
                    
                }
                
                if( $iterator->key() == 'contributionCode') {
 
                    $this->dateFee['contributionCode'] = $iterator->current();
                    
                    $iterator->offsetSet($iterator->key(), $this->compareDateAndGetMsg() );

                    $field .= ( $this->getHTML ( $iterator->key(), $iterator->current() ) );
                    
                    if( is_array( $this->response[$name]->result->membership->careerComponent  ) ) {
                        $field .= ( $this->getHTML ( ' ', ' ' ) );
                        
                    }

                    continue;
                }
                
                //------ Fin date --------// 
                
                $field .= ( $this->getHTML ( $ik, $iv ) ); 
                 
            }
     
        } catch ( Throwable $throw ) {

            self::getError($this->translate('fluxError') . " ::getResult() ");
                
        }
        
        $this->noData ( $field );
        
     }
     
     private function compareDateAndGetMsg( ) 
     {
         // Response SOAP. Il ne peut y avoir qu'une lettre A,B,C...Z
         $alphabet = (isset( $this->dateFee['contributionCode']) ? $this->dateFee['contributionCode'] : NULL) ;
         
         if( is_null($alphabet) ) { return NULL; }
  
         if( $this->checkDateOfTheComment( $this->translate( "COMMENT#{$alphabet}" )) ) {
             return $this->imgInfobulle($alphabet, $alphabet );
             
         } 
         
         if( $this->checkDateOfTheComment( $this->translate( "COMMENT#{$alphabet}#01" )) ) {  
             return $this->imgInfobulle($alphabet, "{$alphabet}#01" );
             
         }
         // N'a pas trouvé aucune résultat : Peut-être problème avec le format de date dans un fichier translete
         return $this->translate( 'problemeCommentDate' );
         
     }
     
     // 1.( Retirer les slashes de date ) 2.( fusionner et convertir la date en anglais ) 
     public function convertDate( $date ) 
     {
         
         preg_match("/([0-9]{2}.*)\/([0-9]{2}.*)\/([0-9]{4}.*)$/" , $date , $matche );
         
         if( is_array( $matche ) && sizeof( $matche ) > 0 ) { 
            $newDate = $matche[3].$matche[2].$matche[1];
            return preg_replace ('/\s/', '', $newDate);
            
         }
         
         preg_match("/([0-9]{4}.*)-([0-9]{2}.*)-([0-9]{2}.*)$/" , $date , $matche );
         
         if( is_array( $matche ) && sizeof( $matche ) > 0 ) { 
             $newDate = $matche[1].$matche[2].$matche[3];
             return preg_replace ('/\s/', '', $newDate);
             
         }
         
     }
     
     // Vérifier les dates de ( response SOAP )  entre et les dates d'un fichier translate  
     public function checkDateOfTheComment( $comment ) 
     {
         
         $now = self::getDate('NOW') ;
         
         preg_match("/BEGIN(.*)END(.*)$/" , $comment , $matche );
         
         if( !is_array( $matche ) || sizeof($matche) < 0 ) { return false ; }
         
         $endDate =  ( ( trim($matche[2]) == '00/00/0000' )  ? $now->format("d/m/Y") : $matche[2] );
        
         if( $this->convertDate($matche[1]) < $this->convertDate($this->dateFee['beginDate']) &&
             $this->convertDate($endDate)   > $this->convertDate($this->dateFee['endDate']) ) {
                 return true;
          }
          
          return false;
          
     }
     // Génère du code HTML 
     public function getHTML( $key, $val, $set = null, $trans = null )
     {  
         $ret = '<table> <tr> ';
         switch($set) {
             
             case 'date':
                 return'<h1>'. $this->translate($key) . ' ' .$this->translate($val). '</h1> ';
               
         }
        
         $ret .= '<th>'. $this->translate($key) .'</th> 
                    <td>' . ( !is_null( $trans ) ? $val : $this->ssinShowDialog ( $this->translate($val))  ) . '</td>  
                  </tr> </table>';
         
         
         return $ret;
         
     }
     
     public static function getDate( $param = NULL )
     {
         $now = new DateTime();
         $now->setTimezone( new DateTimeZone("Europe/Brussels") );
         
         if(is_null($param) )
             return $now->format("Y-m-d")."T".$now->format("H:i:s")."Z";
         else
            return $now;
                 
     }
     
     public function ssinShowDialog ( $ssin )
     {
         $pattern = "/[0-9][0-9](([0][0-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))(([0-9]{2}[1-9])|([0-9][1-9][0-9])|([1-9][0-9]{2}))(([0-8][0-9])|([9][0-7]))$/i";
         if( preg_match( $pattern, $ssin ) )
             return '<a href="index.php?env=member&amp;page=person&amp;action=display&amp;rn='.$ssin.'" class="rn">'.$ssin.'</a>';
             
        return $ssin ;
             
     }
     
     public function imgInfobulle($alpha, $title)
     {
         return $this->translate ( $title );
         
         //return $alpha.' <img class="infobulle" title="'.$this->translate ( $title ).'" src="'.$this->getAddress().'/includes/images/info.png"> ';
     }
     
     public function getAddress() 
     {
         
         preg_match("/(htt?(ps|p))(.*)/i", $_SERVER["SERVER_PROTOCOL"], $p );
         
         return strtolower( $p[1] ).'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
         
     }
     
     
     public function translate( $attr = NULL )
     {
         global $elem ;

         if(isset( $elem->val->{$attr} ) )
             return iconv("UTF-8","ISO-8859-1", $elem->val->{$attr}) ;
             
        return  $this->getNewDate( $attr );
             
     }
     
     public function getNewDate( $val )
     {
         preg_match("/(^[1-2][0-9]{3})-([0-9]{2})$/" , $val, $single );
         
         if( is_array ($single) && ( sizeof($single) > 0 ) ) 
             return $single[2].'/'.$single[1];
         
         preg_match("/(^[1-2][0-9]{3})-([0-9]{2})-([0-9]{2})$/" , $val, $full );
         
         if( is_array ($full) && (sizeof($full) > 0 ) )    
            return $full[3].'/'. $full[2].'/'.$full[1];
         
         return $val;
                 
     }
     
     public function noData ( $data )
     {
         if( preg_match('/<td>(.*)<\/td>/' , $data) ) { 
             print( '<div class="fieldset">'. $data .' </div>') ;
             return;
             
         }
         
       print ( $data . '<p class="error">'. $this->translate('no_data').'</p>')  ;
       
     }
     
     private static function getError( $msg )
     {
         trigger_error( $msg, E_USER_ERROR );
     }
     
 }
 
?>