<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/taxi_as_v2/index.php");

			break;
		
		default:
			header("Location: index.php?page=taxi_as_v2&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=taxi_as_v2&action=tester");
	
}