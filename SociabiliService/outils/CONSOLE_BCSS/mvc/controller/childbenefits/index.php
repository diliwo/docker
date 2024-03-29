<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/childbenefits/index.php");

			break;
		
		default:
			header("Location: index.php?page=cachildbenefitsdnet&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=childbenefits&action=tester");
	
}