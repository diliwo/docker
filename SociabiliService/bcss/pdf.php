<?php
ob_start();

// Récupération du tableau de configuration
include_once 'configs/global.config.php';
include_once 'configs/database.config.php';

// Debug
if ((isset($_config["debug"])) && ($_config["debug"] == true)) {
	error_reporting(E_ALL ^ E_NOTICE);
	
} else {
	error_reporting(0);
	
}

// Démarrage de la session
if (file_exists($_config['session']['dir_path']) == false) {
	mkdir($_config['session']['dir_path']);
}
session_set_cookie_params($_config['session']['lifetime']);
ini_set('session.gc_maxlifetime', $_config['session']['lifetime']);
ini_set('session.save_path', $_config['session']['dir_path']);
session_start();

// Data
require_once 'application/model/personne.php';
// PDF
require_once 'includes/lib/mpdf/mpdf.php';
//FLUX
require_once 'application/model/data/flux/attestation_flux.php';
require_once 'application/model/data/flux/identify_person_flux.php';
require_once 'application/model/data/flux/cadaf_flux_old.php';
require_once 'application/model/data/flux/cadnet_flux.php';
require_once 'application/model/data/flux/dimona_flux.php';
require_once 'application/model/data/flux/healthinsurance_flux.php';
require_once 'application/model/data/flux/manage_access_flux.php';
require_once 'application/model/data/flux/transaction25_flux.php';
//ATTESTATIONS
require_once 'application/model/data/flux/attestations/datetime_attestations.php';
//CADAF
require_once 'application/model/data/flux/cadaf/date_cadaf.php';
require_once 'application/model/data/flux/cadaf/periode_cadaf.php';
//CADNET
require_once 'application/model/data/flux/cadnet/datetime_cadnet.php';
require_once 'application/model/data/flux/cadnet/detail_revenu_cadastral_cadnet.php';
//DIMONA
require_once 'application/model/data/flux/dimona/periode_dimona.php';
//HEALTHINSURANCE
require_once 'application/model/data/flux/healthinsurance/periode_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/regime_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/statut_social_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/intervention_majoree_healthinsurance.php';
//IDENTIFY_PERSON
require_once 'application/model/data/flux/identify_person/date_identify_person.php';
require_once 'application/model/data/flux/identify_person/adresse_identify_person.php';
//TRANSACTION25
require_once "application/model/data/flux/transaction25/date_transaction25.php";
require_once "application/model/data/flux/transaction25/adresse_transaction25.php";
require_once "application/model/data/flux/transaction25/adresse_type_transaction25.php";
require_once "application/model/data/flux/transaction25/emetteur_transaction25.php";
require_once "application/model/data/flux/transaction25/identification_passeport_transaction25.php";
require_once "application/model/data/flux/transaction25/lieu_transaction25.php";
require_once "application/model/data/flux/transaction25/nom_complet_transaction25.php";
require_once "application/model/data/flux/transaction25/numero_national_transaction25.php";

// Configuration des objets Dbs
$dsn = $_config['database']['sgbd'] . ":";
if (!empty($_config['database']['host'])) {
	$dsn = $_config['database']['sgbd'] . ":host=" . $_config['database']['host'] . ";dbname=" . $_config['database']['dbname'];
} else {
	$dsn = $_config['database']['sgbd'] . ":dbname=" . $_config['database']['dbname'];
}
require_once 'application/model/data/db/entreprise_db.php';
require_once 'application/model/data/db/institution_db.php';
require_once 'application/model/data/db/mutuelle_db.php';
require_once 'application/model/data/db/cp_ins_db.php';
$entrepriseDb = new EntrepriseDb($dsn, $_config['database']['user'], $_config['database']['password'], $_config['database']['options']);
$institutionDb = new InstitutionDb($dsn, $_config['database']['user'], $_config['database']['password'], $_config['database']['options']);
$mutuelleDb = new MutuelleDb($dsn, $_config['database']['user'], $_config['database']['password'], $_config['database']['options']);
$cpInsDb = new CpInsDb($dsn, $_config['database']['user'], $_config['database']['password'], $_config['database']['options']);

// Appel au script ajax.php
$action = null;
if ((isset($_GET['action'])) && (!empty($_GET['action']))) {
	$action = $_GET['action'];
}

switch ($action) {
	case 'flux_identify_person':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
			
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
			
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_transaction25':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn . '&only_all=1');
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_cadaf':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_cadnet':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_healthinsurance':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_attestations':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_dimona':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_integrations':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=' . $action .'&rn=' . $rn);
				
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = $action . '-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	case 'flux_tous':
		if (isset($_GET['rn'])) {
			$rn = $_GET['rn'];
			$nomFamille = $_GET['nom_famille'];
			$dateNaissance = $_GET['date_naissance'];
			
			$html = "<h1>Flux B.C.S.S.</h1>";
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_identify_person&rn=' . $rn);
			// TRANSACTION25
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_transaction25&rn=' . $rn);
			// CADAF
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_cadaf&rn=' . $rn);
			// CADNET
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_cadnet&rn=' . $rn);
			// HEALTHINSURANCE
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_healthinsurance&rn=' . $rn);
			// ATTESTATIONS
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_attestations&rn=' . $rn);
			// INTEGRATIONS
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_integrations&rn=' . $rn . '&nom_famille=' . $nomFamille . '&date_naissance=' . $dateNaissance);
			// DIMONA
			$html .= file_get_contents('http://localhost/bcss/ajax.php?action=flux_dimona&rn=' . $rn);
			
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
				
			$nom_pdf = 'flux_tous-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		break;
		
	default:
		if (isset($_POST['html_content']) && !empty($_POST['html_content'])) {
			$rn = $_GET['rn'];
			$html = "<style type='text/css'><!-- @IMPORT URL('includes/css/print.css'); --></style>";
			$html .= $_POST['html_content'];
			
			$mpdf = new mPDF();
			$mpdf->WriteHTML($html);
			
			$nom_pdf = 'flux_bcss-' . $rn .'-'.date('Ymd').'.pdf';
			$mpdf->Output($nom_pdf, 'D');
		}
		
		
		break;
}

ob_end_flush();

function objectToArray($d) {
	if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}