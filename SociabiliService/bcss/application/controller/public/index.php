<?php

switch ($_GET['page']) {
	case 'authentication':
		include_once 'application/controller/' . $_GET['env'] . '/' . $_GET['page'] . '.php';
		
		break;
	
	default:
		header('Location: index.php?env=' . $_GET['env'] . '&page=authentication');
		
		break;
}
