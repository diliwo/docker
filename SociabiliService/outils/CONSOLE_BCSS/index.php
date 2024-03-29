<?php

ob_start();

session_start();

if (isset($_GET['env'])) {
	if (!empty($_GET['env'])) {
		$_SESSION['test_flux_bcss']['env'] = $_GET['env'];
	} else {
		$_SESSION['test_flux_bcss']['env'] = "test";
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
} else {
	if (isset($_SESSION['test_flux_bcss']['env'])) {
		if (empty($_SESSION['test_flux_bcss']['env'])) {
			$_SESSION['test_flux_bcss']['env'] = "test";
		}
	} else {
		$_SESSION['test_flux_bcss']['env'] = "test";
	}
}

$_CONFIG["url"] = "http://" . $_SERVER["HTTP_HOST"] . str_replace("index.php", "", $_SERVER["PHP_SELF"]);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Console BCSS</title>

		<link href="include/css/default.css" rel="stylesheet">
		<link rel="stylesheet" href="lib/responsejsonviewer/css/responsejsonviewer.css">
		
		<!-- Bootstrap -->
		<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="lib/bootstrapvalidator/css/bootstrapValidator.css" rel="stylesheet">
		<link href="lib/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">

		<link href="lib/json.human/css/json.human.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<script src="lib/jquery/jquery-1.11.0.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="lib/jquery/validate/jquery.validate.min.js"></script>
		<script src="lib/jquery/validate/localization/messages_fr.js"></script>
		<script src="lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="lib/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js"></script>

		<?php include_once("template/header.php"); ?>
		<div class="container">
			<?php include_once("mvc/index.php"); ?>
		</div>
		
		<?php include_once("template/footer.php"); ?>

		<div id="windowMainAjaxOverlay" style="display: none;">
			<img src="include/img/ajax-loader.gif">
		</div>

		<script src="lib/bootstrap/js/bootstrap.min.js"></script>
		<script src="lib/bootstrapvalidator/js/bootstrapValidator.js"></script>

		<script src="lib/prettyPrint.js"></script>
		<script src="lib/json.human/js/crel.js"></script>
		<script src="lib/json.human/js/json.human.js"></script>
		<script src="lib/RegistreNational.js"></script>
		<script src="include/js/default.js"></script>
		
		<!-- Ouvrir les réponses et les transferts dans une nouvelle fenêtre -->
		<div id="responseshow" style="display: none;">
			<div id="responsejson" class="responsejson"></div>
			<script type="text/javascript" src="lib/responsejsonviewer/responsejsonviewer.js"></script>
		</div>
	
</html>

<?php
ob_end_flush();
?>