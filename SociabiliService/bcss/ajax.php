<?php

ob_start();
error_reporting(E_ALL);
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
//FLUX
require_once 'application/model/data/flux/attestation_flux.php';
require_once 'application/model/data/flux/identify_person_flux.php';
require_once 'application/model/data/flux/cadaf_flux.php';
require_once 'application/model/data/flux/cadnet_flux.php';
require_once 'application/model/data/flux/dimona_flux.php';
require_once 'application/model/data/flux/healthinsurance_flux.php';
require_once 'application/model/data/flux/healthcare_insurance_flux.php';
require_once 'application/model/data/flux/unemployment_data_flux.php';
require_once 'application/model/data/flux/handi_flux.php';
require_once 'application/model/data/flux/manage_access_flux.php';
require_once 'application/model/data/flux/transaction25_flux.php';
require_once 'application/model/data/flux/reference_manager_facade_flux.php';
require_once 'application/model/data/flux/taxi_as_flux.php';
require_once 'application/model/data/flux/dolsis_flux.php';
require_once 'application/model/data/flux/social_rate_investigation_flux.php';
require_once 'application/model/data/flux/pension_register_flux.php';
//SOCIAL_RATE_INVESTIGATION
require_once 'application/model/data/flux/social_rate_investigation/adresse_social_rate_investigation.php';
//ATTESTATIONS
require_once 'application/model/data/flux/attestations/datetime_attestations.php';
//UNEMPLOYMENT_DATA
require_once 'application/model/data/flux/unemployment_data/date_unemployment_data.php';
require_once 'application/model/data/flux/unemployment_data/description_unemployment_data.php';
//SELFEMPLOYED
require_once 'application/model/data/flux/self_employed_flux.php';
//CADAF
require_once 'application/model/data/flux/cadaf/date_cadaf.php';
require_once 'application/model/data/flux/cadaf/periode_cadaf.php';
//CADNET
require_once 'application/model/data/flux/cadnet/personne_cadnet.php';
require_once 'application/model/data/flux/cadnet/adresse_cadnet.php';
require_once 'application/model/data/flux/cadnet/datetime_cadnet.php';
require_once 'application/model/data/flux/cadnet/detail_revenu_cadastral_cadnet.php';
//DIMONA
require_once 'application/model/data/flux/dimona/periode_dimona.php';
//HEALTHINSURANCE
require_once 'application/model/data/flux/healthinsurance/periode_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/regime_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/statut_social_healthinsurance.php';
require_once 'application/model/data/flux/healthinsurance/intervention_majoree_healthinsurance.php';
//HEALTHCARE_INSURANCE
require_once 'application/model/data/flux/healthcare_insurance/periode_healthcare_insurance.php';
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
// Charset
if ((isset($_config['database']['charset'])) && (!empty($_config['database']['charset']))) {
    $dsn .= ";charset=" . $_config['database']['charset'];
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
            
            $flux = new IdentifyPersonFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            
            if ($flux->connexion()) {
                $res = $flux->getPersonneParRn( $rn );
                
                include_once 'scripts/ajax/flux/identify_person.php';
            }
            
        }
        break;
        
    case 'flux_transaction25':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            // récupération du wsdl
            if ($_config['version']['transaction25'] == 1) {
                $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/transaction25/v" . $_config['version']['transaction25'] . "/" . ENV . "/v5/RetrieveTIGroupsV5.wsdl";
            
            } else {
                $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/transaction25/v" . $_config['version']['transaction25']. "/" . ENV . "/be/fgov/kszbcss/intf/RetrieveTIGroupsService/RetrieveTIGroupsV" . $_config['version']['transaction25'] . ".wsdl";
            
            }
                
            $flux = new Transaction25Flux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
            );
            
            if ($flux->connexion($wsdl)) {
                $res = $flux->getTis( $rn, $nomTis );
                
                if (isset($_GET['only_all'])) {
                    include_once 'scripts/ajax/flux/transaction25_tous.php';
                    
                } else {
                    include_once 'scripts/ajax/flux/transaction25.php';
                    
                }
                
            }
            
        }
        
        break;
        
    case 'flux_cadaf':
        /*
         if (isset($_GET['rn'])) {
         $rn = $_GET['rn'];
         
         $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/cadaf/" . ENV . "/FamilyAllowancesConsultation.wsdl";
         $flux = new CadafFlux(
         ENV,
         $_config["flux"]["cbe_number"],
         $_config["flux"]["secteur"],
         $_config["flux"]["institution"],
         $_config["flux"]["numero_organisation"],
         $_config["flux"]["soa"]["username"],
         $_config["flux"]["soa"]["password"]
         );
         if ($flux->connexion($wsdl)) {
         $dateFin = new DateTime();
         $dateDebut = clone $dateFin;
         $dateDebut->modify('-59 months');
         
         $res = $flux->getDossiers($rn, $dateDebut->format('d/m/Y'), $dateFin->format('d/m/Y'));
         
         include_once 'scripts/ajax/flux/cadaf.php';
         }
         }
         */
        break;
        
    case 'flux_cadnet':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/cadnet/" . ENV . "/ConsultPatrimonyCPASV1.wsdl";
            $flux = new CadnetFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                $res = $flux->getProprietes($rn);
                
                if (!isset($res['data']->property)) {
                    
                    $res['data'] = new stdClass();
                    $rnPartenaire = (isset( $res['data']->person->partnerIdentity->ssin ) ? $res['data']->person->partnerIdentity->ssin : NULL) ;
                    $resPartenaire = $flux->getProprietes($rnPartenaire);
                    
                    $resPartenaire['data'] = new stdClass();
                    $res['data']->property = (isset($resPartenaire['data']->property) ? $resPartenaire['data']->property : NULL );
                    
                    
                }
                
                include_once 'scripts/ajax/flux/cadnet.php';
            }
        }
        
        break;
        
    case 'flux_healthinsurance':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $flux = new HealthinsuranceFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            if ($flux->connexion()) {
                $dateFin = new DateTime();
                $dateDebut = clone $dateFin;
                $dateDebut->modify("-5 years");
                
                $assurabilites = $flux->getAssurabilites($rn);
                
                include_once 'scripts/ajax/flux/healthinsurance.php';
            }
        }
        
        break;
        
    case 'flux_healthcare-insurance':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/healthcare_insurance/" . ENV . "/2013HealthCareInsurance.wsdl";
            $flux = new HealthcareInsuranceFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                // Récupération des données
                $donneesDemandees = array(
                    "insuringOrganization",
                    "reimbursementRight",
                    "ct1ct2",
                    "payingThirdParty",
                    "maximumCharge",
                    "medicalHouse",
                    "increasedIntervention",
                    "statusComplementaryInsurance",
                    "globalMedicalFile",
                    "sfdfL891"
                );
                
                // Assurabilité actuellement
                $today = new DateTime();
                $assurabilites = $flux->getAssurabilites($rn, $today->format("Y-m-d"), $donneesDemandees);
                
                // Assurabilité l'année passée
                $date = clone $today;
                $date->modify("-1 year");
                
                // Recherche de l'assurabilité du passé
                $fin = false;
                $i = 0;
                $assurabilitesPasse = array();
                while ($fin==false) {
                    $assurabilitessPasse[$i] = $flux->getAssurabilites($rn, $date->format("Y-m-d"), $donneesDemandees);
                    if (isset($assurabilitessPasse[$i]["data"]->ct1ct2->period->endDate)) {
                        // explode date_fin
                        $dateFinTemp = explode("-", $assurabilitessPasse[$i]["data"]->ct1ct2->period->endDate);
                        $date->setDate($dateFinTemp[0], $dateFinTemp[1], $dateFinTemp[2]);
                        
                        // Test de la continuité de la recherche de l'assurabilité du passé
                        $date->modify("+1 day");
                        $fin = ($date<$today)?false:true;
                        
                    } else {
                        $fin = true;
                        
                    }
                    $i++;
                    
                }
                
                // Renversement du tableau pour trier par ordre décroissant des dates
                $assurabilitessPasse = array_reverse($assurabilitessPasse);
                
                include_once 'scripts/ajax/flux/healthcare-insurance.php';
            }
            
        }
        
        break;
        
    case 'flux_unemployment_data-': 
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/unemployment_data/" . ENV . "/v" . $_config['version']['unemployment_data'] . "/UnemploymentDataV" . $_config['version']['unemployment_data'] . ".wsdl";
            if ($_config['version']['unemployment_data'] == 1)
                $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/unemployment_data/" . ENV . "/v1/UnemploymentDataServiceV1.wsdl";
                
                $flux = new UnemploymentData(
                    ENV,
                    $_config["flux"]["cbe_number"],
                    $_config["flux"]["secteur"],
                    $_config["flux"]["institution"],
                    $_config["flux"]["numero_organisation"],
                    $_config["flux"]["soa"]["username"],
                    $_config["flux"]["soa"]["password"]
                    );
                if ($flux->connexion($wsdl)) {
                    $today = new DateTime();
                    
                    // On récupère la situation de la personne
                    $situation = $flux->getSituation($rn);
                    $situationToday = $flux->getSituation($rn, $today->format("Y-m-d"));
                    if (isset($situation['data'])) {
                        $dateFin = clone $today;
                        $dateDebut = clone $dateFin;
                        $dateDebut->modify("-2 year");
                        
                        $sommesPayees = $flux->getSommesPayees($rn, $dateDebut->format("Y-m"), $dateFin->format("Y-m"));
                        uasort($sommesPayees['data']['payedSum'], "compareSommesPayees");
                        
                        // On désactive temporairement pour avoir un jeu de test
                        // -----------------------------------------------------
                        //
                        //$sommesPayeesAllocationsActivation = $flux->getSommesPayeesAllocationsActivation($rn, $dateDebut->format("Y-m"), $dateFin->format("Y-m"));
                        //uasort($sommesPayeesAllocationsActivation['data']['payedActivationSum'], "compareSommesPayees");
                        
                    }
                    
                    include_once 'scripts/ajax/flux/unemployment_data.php';
                }
        }
        
        break;
        
    case 'flux_handi':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/handiflux/" . ENV . "/2013_Handi.wsdl";
            $flux = new HandiFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                $today = new DateTime();
                
                // On récupère la situation de la personne
                $situation = $flux->getData($rn, $today->format("Y-m-d"));
                
                include_once 'scripts/ajax/flux/handiflux.php';
            }
        }
        
        break;
        
    case 'flux_attestations':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $flux = new AttestationFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            if ($flux->connexion()) {
                //$dateFin = new DateTime(date("Y") . "-12-31");
                $dateFin = new DateTime();
                $dateFin->modify("+1 year");
                $dateDebut = clone $dateFin;
                $dateDebut->modify('-5 years');
                $dateDebut->modify('+1 year');
                
                $exonerations_art35 = $flux->getExonerationsArt35($rn, $dateDebut->format('d/m/Y'), $dateFin->format('d/m/Y'));
                $primeInstallation = $flux->getPrimeInstallation($rn, $dateDebut->format('d/m/Y'), $dateFin->format('d/m/Y'));
                $nextAnswerReference = "";
                $all_attestations_a036 = array();
                
                do {
                    $attestations_a036 = $flux->getArttestationsA036($rn, $dateDebut->format('d/m/Y'), $dateFin->format('d/m/Y'), "fr" , $nextAnswerReference);
                    $nextAnswerReference = $attestations_a036['data']['nextAnswerReference'];
                    
                    $all_attestations_a036 = array_merge($all_attestations_a036, $attestations_a036['data']['attestations']);
                    
                } while(!empty($nextAnswerReference));
                
                $attestations_a036['data']['attestations'] = $all_attestations_a036;
                $attestations_a036['data']['attestations'] = array_reverse($attestations_a036['data']['attestations']);
                //print_r($attestations_a036['data']['attestations']);
                $piis = $flux->getPiis($rn);
                
                include_once 'scripts/ajax/flux/attestations.php';
            }
        }
        
        break;
        
    case 'flux_dimona':
        
        
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $flux = new DimonaFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            if ($flux->connexion()) {
                $dateFin = new DateTime(date("Y") . "-12-31");
                $dateDebut = clone $dateFin;
                $dateDebut->modify('-10 years');
                $dateDebut->modify('+1 day');
                
                $first = $flux->getActivites($rn, $dateDebut->format("d/m/Y"), $dateFin->format("d/m/Y"));
                $numeroPremiereLigne = $first['numero_premiere_ligne'];
                $ticket = $first['ticket'];
                $data = $first['data'];
                $diff = $first['nb_activites'] - $first['nb_activites_incluses'];
                $nbTours = ceil($first['nb_activites'] / 32) - 1;
                
                for($i=0; $i<$nbTours; $i++) {
                    if ($diff > 32) {
                        $nbReponses = 32;
                    } else {
                        $nbReponses = $diff;
                    }
                    
                    $other = $flux->getActivites($rn, $dateDebut->format("d/m/Y"), $dateFin->format("d/m/Y"), $nbReponses, $numeroPremiereLigne, $ticket);
                    $numeroPremiereLigne = $other['numero_premiere_ligne'];
                    $ticket = $other['ticket'];
                    $data = array_merge($data, $other['data']);
                    $diff -= $other['nb_activites_incluses'];
                    
                }
                uasort($data, "compareActivites");
                
                $activites['succes'] = 1;
                $activites['data'] = $data;
                
                
                
                
                include_once 'scripts/ajax/flux/dimona.php';
            }
        }
        
        break;
        
    case 'flux_dolsis':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/dolsis/". ENV ."/dolsis2011CBSS_subsetPSWC.wsdl";
            $flux = new DolsisFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            
            if ($flux->connexion($wsdl)) {
                $activites = $flux->getActivites($rn, "mutations");
                
                // Si erreur, on test avec un intervalle de 2ans
                if ($activites["error"]) {
                    $dateFin = new DateTime();
                    $dateFin->modify("+1 year");
                    $dateDebut = clone $dateFin;
                    $dateDebut->modify('-2 years');
                    $activites = $flux->getActivites($rn, "mutations", $dateDebut->format("d/m/Y"), $dateFin->format("d/m/Y"));
                }
                
                
                include_once 'scripts/ajax/flux/dolsis.php';
                
            }
        }
        
        break;
        
    case 'flux_integrations':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            $nomFamille = $_GET['nom_famille'];
            $dateNaissance = $_GET['date_naissance'];
            
            $libelleCodes[1]	= "Dossier en cours";
            $libelleCodes[2]	= "Revenu d'Intégration Sociale";
            $libelleCodes[3]	= "Equivalent RIS";
            $libelleCodes[4]	= "Autre aide financière";
            $libelleCodes[5]	= "Sans aide";
            $libelleCodes[6]	= "Article 60";
            $libelleCodes[40]	= "Fond mazout";
            
            $flux = new ManageAccessFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            if ($flux->connexion()) {
                $now = new DateTime();
                $past = clone $now;
                $past->modify("-5 years");
                $integrations = $flux->getIntegrations($rn, $nomFamille, $dateNaissance, $past->format('d/m/Y'));
                
                include_once 'scripts/ajax/flux/integrations.php';
                
                $integrationsHorsSecteur = array();
                $flux2 = new ReferenceManagerFacadeFlux(
                    ENV,
                    $_config["flux"]["cbe_number"],
                    $_config["flux"]["secteur"],
                    $_config["flux"]["institution"],
                    $_config["flux"]["numero_organisation"],
                    $_config["flux"]["old"]["user_id"],
                    $_config["flux"]["old"]["email"]
                    );
                if ($flux2->connexion()) {
                    $dateDebutIntegration = $integrations[0]->get('date_debut');
                    $dateFinIntegration = $integrations[0]->get('date_fin');
                    $dateDebut = DateTime::createFromFormat('d/m/Y', $integrations[(count($integrations) - 1)]->get('date_debut'));
                    $dateDebut->modify("-1 year");
                    $dateFin = new DateTime();
                    $codeQualite = $integrations[0]->get('code_qualite');
                    $integrationsHorsCpas = $flux2->getIntegrationsHorsCpas($rn, $dateDebutIntegration, $dateFinIntegration, $dateDebut->format("d/m/Y"), $dateFin->format("d/m/Y"), $codeQualite);
                    
                    include_once 'scripts/ajax/flux/integrations_hors_cpas.php';
                    
                }
                unset($flux2);
            }
        }
        
        break;
        
    case 'flux_taxi_as':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/taxi_as/" . ENV . "/TaxAssessmentDataV1.wsdl";
            $flux = new TaxiAsFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                $descriptionCodeIpcal["7555"] = "TOTAL DES REVENUS IMPOSABLES GLOBALEMENT";
                $descriptionCodeIpcal["7557"] = "TOTAL DES REVENUS IMPOSABLES DISTINCTEMENT";
                
                $res = $flux->getRevenusDisponible($rn);
                
                include_once 'scripts/ajax/flux/taxi_as.php';
                
            }
            
        }
        
        break;
        
    case 'flux_social_rate_investigation':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/social_rate_investigation/" . ENV . "/SocialRateInvestigation.wsdl";
            $flux = new SocialRateInvestigationFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                $res = $flux->getData($_GET['rn']);
                
                include_once 'scripts/ajax/flux/social_rate_investigation.php';
                
            }
            
        }
        
        break;
        
    case 'flux_childbenefits':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
  
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "/includes/soap/childbenefits/" . ENV . "/be/fgov/kszbcss/intf/ChildBenefitsService/ChildBenefitsV1.wsdl";

            $flux = new CadafFlux (
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
    
            if ($flux->connexion($wsdl)) {
                
                $res = $flux->getDossiers($rn);
                
                include_once 'scripts/ajax/flux/cadaf/translate.php';
                include_once 'scripts/ajax/flux/cadaf.php';
            } 
            
        }
        
        break;

    case 'flux_unemployment_data':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/unemployment_data/" . ENV . "/v3/be/fgov/kszbcss/intf/UnemploymentDataV3.wsdl";

            $flux = new UnemploymentData(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
            if ($flux->connexion($wsdl)) {
                    
                $res = $flux->getDossiers($rn);
                    
                include_once 'scripts/ajax/flux/unemployment_data/translate.php';
                include_once 'scripts/ajax/flux/unemployment_data.php';
                    
            }
        }
        
        break;
        
    case 'flux_self_employed':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];

             
            $wsdl = "http://" . $_SERVER["HTTP_HOST"] . str_replace("ajax.php", "", $_SERVER["SCRIPT_NAME"]) . "includes/soap/self_employed/v1/" . ENV . "/SelfEmployedV1.wsdl";
            
            $flux = new selfEmployed (
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["soa"]["username"],
                $_config["flux"]["soa"]["password"]
                );
             
            if ( $flux->connexion($wsdl) ) {
                
                $res = $flux->getDossiers($rn);   
                
                
                 
                include_once 'scripts/ajax/flux/self_employed/translate.php';
                include_once 'scripts/ajax/flux/self_employed.php';
            }
         }
        
        break;  
        
    case 'flux_pension':
        if (isset($_GET['rn'])) {
            $rn = $_GET['rn'];
            
            $flux = new PensionRegisterFlux(
                ENV,
                $_config["flux"]["cbe_number"],
                $_config["flux"]["secteur"],
                $_config["flux"]["institution"],
                $_config["flux"]["numero_organisation"],
                $_config["flux"]["old"]["user_id"],
                $_config["flux"]["old"]["email"]
                );
            if ($flux->connexion()) {
                
                $data = $flux->getData($rn);
                
                include_once 'scripts/ajax/flux/pension_register.php';
            }
        }
        
        break;
        
    case 'flux_tous':
        echo "TOUS";
        
        break;
        
    default:
        echo "Aucun";
        
        break;
}

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }
    
    if (is_array($d)) {
        //
        // Return array converted to object
        // Using __FUNCTION__ (Magic constant)
        // for recursive call
        //
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}

function compareActivites($a, $b)
{
    if ($a->Worker->OccupationPeriod->BeginDate < $b->Worker->OccupationPeriod->BeginDate) {
        return 1;
    } elseif ($a->Worker->OccupationPeriod->BeginDate > $b->Worker->OccupationPeriod->BeginDate) {
        return -1;
    } else {
        return 0;
    }
}
function compareSommesPayees($a, $b)
{
    if ($a->month < $b->month) {
        return 1;
    } elseif ($a->month > $b->month) {
        return -1;
    } else {
        return 0;
    }
}

ob_end_flush();