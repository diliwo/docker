<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/list_of_attestation/index.php");

			break;
		
		default:
			header("Location: index.php?page=list_of_attestation&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=list_of_attestation&action=tester");
	
}