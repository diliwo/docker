<h1> Cadaf </h1>
<?php

//echo "<pre>"; print_r($res); echo "</pre>";

if( !isset($res)  ) { exit; }
$elem = $code->{'FR'};
?>

 <div class="flux_child_glob"> 
 
<?php 

    if( is_array($res) && sizeof( $res ) > 0 ) {
         
        foreach($res as $key => $val) {
            
            dispaly($res[$key], $key); 
            
        }
        
    } else if( is_object($res) ) {
        
        dispaly($res);
        
    } else {
        
        exit();
        
    } 
?>

</div>

<?php 

function dispaly($res, $key = NULL) { 
    
    if( isset($res->resultByAuthenticSource->status->value) ) {
        
        print( translate($res->resultByAuthenticSource->status->value) );
        
    }
    
    if( isset($res->results->resultByAuthenticSource->files) ) {
        
        getElements($res->results->resultByAuthenticSource->files, 0, $key) ;
        
    } else {

        $field = ('<fieldset> <legend> ' . translate('childBenefitsFund') . '  ' .$key . '</legend>');
        $field .= ( '<p class="error">' . translate($res->status->code) . '</p>') ;

        $field .= '</fieldset>';

        print ($field);


    }
    
}

function getElements($element, $deep, $source) {
    
    // S'il sagit un tableaux (dans element file) alore inisialier index par default 
    $size = 0;
    
    if((isset($element->file) ) && (is_object( $element->file )) ) {
        
        $file = $element->file;
        
    } else if((isset($element->file) ) && (is_array( $element->file )) ) {
        
        // Combien d'éléments y a-t-il dans un tableau ( plus profondeur )
        $size = (sizeof ($element->file) - $deep) ;
        
        // Quitter cette methode s'il y n'a plus des elements
        if($size == 0 ) { return ; }
        
        $file = $element->file[$deep];
        
    } else {
        
        return false; 
    }
 
    getChildBenefitsFund ( $file->childBenefitsFund,  $source, $file->fileNumber);
   
    getTree($file->beneficiaries->beneficiary, 'beneficiaries' );
    getTree($file->children->child, 'child');

    // Fonction récursive getElements( )
    if($size > 0) { return getElements($element, ++$deep, $source); }
}

function getChildBenefitsFund ( $element, $source, $fileNumber = NULL ) {
    
    $field = ('<fieldset> <legend> ' . translate('childBenefitsFund') . '  ' .$source . '</legend>');
    
    foreach ($element  as $key => $val) {
        
        if($key == 'code') continue;
        
        $field .= getHTML (
            ($key == 'description' ? 'fileNumber' : $key) ,
            isset($val->_) ? $val->_ . ' ( '.$fileNumber.' ) '  : $val
        ) ;
        
    }
    
    $field .= '</fieldset>';

    print ($field);
    
}

function getTree( $element, $name = NULL) {
    
    $field = ('<fieldset> <legend> ' . translate($name) . '</legend>');
    
    $iterator = new RecursiveIteratorIterator( new RecursiveArrayIterator($element) );

    foreach ($iterator  as $ikey) {
         
        $current = $iterator->current() ;
        $key = $iterator->key();

        if( lang($current) || ($key == '_' && $current == ' language ') || ($key == '_' ) ) continue;
         
        $space = (($iterator->getDepth() > 3) ? getHTML ( '<hr>' , '<hr>' ) : ' ' );

        if($key == 'beginMonth') {
            
            $iterator->next();
             
            if($iterator->key() == 'endMonth') {   
                
                $field .= getHTML(
                            'period',
                            ' du ' . getNewDate( $current ) .
                            ' au ' . getNewDate( $iterator->current() )
                );
                
                continue;
                
            } else {
                
                $field .= getHTML('period', ' du ' .getNewDate ( $current ) .' au ...')  ; 
                $field .= getHTML('code', $iterator->current())  ;
                
                continue;
                
            }  
             
        }
        
        $field .= getHTML($key, $current)  ;
        
        $field .= $space;
    }
    
    print (  noData ( $field ) .'</fieldset>');
      
}

function getHTML ( $key, $val ) {
    
    return ' <div class="recit"> <b>' . translate($key). '</b> </div> <div class="recit">' . ssinShowDialog ( translate($val) ) . '</div> ';
}

function lang($val) {
    
    if( preg_match("/(FR|DE|NL|EN)$/i" , $val)) {
        
        return true;  
    }

    return false;
    
}

function getNewDate($val) {
    
    preg_match("/(^[2][0-9]{3})-([0-9]{2})$/" , $val, $single );
    
    if( is_array ($single) && (sizeof($single) > 0 )) {
        
        return $single[2].'/'.$single[1];
    }  
    
    preg_match("/(^[2][0-9]{3})-([0-9]{2})-([0-9]{2})$/" , $val, $full );
    
    if( is_array ($full) && (sizeof($full) > 0 )) {
        
        return $full[3].'/'. $full[2].'/'.$full[1];
    }  
    
    return $val;
 
}

function ssinShowDialog ( $ssin ) {
    
    preg_match("/[0-9][0-9](([0][0-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))(([0-9]{2}[1-9])|([0-9][1-9][0-9])|([1-9][0-9]{2}))(([0-8][0-9])|([9][0-7]))$/i" , $ssin, $matches );
    
    if( is_array ($matches) && (sizeof($matches) > 0 )) {
        
         return '<a href="index.php?env=member&amp;page=person&amp;action=display&amp;rn='.$ssin.'" class="rn">'.$ssin.'</a>';
    }  
    
    return $ssin ;
   
}

function translate ($attr = NULL) {
    
    global $elem ;

    if(isset( $elem->val->{$attr} ) ) {
        
        return iconv("UTF-8","ISO-8859-1", $elem->val->{$attr}) ;
    }
    
    return getNewDate( $attr ) ;
   
}

function noData ( $data ) {
       
    preg_match('/<div class="recit".*>(.*)<\/div>/' , $data, $matches );
     
    if( is_array ($matches) && (sizeof($matches) > 0 )) {
    
        return $data; 
    } 
    
    return $data . translate ('no_data') ;
}
 
?>
