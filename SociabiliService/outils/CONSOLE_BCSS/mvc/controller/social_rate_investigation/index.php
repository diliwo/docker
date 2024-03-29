<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/social_rate_investigation/index.php");

			break;
		
		default:
			header("Location: index.php?page=social_rate_investigation&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=social_rate_investigation&action=tester");
	
}