<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		<title>Webservices ActiveDirectory PROD</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	</head>

	<body>

<?php

// première étape : désactiver le cache lors de la phase de test
ini_set("soap.wsdl_cache_enabled", "0");
 
// lier le client au fichier WSDL
$location = "http://" . $_SERVER['HTTP_HOST'] . "/ActiveDirectory";
$soapClient = new SoapClient($location . "?wsdl", array( 'wsdl_cache' => 0, 'trace' => 1));
$fonctions = $soapClient->__getFunctions();
$soapClientXml = new SoapClient($location . "/xml.php?wsdl", array( 'wsdl_cache' => 0, 'trace' => 1));
$fonctionsXml = $soapClientXml->__getFunctions();


echo "<h1>Documentation des webservices ActiveDirectory</h1>";
// Fonctions
echo "<fieldset style='width: 100%;'><legend>Fonctions (" . $location . ")</legend>";
echo "<p>Pour récupérer le WSDL, il suffit d'utiliser l'adresse suivante: <a href='" . $location . "?wsdl'>" . $location . "?wsdl</a></p>";
echo "<ul>";

foreach ($fonctions as $i=>$fonction) {
	echo "<li>" . $fonction . "</li>";
	
}

echo "</ul>";
echo "</fieldset>";

// Fonctions
echo "<fieldset style='width: 100%;'><legend>Fonctions XML (" . $location . "/xml.php)</legend>";
echo "<p>Pour récupérer le WSDL, il suffit d'utiliser l'adresse suivante: <a href='" . $location . "/xml.php?wsdl'>" . $location . "/xml.php?wsdl</a></p>";
echo "<ul>";

foreach ($fonctionsXml as $i=>$fonction) {
	echo "<li>" . $fonction . "</li>";

}

echo "</ul>";
echo "</fieldset>";

?>

	</body>
</html>
