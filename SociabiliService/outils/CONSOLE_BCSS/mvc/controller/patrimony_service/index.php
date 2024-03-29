<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/patrimony_service/index.php");

			break;
		
		default:
			header("Location: index.php?page=patrimony_service&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=patrimony_service&action=tester");
	
}