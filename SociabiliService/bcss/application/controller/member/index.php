<?php

if ($_SESSION[$_config['application_name']]['is_member'] == true) {
	switch ($_GET['page']) {
		case 'home':
			include_once 'application/view/' . $_GET['page'] . '.php';

			break;

		case 'person':
			include_once 'application/controller/' . $_GET['env'] . '/' . $_GET['page'] . '.php';

			break;

		default:
			header('Location: index.php?env=' . $_GET['env'] . '&page=person');

			break;
	}

} else {
	$url = "index.php";
	$first = true;
	foreach ($_GET as $key => $value) {
		if ($first) {
			$url .= "?";
			$first = false;
		} else {
			$url .= "&";
		}

		$url .= $key . "=" . $value;
	}

	$_SESSION[$_config['application_name']]['url_referer'] = $url;

	header('Location: index.php?env=public');
	
}
