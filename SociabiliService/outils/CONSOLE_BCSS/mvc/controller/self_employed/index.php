<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/self_employed/index.php");

			break;

		default:
			header("Location: index.php?page=self_employed&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=self_employed&action=tester");

}
