<?php

session_start();

// Support pour IIS
ob_start();

include('includes/header.php');
if (file_exists('./maintenance.on'))
{
	include_once 'includes/maintenance.php';
}
else
{
	require_once 'includes/fonctions/fonctions.php';
	include_once("includes/configs/database.php");

	if(isset($_SESSION['is_connected_'.$applicationName]) && ($_SESSION['is_connected_'.$applicationName]))
	{
		include('includes/menu.php');
	}
	else
	{
		include('includes/menu_vide.php');
	}

	switch($_GET['controlleur'])
	{
		case 'authentification':
			include_once 'controller/authentification.php';

			break;

		case 'utilisateurs':
			include_once 'controller/utilisateurs.php';

			break;

		case 'localisations':
			include_once 'controller/localisations.php';

			break;

		case 'groupes':
			include_once 'controller/groupes.php';

			break;

		case 'services':
			include_once 'controller/services.php';

			break;

		case 'services_localisations_groupes':
			include_once 'controller/services_localisations_groupes.php';

			break;

		default:
			include_once 'controller/index.php';

			break;

	}
}

include('includes/footer.php');

// Support pour IIS
ob_flush();
