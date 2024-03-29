<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/unemployment_data_v3/index.php");

			break;
		
		default:
			header("Location: index.php?page=unemployment_data_v3&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=unemployment_data_v3&action=tester");
	
}