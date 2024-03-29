<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/health_care_insurance/index.php");

			break;
		
		default:
			header("Location: index.php?page=health_care_insurance&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=health_care_insurance&action=tester");
	
}