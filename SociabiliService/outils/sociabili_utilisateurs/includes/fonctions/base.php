<?php

// Récupération des variables de chemin
$baseUrl 			= 'http://'.$_SERVER['HTTP_HOST'].str_replace(array('Index.php','index.php'), '', $_SERVER['SCRIPT_NAME']);
$baseFolder 		= str_replace(array('Index.php','index.php'), '', $_SERVER['SCRIPT_FILENAME']);
$urls 				= explode('/', $baseFolder);
$applicationName 	= "sociabili_utilisateurs";