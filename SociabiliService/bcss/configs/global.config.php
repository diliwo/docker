<?php

define('ENV', 'prod');

$_config['debug'] = false;
$_config['application_name'] = "B.C.S.S.";
$_config['title'] = "Flux B.C.S.S.";
$_config['footer'] = "CPAS de Schaerbeek - 70, Bld Auguste Reyers, 1030 Schaerbeek - 02/435.50.90";
$_config['timeout'] = 20000;

    $_config['url'] = "http://sociabili/bcsstest";
    


$_config['maintenance'] = "L'application est indisponible, veuillez réessayer un peu plus tard";

// Configuration de la session
include_once dirname(__FILE__) . '/session.config.php';
// Divers
include_once dirname(__FILE__) . '/divers.config.php';
// Version
include_once dirname(__FILE__) . '/version.config.php';
// Paramêtres des flux BCSS
include_once dirname(__FILE__) . '/flux.config.php';
