<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/includes/class/active_directory.php';
include_once dirname(__FILE__) . '/includes/config/active_directory.php';

$activeDirectory = new ActiveDirectory($_config['ldap']['hostname'], $_config['ldap']['baseDn'], $_config['ldap']['accountSuffix'], $_config['ldap']['login'], $_config['ldap']['password']);

$login = "Usr-aux1030";
$res = $activeDirectory->getGroupesParSamaccountname($login);

echo "<pre>";
print_r($res);
echo "</pre>";
