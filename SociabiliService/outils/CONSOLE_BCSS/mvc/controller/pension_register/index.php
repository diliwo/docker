<?php

if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case "tester":
			include_once("mvc/view/pension_register/index.php");

			break;

		default:
			header("Location: index.php?page=pension_register&action=tester");

			break;
	}
} else {
	header("Location: index.php?page=pension_register&action=tester");

}
