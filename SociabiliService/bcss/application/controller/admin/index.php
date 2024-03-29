<?php

if ($_SESSION[$_config['application_name']]['is_admin'] == true) {
	switch ($_GET['page']) {
		case 'home':
			include_once 'application/view/' . $_GET['page'] . '.php';
			
			break;
		
		default:
			header('Location: index.php?env=' . $_GET['env'] . '&page=home');
			
			break;
	}
	
} else {
	header('Location: index.php?env=member');
	
}
