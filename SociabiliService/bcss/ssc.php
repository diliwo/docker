<?php
ob_start();

// Récupération du tableau de configuration
include_once 'configs/global.config.php';

// Debug
if ((isset($_config["debug"])) && ($_config["debug"] == true)) {
	error_reporting(E_ALL ^ E_NOTICE);
	
} else {
	error_reporting(0);
	
}

// Démarrage de la session
if (file_exists($_config['session']['dir_path']) == false) {
	mkdir($_config['session']['dir_path']);
}
session_set_cookie_params($_config['session']['lifetime']);
ini_set('session.gc_maxlifetime', $_config['session']['lifetime']);
ini_set('session.save_path', $_config['session']['dir_path']);
session_start();

// Data
include_once 'configs/ldap.config.php';
require_once 'includes/lib/adLdap/adLDAP.php';
$adldap = new adLDAP(
	array(
		'domain_controllers' => $_config['ldap']['domain_controllers'],
		'base_dn' => $_config['ldap']['base_dn'],
		'account_suffix' => $_config['ldap']['account_suffix']
	)
);

// Ajout du header
$title = $_config['title'];
include_once 'template/header.html';

// Vérification de l'état de maintenance de l'application
if (file_exists('maintenance.on')) {
	include_once 'application/maintenance.php';
	
} else {
	include_once 'application/controller/public/authentication_ssc.php';
	
}

// Ajout du footer
$footer = $_config['footer'];
include_once 'template/footer.html';

ob_end_flush();
