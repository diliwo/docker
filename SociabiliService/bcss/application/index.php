<?php

switch ($_GET['env']) {
	case "public":
		include_once 'template/menu/public.html';
		include_once 'application/controller/public/index.php';
		
		break;
		
	case "member":
		if (isset($_SESSION[$_config['application_name']]['from_ssc'])) {
			include_once 'template/menu/ssc.html';
			
		} else {
			include_once 'template/menu/member.html';
			
		}
		include_once 'application/controller/member/index.php';
		
		break;
		
	case "admin":
		include_once 'template/menu/admin.html';
		include_once 'application/controller/admin/index.php';
		
		break;
	
	default:
		header('Location: index.php?env=public');
		
		break;
}