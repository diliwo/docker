<?php

if(!isset($_SESSION['env']))
{
    $_SESSION['env'] = "";
}

switch ($_SESSION['env'])
{
	case 'aux1030':
		include_once 'includes/configs/database/aux1030.php';
		
		break;
		
	case 'mig1030':
		include_once 'includes/configs/database/mig1030.php';
		
		break;
		
	case 'mig1080':
		include_once 'includes/configs/database/mig1080.php';
		
		break;
	
	case 'nef1030':
		include_once 'includes/configs/database/nef1030.php';
		
		break;

	case 'mig7000':
		include_once 'includes/configs/database/mig7000.php';
		
		break;

default:
		include_once 'includes/configs/database/aux1030.php';
		
		break;
}