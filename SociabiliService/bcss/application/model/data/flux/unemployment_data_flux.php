<?php
require_once realpath(dirname(__FILE__)) . '/soa_flux.php';

class UnemploymentData extends SoaFlux
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
    
    // Toutes les methodes SOAP sont fournis par BCSS
    public $soapFunction = '{"functions" : {
            "0": {"name" : "consultActivationPaidSums", "times":"0"},
            "1": {"name" : "consultPaidSums",           "times":"0"},
            "2": {"name" : "consultPayments",           "times":"0"},
            "3": {"name" : "consultRights",             "times":"0"}}
    }';	
    
    /* TSS – UnemploymentDataV3
     * 
     * 0) consultActivationPaidSums
     * quarterCriteria
     * Détermine les critères du trimestre recherche
     * quarter = Numéro du trimestre recherché 
     * year = Année pour laquelle le trimestre recherché est défini
     *  
     * 1) consultPaidSums
     * period
     * Période de recherche définie par une date de début et de fin, l'intervalle maximal pour celle-ci est de 48 mois. 
     * 
     * 2) consultPayments
     * date = Date pour laquelle l'on veut consulter les paiements de la personne 
     * (si pas de date on consulte les derniers paiements connus)
     * 
     * 3) consultRights
     * date = Date pour laquelle l'on veut consulter les droits de la personne 
     * (si pas de date on consulte les derniers droits connus)
     *  
     *
     * 0) consultActivationPaidSums
     * Cette fonction permet de rechercher des informations (montant - employeurs - etc.) 
     * - concernant les allocations d'activations qui ont été attribuées à une personne durant le trimestre demandé.
     *  
     * 1) consultPaidSums
     * Cette fonction permet de retrouver les sommes payées par le secteur chémage à une personne durant une période donnée.
     * Période de recherche définie par une date de début et de fin, l'intervalle maximal pour celle-ci est de 48 mois. 
     *
     * 2) consultPayments
     * Cette fonction permet de recherche la situation de paiement d'une personne soit à une date donnée soit la derniére situation connue.
     * Date pour laquelle l'on veut consulter les paiements de la personne (si pas de date on consulte les derniers paiements connus)
     * 
     * 3) consultRights
     * Cette fonction permet de consulter la situation du droit au chémage d'une personne. La situation demandée peut 
     * - étre soit celle à un jour donné, soit la derniére situation connue.
     * Si la personne n'a pas de droit, une information sur son " non " droit sera fournie.
     * Date pour laquelle l'on veut consulter les droits de la personne (si pas de date on consulte les derniers droits connus)
     *
     */
    
    // Ajouter des éléments ici si on ne veut pas afficher dans resultat
    public $removeWasteFromElems = array (
            'ticket',
            'timestampSent',
            'ticketCBSS',
            'timestampReceive',
            'timestampReply',
            'legalContext',
            'ssin',
            'code',
            'value',
            'description',
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
        self::getError( $this->translate ('fluxError') . ' ::getDataSoap()');
    }
    
    private function authSource( $deep = 0 )
    {         
        $func = json_decode( $this->soapFunction, true );  
        $size = ( sizeof($func['functions']) - $deep ) ;

         if( $size > 0 ) {          
            $this->args = $this->isArguments( $deep , $func['functions'][$deep]) ;
            
            $data = (
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
                return $this->authSource( $deep );
                    
            }  else {
                $d = ($this->timer == 0 ? $deep : ++$deep ) ;
                $this->timer = 0; 
                $this->prepare[$func['functions'][$d]['name']] =  $data; 
                return $this->authSource( ++$d ); 
            }
                
        } 
        return $this->prepare = $this->removeNullFromArray( $this->prepare );
    }
    
    public function reverse() 
    { 
        if( isset( $this->prepare['consultPaidSums']->paidSums->{'paidSum'} ) ) {
            krsort( $this->prepare['consultPaidSums']->paidSums->{'paidSum'} );
        }
        if( isset( $this->prepare['consultActivationPaidSums'] ) ){
            $activationAllowance = $this->prepare['consultActivationPaidSums']->activationAllowances->{'activationAllowance'} ;
            foreach( $activationAllowance as $k => $v ) {
                krsort( $activationAllowance[$k]->allowances->{'allowance'} );
            }
            krsort( $this->prepare['consultActivationPaidSums']->activationAllowances->{'activationAllowance'} );
        }
    }
    
    public function getResponseSOAP( $func ) 
    {
       try {
           $this->response = $this->soap->{$func}( $this->args );
       } catch( SoapFault $e ) {
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

        if( $deep == 0 || $deep == 1 ) {
            $begin->modify('-24 months'); 
            $arguments['searchCriteria']['period']['startMonth'] = $begin->format("Y-m");
            $arguments['searchCriteria']['period']['endMonth'] = $end->format('Y-m');
            return $arguments;
        }
        return $arguments;
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
    
    public function getResult( $name = null, $pack = null ) 
    {
        $field = '';
        if( array_key_exists($name, $this->prepare) ) {
            
            $iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator( $this->prepare[$name] ) );
            
            echo '<pre>';
           // print_r($this->prepare[$name]);
            echo '</pre>';
            foreach( $iterator as $ik => $iv ) {
                
                $this->packing[$name][$ik][] = $iv; 
 
                if( $ik == 'value' && preg_match('/NO_DATA_FOUND/' , $iv) ) return $this->noData( '' ); 
                    
                if( in_array($ik,  $this->removeWasteFromElems) ) continue;   
                 
                if( $ik == 'beginDate' && $name != 'consultActivationPaidSums' ) {
                    $iterator->next();
                    if($iterator->key() == 'endDate') {  
                        $per = ' du ' . $this->getNewDate( $iv ) . ' au ' . $this->getNewDate( $iterator->current() ); 
                        $field .=  $this->getHTML( $per, '', 'fulldate' );
                        continue; 
                    }   
                } 

                if( $ik == 'paidAmount' ) {
                    $iterator->next();
                    if($iterator->key() == 'acceptedAmount') { 
                        $app =  $this->translate('eleApproved') . $this->nFormat( $iterator->current() );
                        $field .= $this->getHTML( 'montant', $this->nFormat( $iv ) .
                            ( $iterator->current() == 0 ? '' :  $app )
                        );
                        continue;
                    }
                }
                if( $name == 'consultRights' || $name == 'consultPayments' || $name == 'consultActivationPaidSums' ) { 
                    if( $ik == '_' && is_numeric($iv) ) {
                        continue;
                    } else {
                        if( $ik == '_' ) {
                            $field .= ( $this->getHTML( 'desc', $iv ) );
                            $iterator->next(); $iterator->next(); $iterator->next(); continue;
                        }
                    }  
                }
                if( $ik == 'theoricDailyAllowanceAmount' || $ik == 'amount' ) {
                    $field .= ( $this->getHTML( $ik ,  $this->nFormat( $iv ) ) ); continue;
                }

                if( $name == 'consultActivationPaidSums' ) {

                    if( $ik == 'entryIntoEmploymentDate') { 
                        $field .=  $this->getHTML( $ik, $this->getNewDate($iv) ); continue;
                    }
                    if( $ik == 'beginDate') {  
                        $iterator->next();
                        if($iterator->key() == 'endDate') {  
                            $per = ' du ' . $this->getNewDate( $iv ) . ' au ' . $this->getNewDate( $iterator->current() ); 
                            $field .=  $this->getHTML( 'validityPeriod', $per );
                            continue; 
                        }   
                    } 
                    if( $ik == 'startMonth' ) {
                        $iterator->next();
                        if( $iterator->key() == 'endMonth' ) {
                            $per = ' du 01/' . $this->getNewDate( $iv ) . ' au 01/' . $this->getNewDate( $iterator->current() );
                            $field .=  $this->getHTML( $per, '', 'fulldate' );
                            continue;
                        }
                    }
                    if( $ik == 'paymentMonth' ) { $field .= $this->buildNewYearAndMonth( $iv ); continue; } 
                    if( $ik == 'enterpriseNumber' ) {  $field .=  $this->getHTML( '<hr>', '<hr>' ); }

                    if($ik == 'meanWorkingHours' || $ik == 'refMeanWorkingHours') {  
                        $h1 = $this->hFormat( $iv ) . ' / ' ;
                        $iterator->next();
                        $h2 = $h1 . $this->hFormat(  $iterator->current() ) ;
                        
                        $field .= ( $this->getHTML( $ik ,  $h2 ) ); continue;
                    } 
                    
                } 

                if( $name == 'consultPaidSums' ) { 
                    
                    if( $ik == 'startMonth' ) {
                        $iterator->next();
                        if( $iterator->key() == 'endMonth' ) {
                            $per = ' du 01/' . $this->getNewDate( $iv ) . ' au 01/' . $this->getNewDate( $iterator->current() );
                            $field .=  $this->getHTML( $per, '', 'fulldate' );
                            continue;
                        }
                    }
                    if( $ik == 'relatedMonth' ) { $field .= $this->buildNewYearAndMonth($iv); }
                    if( $ik == 'dossierStatus' )  { $field .= $this->getHTML( $ik, $this->imgInfobulle( $iv, $iv ) ); }

                    if( $ik == 'nbrOfAllowances' ) {
                        $field .= $this->getHTML( $ik , $iv, null, 'NO_TRANSLATE' );
                    }    
                }
               
                if( $name != 'consultPaidSums' ) $field .= ( $this->getHTML( $ik, $iv ) ); 
                
            }
        } 

        return ( is_array( $pack ) ? $this->packing : $this->noData ( $field ) );
    }
    
    public function getHTML( $key, $val, $set = null, $trans = null ) 
    {
        $nbr = null;
        if( $key == 'enterpriseNumber' ) {
            $nbr = ' <span class="btnOpen" title="'.$val.'" >' . $val . ' </span>';
        }
        
        switch($set) {
            case 'date':
            return'<div class="title_flux">'. $key .'</div> ';   
                
            case 'fieldset': 
            return '<div class="title_flux">'. $key . '</div> <div>'. $this->translate($val) .'</div>';
                
            case 'fulldate':
            return '<h2 class="header_center">' . $this->translate($val) . $key . '</h2>';    
        }
        
        return '<div class="recit"><b>'. $this->translate($key). '</b></div> 
                    <div class="recit2">' . 
                        ( !is_null( $trans ) ? $val : 
                            ( !is_null( $nbr ) ? $nbr : $this->translate($this->wageScaleCode($val)) )  
                        ) . 
                    ' </div>';
    }

    public function removeNullFromArray( $data = array() )
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

    public function hFormat( $n ) 
    {
        $n = $n / 100; 
        return number_format($n) . ' h.';
    }

    public function buildNewYearAndMonth( $date ) 
    {
        $output = preg_split("/-/", $date, PREG_SPLIT_OFFSET_CAPTURE);
        $month = $this->translate('month-'.$output[1]); 
        return $this->getHTML ( $month.$output[0] , '', 'date' );
    }
    
    public function imgInfobulle( $str = null, $title ) 
    {
        if( preg_match('/(COMPLETED|PROVISIONAL|NOT_STARTED)$/i', $str ) ) 
            $str = $this->translate ('S_'.$str);
        
        return $str . 
            '<img class="infobulle" title="'.$this->translate ( $title ).'" src="'.$this->getAddress().'/includes/images/info.png">';
    }
    
    public function getAddress() 
    { 
        preg_match("/(htt?(ps|p))(.*)/i", $_SERVER["SERVER_PROTOCOL"], $p);
        return strtolower( $p[1] ).'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
    }
  
    public function ssinShowDialog ( $ssin ) 
    {
        $pattern = "/[0-9][0-9](([0][0-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))(([0-9]{2}[1-9])|([0-9][1-9][0-9])|([1-9][0-9]{2}))(([0-8][0-9])|([9][0-7]))$/i";
        if( preg_match( $pattern, $ssin ) )   
            return '<a href="index.php?env=member&amp;page=person&amp;action=display&amp;rn='.$ssin.'" class="rn">'.$ssin.'</a>';
        
        return $ssin ;
    }
    
    public function translate( $attr = NULL ) 
    {
        global $elem ;
        
        if(isset( $elem->val->{$attr} ) )   
            return iconv("UTF-8","ISO-8859-1", $elem->val->{$attr}) ;
        
        return  $this->getNewDate( $attr );
    }
    
    public function noData( $data ) 
    { 
        if( preg_match('/<div class="recit(.*)".*>(.*)<\/div>/' , $data) ) 
            return $data;
        
        return $data . '<p class="error">'. $this->translate ('no_data').'</p>' ;
    }
    
    public function getNewDate( $val ) 
    {
        $val = preg_replace('/(^[2][0-9]{3})-([0-9]{2})-([0-9]{2})+(.*)/', "$3/$2/$1", $val);
        $val = preg_replace('/(^[0-9][0-9]{3})-([0-9]{2})-([0-9]{2})/', "$3/$2/$1", $val);
		$val = preg_replace('/(^[2][0-9]{3})-([0-9]{2})/', "$2/$1", $val);
        return $val ;
    }
    
    private static function getError( $msg )
    {
        trigger_error( $msg, E_USER_ERROR );
    }
    
    // Réglementations Régionales (tableau construit sur base de la réglementation existante) :
    public function wageScaleCode( $str ) 
    {
        $code = '{
            "1": {"code": "G./..WA1..", "target":"Jeunes", "durationMonths": "24 mois", "amount": "500 €" },
            "2": {"code": "G./..WA2..", "target":"Jeunes", "durationMonths": "6 mois", "amount": "250 €" },
            "3": {"code": "G./..WA3..", "target":"Jeunes", "durationMonths": "6 mois", "amount": "125 €" },
            "4": {"code": "G./..WA0..", "target":"Jeunes", "durationMonths": "Pas d\'octroi", "amount": "/" },
            
            "5": {"code": "G./..WB1..", "target":"Chômeurs longue durée", "durationMonths": "12 mois", "amount": "500 €" },
            "6": {"code": "G./..WB2..", "target":"Chômeurs longue durée", "durationMonths": "6 mois", "amount": "250 €" },
            "7": {"code": "G./..WB3..", "target":"Chômeurs longue durée", "durationMonths": "6 mois", "amount": "125 €" },
            "8": {"code": "G./..WB0..", "target":"Chômeurs longue durée", "durationMonths": "Pas d\'octroi", "amount": "/" },
            
            "9": {"code": "G./..WC1..", "target":"Contrat d\'insertion", "durationMonths": "", "amount": "?" },
            "10": {"code": "G./..WC0..", "target":"Contrat d\'insertion", "durationMonths": "Pas d\'octroi", "amount": "." },
            
            "11": {"code": "G./..BA1..", "target":"Activa Brussels", "durationMonths": "6 mois", "amount": "350 €" },
            "12": {"code": "G./..BA2..", "target":"Activa Brussels", "durationMonths": "12 mois", "amount": "800 €" },
            "13": {"code": "G./..BA3..", "target":"Activa Brussels", "durationMonths": "12 mois", "amount": "350 €" },
            "14": {"code": "G./..BA0..", "target":"Activa Brussels", "durationMonths": "Pas d\'octroi", "amount": "/" }
        }';

        $j = json_decode($code);
         
        $count = 1;
        foreach( $j as $k) {
            
            if( $j->{$count}->code == trim($str) ) {   
                return '<span class="wageScaleCode"> ' .
                    $j->{$count}->code . 
                    ' (' . $j->{$count}->target . ' - ' . $j->{$count}->durationMonths . ' - ' . $j->{$count}->amount . ') '.
                    '</span>' ;
                 
            }
            
            $count++;
        }
        
        return  $this->wageScaleCodeFederales( $str ) ;
    }
    
    // Réglementations fédérales (tableau construit sur base des informations de Onem Tech) : 
    public function wageScaleCodeFederales( $str ) 
    { 
        $code = '{
            "1": {"code": "A./..0...,.", "target": "A. / Contract de première expérience professionnelle", "ds": "0,0000 €", "ms": "0,0000 €" }, 
            "2": {"code": "A./..BB0.,.", "target": "A. / Contract de première expérience professionnelle", "ds": "0,0000 €", "ms": "0,0000 €" },

            "3": {"code": "B./..0...,.", "target": "B. / Programme de transition", "ds": "0,0000 €", "ms": "0,0000 €" },
            "4": {"code": "B./..1...,P", "target": "B. / Programme de transition", "ds": "247,8900 €", "ms": "49,5800 €" },
            "5": {"code": "B./..1..D,.", "target": "B. / Programme de transition", "ds": "433,8100 €", "ms": "0,0000 €" },
            "6": {"code": "B./..2...,P", "target": "B. / Programme de transition", "ds": "297,4700 €", "ms": "49,5800 €" },
            "7": {"code": "B./..3...,P", "target": "B. / Programme de transition", "ds": "247,8900 €", "ms": "0,0000 €" },
            "8": {"code": "B./..3..D,.", "target": "B. / Programme de transition", "ds": "433,8100 €", "ms": "49,5800 €" },
            "9": {"code": "B./..4...,P", "target": "B. / Programme de transition", "ds": "322,2600 €", "ms": "49,5800 €" },
            "10": {"code": "B./..4..D,.", "target": "B. / Programme de transition", "ds": "545,3700 €", "ms": "0,0000 €" },
            "11": {"code": "B./..5...,P", "target": "B. / Programme de transition", "ds": "297,4700 €", "ms": "49,5800 €" },
            "12": {"code": "B./..5..D,.", "target": "B. / Programme de transition", "ds": "433,8100 €", "ms": "0,0000 €" },
            
            "13": {"code": "C./..0...,.", "target": "C. / Activation emploi services", "ds": "0,0000 €", "ms": "0,0000 €" },
            "14": {"code": "C./..1...,.", "target": "C. / Activation emploi services", "ds": "433,8100 €", "ms": "0,0000 €" },
            "15": {"code": "C./..2...,.", "target": "C. / Activation emploi services", "ds": "545,3700 €", "ms": "0,0000 €" },
            "16": {"code": "C./..3...,.", "target": "C. / Activation emploi services", "ds": "148,7400 €", "ms": "0,0000 €" },
            "17": {"code": "C./..4...,.", "target": "C. / Activation emploi services", "ds": "148,7400 €", "ms": "0,0000 €" },

            "18": {"code": "CA/..0...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "0,0000 €", "ms": "245,5900 €" },
            "19": {"code": "CA/..1*..,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "750,0000 €", "ms": "245,5900 €" },   
            "20": {"code": "CA/..1...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "433,8100 €", "ms": "245,5900 €" },
            "21": {"code": "CA/..2*..,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "750,0000 €", "ms": "245,5900 €" },
            "22": {"code": "CA/..2...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "545,3700 €", "ms": "245,5900 €" },
            "23": {"code": "CA/..3...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "750,0000 €", "ms": "245,5900 €" },
            "24": {"code": "CA/..4...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "750,0000 €", "ms": "245,5900 €" },
            "25": {"code": "CA/..5...,F", "target": "CA. / Economie sociale d\'insertion (SINE)", "ds": "750,0000 €", "ms": "245,5900 €" },
            
            "26": {"code": "D./..0...,.", "target": "D. / Allocation plan d\'embauche", "ds": "0,0000 €", "ms": "0,0000 €" },
            "27": {"code": "D./..1...,.", "target": "D. / Allocation plan d\'embauche", "ds": "148,7400 €", "ms": "0,0000 €" },

            "28": {"code": "E./..0...,.", "target": "E. / Interim d\'insertion", "ds": "0,0000 €", "ms": "0,0000 €" },
            "29": {"code": "E./..1...,.", "target": "E. / Interim d\'insertion", "ds": "545,3700 €", "ms": "0,0000 €" },    
            
            "30": {"code": "F./..0...,", "target": "F. / Groupement d\'insertion", "ds": "0,0000 €", "ms": "0,0000 €" },
            "31": {"code": "F./..1...,.", "target": "F. / Groupement d\'insertion", "ds": "545,3700 €", "ms": "0,0000 €" },
            
            "32": {"code": "G./..0...,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" },
            "33": {"code": "G./..10..,",  "target": "G. / Allocation de travail", "ds": "350,0000 €", "ms": "0,0000 €" },
            "34": {"code": "G./..12..,",  "target": "G. / Allocation de travail", "ds": "350,0000 €", "ms": "0,0000 €" },
            "35": {"code": "G./..13..,",  "target": "G. / Allocation de travail", "ds": "1 000,0000 €", "ms": "0,0000 €" },
            "36": {"code": "G./..14..,",  "target": "G. / Allocation de travail", "ds": "1 100,0000 €", "ms": "0,0000 €" },
            "37": {"code": "G./..15A.,",  "target": "G. / Allocation de travail", "ds": "750,0000 €", "ms": "0,0000 €" },
            "38": {"code": "G./..15B.,",  "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" },
            "39": {"code": "G./..16..,",  "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" },
            "40": {"code": "G./..3...,.", "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" },
            "41": {"code": "G./..4...,.", "target": "G. / Allocation de travail", "ds": "900,0000 €", "ms": "0,0000 €" },
            "42": {"code": "G./..5...,.", "target": "G. / Allocation de travail", "ds": "1 100,0000 €", "ms": "0,0000 €" },  
            "43": {"code": "G./..7...,.", "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "44": {"code": "G./..8...,.", "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "45": {"code": "G./..BA0.,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" }, 
            "46": {"code": "G./..BA1.,.", "target": "G. / Allocation de travail", "ds": "350,0000 €", "ms": "0,0000 €" }, 
            "47": {"code": "G./..BA2.,.", "target": "G. / Allocation de travail", "ds": "800,0000 €", "ms": "0,0000 €" }, 
            "48": {"code": "G./..BA3.,.", "target": "G. / Allocation de travail", "ds": "350,0000 €", "ms": "0,0000 €" }, 
            "49": {"code": "G./..BB0.,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" }, 
            "50": {"code": "G./..BB1.,.", "target": "G. / Allocation de travail", "ds": "750,0000 €", "ms": "0,0000 €" }, 
            "51": {"code": "G./..BB2.,.", "target": "G. / Allocation de travail", "ds": "600,0000 €", "ms": "0,0000 €" }, 
            "52": {"code": "G./..WA0.,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" },
            "53": {"code": "G./..WA1.,.", "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" },  
            "54": {"code": "G./..WA2.,.", "target": "G. / Allocation de travail", "ds": "250,0000 €", "ms": "0,0000 €" }, 
            "55": {"code": "G./..WA3.,.", "target": "G. / Allocation de travail", "ds": "125,0000 €", "ms": "0,0000 €" }, 
            "56": {"code": "G./..WB0.,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" }, 
            "57": {"code": "G./..WB1.,.", "target": "G. / Allocation de travail", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "58": {"code": "G./..WB2.,.", "target": "G. / Allocation de travail", "ds": "250,0000 €", "ms": "0,0000 €" }, 
            "59": {"code": "G./..WB3.,.", "target": "G. / Allocation de travail", "ds": "125,0000 €", "ms": "0,0000 €" }, 
            "60": {"code": "G./..WC0.,.", "target": "G. / Allocation de travail", "ds": "0,0000 €", "ms": "0,0000 €" }, 
            "61": {"code": "G./..WC1.,.", "target": "G. / Allocation de travail", "ds": "700,0000 €", "ms": "0,0000 €" },
            
            "62": {"code": "GI/..0...,.", "target": "GI. / Allocation de travail interim", "ds": "0,0000 €", "ms": "0,0000 €" },  
            "63": {"code": "GI/..1...,.", "target": "GI. / Allocation de travail interim", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "64": {"code": "GI/..15A., ", "target": "GI. / Allocation de travail interim", "ds": "750,0000 €", "ms": "0,0000 €" }, 
            "65": {"code": "GI/..15B., ", "target": "GI. / Allocation de travail interim", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "66": {"code": "GI/..2...,.", "target": "GI. / Allocation de travail interim", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            "67": {"code": "GI/..3...,.", "target": "GI. / Allocation de travail interim", "ds": "500,0000 €", "ms": "0,0000 €" }, 
            
            "68": {"code": "GK/..0...,.", "target": "GK. / Allocation de travail de courte durée", "ds": "0,0000 €",   "ms": "0,0000 €" }, 
            "69": {"code": "GK/..1...,.", "target": "GK. / Allocation de travail de courte durée", "ds": "500,0000 €", "ms": "0,0000 €" },     
            "70": {"code": "GK/..15A.,",  "target": "GK. / Allocation de travail de courte durée", "ds": "750,0000 €", "ms": "0,0000 €" },
            "71": {"code": "GK/..15B.,",  "target": "GK. / Allocation de travail de courte durée", "ds": "500,0000 €", "ms": "0,0000 €" },
            "72": {"code": "GK/..2...,.", "target": "GK. / Allocation de travail de courte durée", "ds": "500,0000 €", "ms": "0,0000 €" },
            "73": {"code": "GK/..3...,.", "target": "GK. / Allocation de travail de courte durée", "ds": "500,0000 €", "ms": "0,0000 €" }
 
        }';
        
        $j = json_decode($code);
        
        $count = 1;
        foreach($j as $k) {
            
            if( $j->{$count}->code == trim($str) ) { 
                return '<span class="wageScaleCode"> ' .
                    $j->{$count}->code .
                    ' (' . $j->{$count}->target . ' - ' . $j->{$count}->ds  . ') '.
                    '</span>' ;
            }
            $count++;
            
        }
        
        return $str;
        
    }

}

?>
     