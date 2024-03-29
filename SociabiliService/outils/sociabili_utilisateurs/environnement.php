<?php

session_start();

include('includes/header.php');
if (file_exists('./maintenance.on'))
{
	include_once 'includes/maintenance.php';
}
else 
{
	if(isset($_SESSION['is_connected_'.$applicationName]) && ($_SESSION['is_connected_'.$applicationName])) 
	{
		$_SESSION['env'] = $_POST['env'];
	}
}
