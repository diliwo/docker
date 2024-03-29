<?php
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class UnemploymentDataV2 extends SoaFlux
{
    private $args = NULL;
    private $soap = NULL;
    private $rn;
    private $contexteLegal; 
     
    private $timer = 0; 
     
    private $prepare = array();
    private $response = array(); 
    private $criteria = array();
    public $packing = array();
    
    //  5 = ( 12 + 1 ) , 9 = ( 24 + 1 ), 17 = ( 32 + 1 ) etc...
    // Toutes les methodes SOAP sont fournis par BCSS
    public $soapFunction = '{"functions" : {
            "0": {"name" : "consultActivationPaidSums", "times":"12"},
            "1": {"name" : "consultCareerBreak",        "times":"0"},
            "2": {"name" : "consultPaidSums",           "times":"0"},
            "3": {"name" : "consultPayments",           "times":"0"},
            "4": {"name" : "consultRights",             "times":"0"},
            "5": {"name" : "consultScheduledPayment",   "times":"0"},
            "6": {"name" : "consultSituation",          "times":"0"}}
    }';	
    
    /*
     * 
     * 0) consultActivationPaidSums
     * quarterCriteria
     * Détermine les critères du trimestre recherche
     * quarter = Numéro du trimestre recherché 
     * year = Année pour laquelle le trimestre recherché est défini
     * 
     * 
     * 1) consultCareerBreak
     * Période de recherche obligatoire pour cette opération
     * beginDate = Début de période
     * endDate = Fin de période
     * 
     * 
     * 2) consultPaidSums
     * period
     * Période de recherche définie par une date de début et de fin, l’intervalle maximal pour celle-ci est de 48 mois. 
     * 
     * 
     * 3) consultPayments
     * date = Date pour laquelle l’on veut consulter les paiements de la personne 
     * (si pas de date on consulte les derniers paiements connus)
     * 
     * 
     * 4) consultRights
     * date = Date pour laquelle l’on veut consulter les droits de la personne 
     * (si pas de date on consulte les derniers droits connus)
     * 
     * 
     * 5) consultScheduledPayment
     * quarterCriteria
     * Détermine les critères du trimestre recherche
     * quarter = Numéro du trimestre recherché 
     * year = Année pour laquelle le trimestre recherché est défini
     * 
     * 
     * 6) consultSituation
     * date = Date pour laquelle l’on désire effectuer la consultation (AAAA-MM-JJ) 
     * Dans le cas où aucune date n’est définie, l’on consulte la dernière situation connue.
     * 
     */
    
    // Ajouter des éléments lesquelles on ne veut pas afficher dans resultat
    public $removeWasteFromElems = array (
            'ticket',
            'timestampSent',
            'ticketCBSS',
            'timestampReceive',
            'timestampReply',
            'legalContext',
            'ssin',
            'description',
            'value',
            'fieldName',
            'fieldValue',
            'cbeNumber'
    );
    
    /**
     * Permet de récupérer les sommes payées par les organismes de paiement ainsi que le montant approuvé 
	 * par l'ONEM pour les mois pendant une période spécifiée, pour chaque type de chômage
     *
     * @param int $rn Numéro de registre national
     * @param string $contexteLegal
     * @return array
     */
    public function getDossiers($rn, $contexteLegal="SOCIAL_INVESTIGATION_OF_PCSA")
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
        self::getError( $this->translate ('fluxError') . ' ::getDataSoap()');
        
    }
    
    private function authSource( $deep = 0 )
    {         
        $func = json_decode( $this->soapFunction, true );  
        $size = ( sizeof($func['functions']) - $deep ) ;

         if( $size > 0 ) {          
            $this->args = $this->isArguments( $deep , $func['functions'][$deep]) ;
                
            $data =   (
                is_null( $this->args ) ? 
                NULL : 
                $this->getResponseSOAP( $func['functions'][$deep]['name'] )
            );  

            if( $func['functions'][$deep]['times'] > $this->timer ) {   
                 ++$this->timer;
                    
                $this->prepare[$func['functions'][$deep]['name']][$this->timer] =  $data;
                    
                if ( $func['functions'][$deep]['times'] == $this->timer ) {    
                    $this->timer = 0;  
                    
                    ++$deep;   
                    
                }    
                return $this->authSource ( $deep );
                    
            }  else {
                $d = ($this->timer == 0 ? $deep : ++$deep ) ;

                $this->timer = 0; 
    
                $this->prepare[$func['functions'][$d]['name']] =  $data; 

                return $this->authSource ( ++$d );
                    
            }
                
        } 

        return $this->prepare = $this->removeNullFromArray( $this->prepare );
        
    }
    
    public function reverse() { 
        
        if( isset( $this->prepare['consultPaidSums']->paidSums->{'paidSum'} ) ) {
            
            krsort( $this->prepare['consultPaidSums']->paidSums->{'paidSum'} );
            
        }
    }
    
    public function getResponseSOAP( $func ) 
    {
       try {
           $this->response = $this->soap->{$func}( $this->args );
           
       } catch ( SoapFault $e ) {
           self::getError($this->translate ('fluxError') . " ::getResponseSOAP() {$func} ");
       }
       
       return $this->response;
        
    }

    private function isArguments( $deep, $func )
    {
        $now = self::getDate('NOW') ;
        
        $begin = clone $now;
        $end = clone $now;
        
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
            "searchCriteria" => array(
                "ssin" => $this->rn
            )
            
        );
        
        if( preg_match("/(^[05]{1})$/", $deep) ) { 
            ( $this->timer == 0 ? $this->typeCriteriaSeache( 4 , $func['times']  ) : NULL );
            
            if( count($this->criteria) == 0 ) {
                $this->criteria = array();
                return NULL;
            }
            
            $arguments['searchCriteria']['quarterCriteria']['quarter'] = $this->criteria[0]['range'];
            $arguments['searchCriteria']['quarterCriteria']['year'] = $this->criteria[0]['year'];
            array_shift($this->criteria);
            
            return $arguments; 
            
        }
        
        if( preg_match("/(^[12]{1})$/" , $deep) ) {  
            $begin->modify('-36 months');
            $arguments['searchCriteria']['period']['beginDate'] = $begin->format("Y-m").'-01';
            $arguments['searchCriteria']['period']['endDate'] = $end->format("Y-m").'-01';
            
            return $arguments;
            
        }
        
        if( preg_match("/(^[346]{1})$/" , $deep) ) {
            
            $arguments['searchCriteria']['period'] = array();

            return $arguments;
            
        }
        return NULL;
  
    }
    // range = trimestre ou quadrimestre
    public function typeCriteriaSeache( $range = 3, $counter ) 
    {
        $now = self::getDate('NOW') ; 
        $passed = clone $now;

        $this->criteria[0] = array (
            'year' => $now->format("Y"),
            'range' => ceil( ((int) $now->format('m')) / $range) 
        );
        
        for($k = $counter ; $k > 0; $k-=$range) { 
            $passed->modify("-".$range." month");
            
            $this->criteria[] = array (
                'year' =>  $passed->format('Y'),
                'range' => ceil(((int) $passed->format('m')) / $range)
            );
        }
       
        return $this->criteria;
    }
    
    public static function getDate($param = NULL) 
    {
        $now = new DateTime();
        $now->setTimezone( new DateTimeZone("Europe/Brussels") );
        
        if(is_null($param) )
            return $now->format("Y-m-d")."T".$now->format("H:i:s")."Z";
        else
            return $now;
                
    }
    
    function getResult( $name = null, $pack = null ) 
    {
        $field = '';
        if( array_key_exists( $name, $this->prepare) ) {
            
            $iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator( $this->prepare[$name]) );
            $counter = 0;

            foreach ( $iterator  as $ik => $iv ) {
                
                if( in_array( $ik,  $this->removeWasteFromElems ) ) continue;    
               
                $this->packing[$name][$ik][] = $iv;

                if($ik == 'code' && preg_match('/(MSG00000)$/' , $iv)) continue; 
                
                if($ik == 'code' && preg_match('/UDS000[1-2(.*)]|MSG000(.*)|UDS000(.*)$/' , $iv)) 
                    return $this->noData ( '' ); 
                
                if( $ik == 'quarter' ) {
                    $field .= ( $this->getHTML ( '<hr>', '<hr>' ) ); 
                    $iterator->next();
                    
                    if($iterator->key() == 'year') {  
                        $field .= $this->getHTML(
                            'criteria',
                            $this->translate('titleQuarter') ." {$iv} " .
                            $this->translate('year') ." {$iterator->current()} " 
                            );
                        
                        continue; 
                        
                    }   
                    
                } // end 
                
                if( $ik == 'beginDate' ) {
                    $iterator->next();
                    
                    if($iterator->key() == 'endDate') {  
                        $per = '   du ' . $this->getNewDate( $iv ) . ' au ' . $this->getNewDate( $iterator->current() ); 
                        $field .=  $this->getHTML ( $per, '', 'h' );
                        continue;
                        
                    }  
                    
                } // end 
                
                if( $ik == 'paidAmount' ) {
                    $iterator->next();
                    
                    if($iterator->key() == 'acceptedAmount') { 
                        $app =  ' / approuvé ' . $this->nFormat( $iterator->current() );
                        $field .= $this->getHTML(
                            'montant',
                            $this->nFormat( $iv ) .
                            ( $iterator->current() == 0 ? '' :  $app )
                            );
                        
                        continue;
                    }
                    
                } // end
                
                if( $name == 'consultSituation' ) {  
                    if( $ik == 'paidMonth' && $iterator->getDepth() == 2  )    
                        $field .=  $this->getHTML ( 'Paiements', '', 'fieldset' );
                        
                    if( $ik == 'theoricDailyAllowanceAmount' && $iterator->getDepth() == 3 )       
                        $field .=  $this->getHTML ( 'Droit', '', 'fieldset' );
                    
                }
                
                if( $ik == 'theoricDailyAllowanceAmount' ) {
                    $field .=   ( $this->getHTML ( $ik ,  $this->nFormat( $iv ) ) );
                    continue;
                    
                }

                if( $name == 'consultPaidSums' ) {   
                    if( $ik == 'relatedMonth' ) {
                        $field .=   $this->buildNewYearAndMonth($iv);
                        continue;  
                    }
                    
                    if( $ik == 'dossierStatus' )  {
                        $field .=  $this->getHTML ( $ik, $this->imgInfobulle( $iv, $iv ) ); 
                        continue;  
                    }
                    
                    if( $ik == 'nbrOfAllowances' ) 
                        $field .=  ( $this->getHTML ( $ik ,  $iv, null, 'NO_TRANSLATE') ); 
                    
                }

                if($name != 'consultPaidSums') 
                    $field .= ( $this->getHTML ( $ik, $iv ) ); 
                 
                $field .= ( ( $ik == 'cbeNumber' ) ? $this->getHTML ( '<hr>', '<hr>' ) : '' );   
                $counter++;
            }
 
        } 
        
        if( $counter < 4 ) { return $this->noData ( '' ); }
        
        return ( is_array( $pack ) ? $this->packing : $this->noData ( $field ) );

    }
    
    function removeNullFromArray( $data = array() )
    {
        $this->reverse();
        
        $data = array_map( function ( $value ) {
            return ( is_array($value) ? $this->removeNullFromArray( $value ) : $value);
            
        }, $data);
            
            return array_filter( $data, function( $value ) {
                
                return !is_null( $value );
            });
    }
    
    public function nFormat( $n ) 
    {
        return number_format((((float) $n) / 100), 2, ',', ' ') . ' €';
    }
    
    public function buildNewYearAndMonth($date) {
        
        $output = preg_split("/-/", $date, PREG_SPLIT_OFFSET_CAPTURE);
        
        return $this->getHTML ( $this->translate('month-'.$output[1]).$output[0] , '', 'fieldset' );
   
    }
    
    public function getHTML ( $key, $val, $set = null, $trans = null ) 
    {
        $ret = NULL;
        switch($set) {
            case 'fieldset': 
                $ret = '<fieldset>
                            <legend>' . $key . '</legend>'
                            . ( !is_null( $trans ) ? $val :  $this->translate($val) ) . 
                       '</fieldset>';
            break;           
            case 'h':
                $ret = '<h2>' . 
                            $key . ( !is_null( $trans ) ? $val :  $this->translate($val) ) . 
                        '</h2>';
            break;   
            case 'span':
                $ret ='<i>' . 
                        $key . ( !is_null( $trans ) ? $val :  $this->translate($val) ) .
                    '</i>';
            break;    
            default:  
                $ret =  '<div class="glob"> 
                                <div class="recit">
                                    <b>' . $this->translate($key). '</b>
                                </div> 
                            <div class="recit2">' . ( !is_null( $trans ) ? $val : $this->translate($val) ) . '</div>
                        </div>';
        }
        return $ret;
 
    }
    
    public function imgInfobulle($str = null, $title) 
    {
        if( preg_match('/(COMPLETED|PROVISIONAL|NOT_STARTED)$/i', $str ) ) 
            $str = $this->translate ('S_'.$str);
        
        return $str; 
    }
  
    public function ssinShowDialog ( $ssin ) 
    {
        $pattern = "/[0-9][0-9](([0][0-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))(([0-9]{2}[1-9])|([0-9][1-9][0-9])|([1-9][0-9]{2}))(([0-8][0-9])|([9][0-7]))$/i";
        if( preg_match( $pattern, $ssin ) )   
            return '<a href="index.php?env=member&amp;page=person&amp;action=display&amp;rn='.$ssin.'" class="rn">'.$ssin.'</a>';
        
        return $ssin ;
        
    }
    
    public function translate ( $attr = NULL ) 
    {
        global $elem ;
        
        if(isset( $elem->val->{$attr} ) )   
            return iconv("UTF-8","ISO-8859-1", $elem->val->{$attr}) ;
        
        return  $this->getNewDate( $attr );
        
    }
    
    function noData ( $data ) 
    { 
        if( preg_match('/<div class="recit(.*)".*>(.*)<\/div>/' , $data) ) 
            return $data;
        
        return $data . '<p class="error">'. $this->translate ('no_data').'</p>' ;
    }
    
    function getNewDate( $val ) 
    {
        preg_match("/(^[2][0-9]{3})-([0-9]{2})$/" , $val, $single );
        if( is_array ($single) && ( sizeof($single) > 0 ) ) 
            return $single[2].'/'.$single[1];
        
        preg_match("/(^[2][0-9]{3})-([0-9]{2})-([0-9]{2})$/" , $val, $full );
        if( is_array ($full) && (sizeof($full) > 0 ) ) 
            return $full[3].'/'. $full[2].'/'.$full[1];
        
        return $val;
        
    }
    
    private static function getError( $msg )
    {
        trigger_error( $msg, E_USER_ERROR );
    }
   
}

