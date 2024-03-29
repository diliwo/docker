<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/manage_access/index.php");

			break;
		
		default:
			header("Location: index.php?page=manage_access&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=manage_access&action=tester");
	
}