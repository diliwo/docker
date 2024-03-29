<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/handiflux/index.php");

			break;
		
		default:
			header("Location: index.php?page=handiflux&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=handiflux&action=tester");
	
}