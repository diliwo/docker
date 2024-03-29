<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/identify_person/index.php");

			break;
		
		default:
			header("Location: index.php?page=identify_person&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=identify_person&action=tester");
	
}