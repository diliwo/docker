<?php

if (isset($_GET["env"])) {
	switch($_GET["env"]) {
		case "member":
			include_once 'mvc/controller/member/index.php';
			
			break;
			
		case "admin":
			include_once 'mvc/controller/admin/index.php';
			
			break;
		
		default:
			header('Location: index.php');
			
			break;
	}

} else {
	include_once 'mvc/controller/index.php';

}
