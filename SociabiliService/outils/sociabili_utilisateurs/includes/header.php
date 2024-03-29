<?php 

include_once 'includes/fonctions/base.php';
include_once 'includes/configs/base.php';
include_once 'includes/configs/jquery.php';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		<title><?php echo $titre_application; ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/png" href="<?php echo $baseUrl; ?>includes/images/favicon.png" />
	
		<!-- IE6 RESET -->
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>includes/css/reset.css" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>includes/css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>includes/css/custom.css" />
		<link rel="stylesheet" type="text/css" media="print" href="<?php echo $baseUrl;?>includes/css/print.css" />
		
		<!--  JQUERY -->
		<script type="text/javascript" src="<?php echo $baseUrl;?>includes/js/jquery-<?php echo $version_jquery; ?>.min.js"></script>
		
		<!-- JQUERY UI -->
		<link type="text/css" href="<?php echo $baseUrl;?>includes/css/smoothness/jquery-ui-<?php echo $version_jquery_ui; ?>.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $baseUrl;?>includes/js/jquery-ui-<?php echo $version_jquery_ui; ?>.custom.min.js"></script>
		
		<!-- DATATABLE -->
		<link type="text/css" href="<?php echo $baseUrl;?>includes/css/jquery.dataTables_themeroller.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $baseUrl;?>includes/js/jquery.dataTables.min.js"></script>
		
		<!-- JQUERY UI MULTISELECT -->
		<link type="text/css" href="<?php echo $baseUrl;?>includes/css/jquery.multiselect.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $baseUrl;?>includes/js/jquery.multiselect.min.js"></script>
		<link type="text/css" href="<?php echo $baseUrl;?>includes/css/jquery.multiselect.filter.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo $baseUrl;?>includes/js/jquery.multiselect.filter.js"></script>
	</head>

	<body>
		<div id="conteneur">
			<div id="banniere"></div>
