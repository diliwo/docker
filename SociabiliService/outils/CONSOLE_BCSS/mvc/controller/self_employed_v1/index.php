<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/self_employed_v1/index.php");

			break;

		default:
			header("Location: index.php?page=self_employed_v1&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=self_employed_v1&action=tester");

}
