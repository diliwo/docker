<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/alert_reaction/index.php");

			break;
		
		default:
			header("Location: index.php?page=alert_reaction&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=alert_reaction&action=tester");
	
}