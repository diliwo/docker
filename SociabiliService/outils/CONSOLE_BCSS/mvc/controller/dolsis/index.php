<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/dolsis/index.php");

			break;
		
		default:
			header("Location: index.php?page=dolsis&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=dolsis&action=tester");
	
}