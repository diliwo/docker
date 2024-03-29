<?php
ob_start();

// Récupération du tableau de configuration
include_once 'configs/global.config.php';
include_once 'configs/database.config.php';

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

// Configuration des objets Dbs
$dsn = $_config['database']['sgbd'] . ":";
if (!empty($_config['database']['host'])) {
	$dsn = $_config['database']['sgbd'] . ":host=" . $_config['database']['host'] . ";dbname=" . $_config['database']['dbname'];
} else {
	$dsn = $_config['database']['sgbd'] . ":dbname=" . $_config['database']['dbname'];
}
require_once 'application/model/data/db/log_db.php';
$logDb = new LogDb($dsn, $_config['database']['user'], $_config['database']['password'], $_config['database']['options']);

// Ajout du header
$title = $_config['title'];
include_once 'template/header.html';

// Vérification de l'état de maintenance de l'application
if (file_exists('maintenance.on')) {
	include_once 'application/maintenance.php';
	
} else {
	// Appel à l'application avec la structure MVC
	include_once 'application/index.php';
	
}

// Ajout du footer
$footer = $_config['footer'];
include_once 'template/footer.html';

ob_end_flush();
