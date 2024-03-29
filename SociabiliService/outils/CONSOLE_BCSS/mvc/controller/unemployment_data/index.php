<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/unemployment_data/index.php");

			break;
		
		default:
			header("Location: index.php?page=unemployment_data&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=unemployment_data&action=tester");
	
}