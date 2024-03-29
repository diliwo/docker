<?php

$controllers = array(
    'alert_reaction' => array(
        'name' => 'AlertReaction',
        'description' => 'D\'envoyer une motivation clignotant à la BCSS.'
    ),
	'identify_person' => array(
		'name' => 'IdentifyPerson',
		'description' => 'Identification simplifiée de la personne.'
	),
	'manage_access' => array(
		'name' => 'ManageAccess',
		'description' => 'Gestion des intégrations/désintégrations de la personne.'
	),
	'dimona' => array(
		'name' => 'Dimona',
		'description' => 'Dimona (Déclaration Immédiate/Onmiddellijke Aangifte) des entrées et sorties de service d\'un travailleur.'
	),
	'transaction25_v1' => array(
		'name' => 'RetrieveTiGroups - V1',
		'description' => 'Informations diverses sur la personne.'
	),
	'transaction25_v2' => array(
		'name' => 'RetrieveTiGroups - V2',
		'description' => 'Informations diverses sur la personne.'
	),
	'unemployment_data_v1' => array(
		'name' => 'UnemploymentData - V1',
		'description' => 'Consultation auprès de l’ONEM des données relatives au revenu de remplacement provenant du chômage.'
	),
	'unemployment_data_v2' => array(
		'name' => 'UnemploymentData - V2',
		'description' => 'Consultation auprès de l’ONEM des données relatives au revenu de remplacement provenant du chômage.'
	),
    'unemployment_data_v3' => array(
        'name' => 'UnemploymentData - V3',
        'description' => 'Consultation auprès de l’ONEM des données relatives au revenu de remplacement provenant du chômage.'
    ),
	'handiflux' => array(
		'name' => 'HandiFlux',
		'description' => 'Données de la DGPH (Direction Générale de la Personnes Handicapées).'
	),
	'health_care_insurance' => array(
		'name' => 'HealthCareInsurance',
		'description' => 'Données sur l\'assurabilité de la personne auprès des mutuelles.'
	),  
	'taxi_as_v1' => array(
		'name' => 'TaxAssessmentData - V1',
		'description' => 'Avertissement extrait de rôle.'
	),
    'taxi_as_v2' => array(
        'name' => 'TaxAssessmentData - V2',
        'description' => 'Avertissement extrait de rôle.'
    ),
	'social_rate_investigation' => array(
		'name' => 'SocialRateInvestigation',
		'description' => 'Tarif social auprès des fournisseurs d\'électricité et de gaz.'
	),
	'cadnet' => array(
		'name' => 'Cadnet',
		'description' => 'Données cadastrales de la personne.'
	),
    'patrimony_service' => array(
        'name' => 'PatrimonyService',
        'description' => 'Consultation les données du patrimoine d\'une personne ou entreprise'
    ),
    'self_employed_v1' => array(
        'name' => 'SelfEmployed - V1',
        'description' => 'Données des indépendants'
    ),
    'self_employed_v2' => array(
        'name' => 'SelfEmployed - V2',
        'description' => 'Données des indépendants'
    ),
    'retrieve_ti_groups_v1' => array(
        'name' => 'RetrieveTiGroups - V1',
        'description' => 'RETRIEVE TI GROUPS SERVICE'
    ),
    'retrieve_ti_groups_v2' => array(
        'name' => 'RetrieveTiGroups - V2',
        'description' => 'RETRIEVE TI GROUPS SERVICE'
    ),
	'list_of_attestation' => array(
		'name' => 'ListOfAttestation',
		'description' => 'Listing des attestations de la personne.'
	),
	'dolsis' => array(
		'name' => 'Dolsis',
		'description' => 'Accès direct aux données de l\'ONSS.'
	),
	'pension_register' => array(
		'name' => 'PensionRegister',
		'description' => 'Ouverture du cadastre des pensions.'
	),
    'family_allowances_service' => array(
        'name' => 'Family Allowances Service',
        'description' => ' Consultation sur les allocations familiales. ( This web service is not authorized to use! )'
    ), 
    'childbenefits' => array(
        'name' => 'Child Benefits',
        'description' => ' Child Benefits - Consultation sur les allocations familiales  '
    ),
    'living_wages' => array(
        'name' => 'LivingWages',
        'description' => ' Consultation qui permet de regrouper les attestations multifonctionnelles par période ininterrompue, par CPAS et par type d\'aide financière  '
    ),
);

if (isset($_GET['page']) && array_key_exists($_GET['page'], $controllers)) {
	echo '<h1 class="page-header">';
		echo $controllers[$_GET['page']]['name'];
		switch ($_SESSION['test_flux_bcss']['env']) {
			case 'test': echo ' <small><span class="text-success">(test)</span></small>'; break;
			case 'acpt': echo ' <small><span class="text-warning">(acceptation)</span></small>'; break;
			case 'prod': echo ' <small><span class="text-danger">(production)</span></small>'; break;
		}
	echo '</h1>';

	echo '<p class="lead">';
		echo $controllers[$_GET['page']]['description'];
	echo '</p>';

	include_once('mvc/controller/' . $_GET['page'] . '/index.php');
} else {
	header("Location: index.php?page=identify_person");
	exit;
}
