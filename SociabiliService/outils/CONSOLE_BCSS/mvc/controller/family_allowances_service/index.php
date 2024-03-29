<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/family_allowances_service/index.php");

			break;
		
		default:
			header("Location: index.php?page=family_allowances_service&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=family_allowances_service&action=tester");
	
}