/* 
 * 
 * 1.1.	consultPaidSums
 * Cette fonction permet de retrouver les sommes payées par le secteur chômage à une personne durant une période donnée.
 * Période de recherche définie par une date de début et de fin, l’intervalle maximal pour celle-ci est de 48 mois. 
 *
 * 1.2.	consultSituation 
 * Cette fonction permet d’obtenir des informations sur le droit au chômage et les paiements réalisés pour une personne donnée. Si une personne n’a pas de droit, la raison de son « non » droit sera donnée.
 * Dans le cas où la recherche se fait pour une date donnée, ce sont les données du droit et de paiement à cette date qui seront recherchées.
 * Dans le cas où la recherche se fait pour la dernière situation connue, nous irons d’abord récupérer la dernière situation de paiement connue par l’ONEm et par la suite, nous irons récupérer le droit lié à cette situation de paiement.
 * Date pour laquelle l’on désire effectuer la consultation (AAAA-MM-JJ)
 * Dans le cas où aucune date n’est définie, l’on consulte la dernière situation connue. 
 * 
 * 1.3.	consultRights
 * Cette fonction permet de consulter la situation du droit au chômage d’une personne. La situation demandée peut être soit celle à un jour donné, soit la dernière situation connue.
 * Si la personne n’a pas de droit, une information sur son « non » droit sera fournie.
 * Date pour laquelle l’on veut consulter les droits de la personne (si pas de date on consulte les derniers droits connus)
 *
 * 1.4.	consultPayments
 * Cette fonction permet de recherche la situation de paiement d’une personne soit à une date donnée soit la dernière situation connue.
 * Date pour laquelle l’on veut consulter les paiements de la personne (si pas de date on consulte les derniers paiements connus)
 *
 * 1.5.	consultActivationPaidSums
 * Cette fonction permet de rechercher des informations (montant – employeurs – etc.) concernant les allocations d’activations qui ont été attribuées à une personne durant le trimestre demandé.
 *
 * 1.6 consultScheduledPayment
 * Attention les données ne sont disponibles qu’après 6 mois. Cela pour permettre à l’ONEM de fournir des données validées. 
 * 
 * 1.7 consultCareerBreak
 * Cette fonction permet de consulter les informations concernant les interruptions de carrière et/ou crédit-temps d’une personne pour une période donnée.
 * 
 * quarterCriteria = Détermine les critères du trimestre recherche
 * quarter (Numéro du trimestre recherché ) 
 * year (Année pour laquelle le trimestre recherché est défini) 
 *
 */

?>
     