<?php
/*
header("Content-Type: application/json");
ini_set("default_socket_timeout", 15);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$expl = explode('\\', getcwd() );
$src = array_search( 'api', $expl );
$slc = array_slice( $expl, 0, $src );
$cwd = implode('/', $slc).'/include/soapConnect/soapConnect.php' ;

if(!file_exists($cwd)) {
    
    echo json_encode(array("succes" => "0"));
    exit;
    
}
 
function getAddress($path) {
    
    $url = parse_url($_SERVER["PHP_SELF"]);
    
    if(isset( $url['path'] )) {
        
        $key = preg_split("/[\/]+/", $url['path'], PREG_SPLIT_OFFSET_CAPTURE);
        return $_SERVER["HTTP_HOST"].'/'.implode('/', array_slice($key, 1, -1)).$path;
        
    }
    
    return false;
    
}
*/

?>