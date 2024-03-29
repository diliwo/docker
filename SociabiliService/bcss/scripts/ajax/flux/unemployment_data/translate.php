<?php

$code ='{
    
	"FR": {
		
        "val": {

            "MSG00000": "Des données conformes aux critères de recherche ont été trouvées.",
            "MSG00001": "Le service (BCSS) est momentanément indisponible. Veuillez réessayer plus tard.",
            "MSG00100": "Traitement réussi, mais aucune donnée trouvée chez le fournisseur.",
			"CHB00001": "Traitement partiellement réussi. Certaines sources ne peuvent consultées à cause d\'un problème technique.",
			"MSG00002": "Le service externe est indisponible (ONEM ou répertoire sectoriel). Veuillez réessayer plus tard.",
			"MSG00005": "Le registre national donné dans la requéte n\'existe pas.",
			"MSG00006": "Le registre national donné dans la demande est remplacé.",
			"MSG00007": "Le registre national donné dans la demande est annulé.",
			"MSG00008": "La demande contient des données non valides. Veuillez vérifier le contenu de votre message.",
			"MSG00011": "La structure du registre national donnée dans request est invalide.",
			"MSG00012": "Le registre national donné dans la demande n\'est pas intégré pour la source (client).",
			"MSG00013": "L\'accés à cette opération n\'est pas autorisé avec le contexte juridique et les informations d\'identification donnés.",
			"MSG00014": "Les informations d\'identification fournies par le client ne correspondent pas à l\'organisation du client.",
			"MSG00021": "Le registre national donné dans la demande non intégré pour la destination (fournisseur / destinataire).",
			"MSG00027": "Le client n\'est pas autorisé à consulter les données demandées.",
            "MSG00015": " (Autorisation AAAPolicy refusée) Le client n\'est pas autorisé à utiliser le service",
            "MSG00025": "Cette fonctionnalité n\'est pas disponible. - consultContributions.",
            "MSG00004": "La structure n\'est pas valide",
            "MSG00003": "Erreur inattendue dans l\'application - CBSS.",
            "MSG00016": "Accès refusé à cette opération pour l\'utilisateur authentifié",  
            "UDS00016": "La date définie dans la demande est invalide",
            "UDS00010": "Un dossier existe mais aucun paiement trouvé pour cette période",
            "UD000001": "Communication avec service externe non valide (ONEM).",
            "UD000011": "Des données répondant aux critères de recherche n’ont pas été trouvées.",
            "UD000012": "NISS inconnu auprès de l’ONEM dans le contexte légal de la BCSS. (Intégration)",
            "UD000013": "Paiement sans droit connu à la date demandée (Ceci est anormal. Le paiement n’est pas communiqué dans ce cas.)",
            "UD000017": "La situation du droit est connue, mais aucun paiement n’est connu.",
            "UD000018": "Le dossier n’est pas migré et cette personne n\'est donc pas chômeuse",
            "UD000031": "Indication de temps incorrecte dans la demande", 
            "UDS00007": "Aucun paiement trouvé pour la période demandée",

            "COMPLETED": "La procédure de vérification est terminée et le montant approuvé est communiqué",
            "PROVISIONAL": "La procédure est en cours, mais le montant approuvé provisoire sera communiqué",
            "NOT_STARTED": "La procédure doit encore être entamée, le montant approuvé n’est pas rempli ",

            "beginDate": "Date de début : ",
            "endDate": "Date de fin : ",
            "relatedMonth": " Mois ",
            "paidAmount": "Montant brut payé : ",
            "acceptedAmount": "Montant accepté : ",
            "dossierStatus": "Dossier statut : ", 
            "nbrOfAllowances": "Nb allocations payées (en jour complets) : ", 
            "montant": "Montant : ", 

            "fieldName": "Nom de domaine : ",
            "fieldValue": "Champ valeur : ",

            "theoricDailyAllowanceAmount": " Montant journalier théorique : ", 

            "rightStartingDate": "Date de départ : ", 
            "startingDate": "Date de départ : ",
            "unemploymentCode": "Nature du chômage : ",

            "familyState": "Situation familiale  : ",

            "HOUSEHOLDER": "Chef de ménage ",
            "COHABITING": "Cohabitant ",
            "SOLITARY": "Isolé ",

            "UNEMPLOYENT_ALLOCATION": " DEMANDE DE CHÔMAGE ",
            "INSERTION_ALLOCATION": " ALLOCATION D\'INSERTION ",
    
            "creationDate": " Date de création du message : ",
            "unemployedWorkerStatus": " Type d\'allocation : ",
            "UNEMPLOYMENT_ALLOCATION": "ALLOCATION DE CHÔMAGE",
            "paidMonth": "Mois du paiement : ",
            "theoricalDailyAllowanceAmount": "Montant théorique accepté : ",
            "nbrOfAllowance": "Le nombre d\'allocations : ",
            "endemnificationRegime": "Régime d\'allocation",

            "monthlyData": "Racine du calendrier : ",
            "scaleData": "Données sur les barèmes : ",

            "nisseReference": "N.I.S.S.E. Reference FR ",
            "selfEmployedEnterpriseNumber": " Enterprise Number FR ",
            "occupation": " Occupation FR ",
            "affiliations": " Affiliations FR ",

            "beginMonth": " Mois de début : ",
            "endMonth": " Mois de fin : ",
            "startMonth": "Mois de début : ",
            "authenticSources": " Sources authentiques : ",
            "status": " Statut : ",
            "criteria": " Critéres : ",
            "period": "Période : ",
            "value": " Valeur : ",
            "desc": " Nature du chômage : ",
            "description": " Description : ",
            "entitledPerson": " Registre national du Bénéficiaire : ",
            "fileNumber": " Numéro de dossier ",
            "enterpriseNumber": " Numéro d\'enterprise : ",
            "results": " Résultats  ",
            "paymentDate": " Date de paiement : ",
            "PaymentPeriod":"Délai de paiment  ",
            "categoryCode": " Catégorie de code : ",
            "bonus": " Bonus ",
            "beneficiary": " Bénéficiaire ",
            "beneficiaries": " Bénéficiaires ",
            "child": "Enfants",
            "ssin": " Registre national : ",
            "code": " Code : ",
            "file": "Dossier",
            "no_data": " Aucune donnée",

            "DATA_FOUND": "Le traitement s’est déroulé avec succès et les données sont retrouvées.",
            "NO_DATA_FOUND": "Le traitement s’est déroulé avec succès, mais aucune donnée n’a été trouvée dans la source authentique.",
            "TECHNICAL_ERROR": "Erreur technique dans la communication avec la source. ",
            "NO_RESULT": "Le traitement a échoué. Le fournisseur n’a pas été interrogé et il n’y a donc aucun résultat à afficher.",

            "cbeNumber": " Numéro d’entreprise : ",
            "quarter": "Numéro du trimestre : ",
            "year": "Année : ",
            "titleQuarter":"Trimestre", 

            "fluxError": " Impossible de se connecter au flux: ",
            
            "consultActivationPaidSums": "Sommes payées activées",
            "consultCareerBreak": "Interruption de carrière",
            "consultPaidSums": "Sommes payées",
            "consultPayments": "Paiements",
            "consultRights": "Droits",
            "consultScheduledPayment": "Paiement prévu",
            "consultSituation": "Situation",

            "complementaryActivityCode": "Code d\'activité complémentaire : ",
            "careerBreakCode": "Code de pause de carrière : ",
            "allowanceAmount": "Montant de l\'allocation : ",
            "careerBreakType":"Type de pause de carrière : ",
            "careerBreakReason": "Raison Pause carrière : ",

            "scheduledPayment": "Paiement prévu : ",
            "scaleCode": "Code barémique : ",
            "validityDate": "Date de validité : ",
            "month": "Mois : ",
            "dailyData": " Données quotidiennes : ",
            "day": "Jour concerné : ",

            "allAllowance": "Toutes les indemnités : ",
            "activationAllowance": " Trimestre recherché  : ",
            "employers": "Employeurs: ",

            "paymentMonth": "Mois du trimestre  : ",
            "activationAllowanceAmount": "Montant concerné pour le mois stipulé ci-dessus : ",
            "activationAllowanceCode": "Type d’allocation d’activation : ",

            "payment": "Paiement",
            "indemnificationRegime": "Régime d\'allocation",
            "right": "Droit : ",
            "noRight": "Aucun droit : ",

            "eleApproved":" / approuvé ",

            "selfEmploymentSupplement": "Peut travailler en tant qu’indépendant : ",
            "theoricRightEndingDate": "Date de fin droite théorique : ",       
            "benifitiaryInformation" : "Allocation d’interruption de carrière et/ou crédit-temps : ",
            "admissibilityArticle": "Article de recevabilité : ",
            "triggerDate": "Date d’évènement : ",
            "sanction": " Sanction : ",
            "exclusion": " Exclusion : ",
            "rightEnd" : " Fin de droit  : ",
            "admisibilityArticle" : "Article admission : ",
            "indemnisabilityArticle": "Article indemnisation : ",

            "nbrOfWeeksSanction": " Dure la sanction :  ",
            "article": "Cause de la sanction ",
             
            "S_COMPLETED":" DEFINITIF ",
            "S_PROVISIONAL":" PROVISOIRE ",
            "S_NOT_STARTED":" NON COMMENCE ",
            "NISS":"Numéro NISS (RN) : ",

            "meanWorkingHours": "Heures prestées par semaine : ",
            "refMeanWorkingHours": "Ref, heures prestées par semaine : ",
            "amount": "Montant de l’allocation d’activation : ",
            "entryIntoEmploymentDate": "Date d’entrée en service : ",
            "wageScaleCode": "Phase de l’allocation d’activation : ",
            "businessUnitNumber": "N° de l’unité d’établissement : ",
            "validityPeriod" : "Période de validité : ",

            
            "00": " Non indemnisable en tant que chômeur ",
            "01": " Chômage complet admission à temps plein",
            "02": " Chômage temporaire admission à temps plein",
            "03": " Chômage complet admission à temps partiel volontaire",
            "04": " Chômage temporaire admission à temps partiel volontaire",
            "05": " Travailleur à temps partiel ayant droit à l’allocation de garantie de revenu",
            "06": " Travailleur à temps partiel indemnisable uniquement en chômage temporaire",
            "07": " ",
            "08": " Importation de droits à partir d’un pays faisant partie de l\'EEE",
            "09": " Prépensionné admission à temps plein ",
            "10" : " Prépensionné admission comme travailleur à temps partiel volontaire",
            "11": " Formation professionnelle ou allocation de formation ou de stage à temps plein",
            "12": " Occupation en atelier protégé",
            "13": " ",
            "14": " ",
            "15": " Travailleur frontalier âgé",
            "16": " Allocation de chômage majorée durant le dernier mois de la formation professionnelle – travailleur à temps plein",            
            "17": " Allocation de chômage majorée durant le dernier mois de la formation professionnelle – travailleur à temps partiel volontaire",
            "18": " Prépension à mi-temps",
            "19": "",
            "20": "",
            "21": " Allocations vacances jeunes",
            "22": " Allocations de vacances de seniors",
            "31": " Allocation de formation ou de stage à temps partiel ",
            "34": " Chômeur temps partiel volontaire ayant droit au complément de mobilité",
            "35": " Chômeur temps partiel volontaire ayant droit au complément de garde d’enfants",
            "36": " Chômeur temps partiel volontaire ayant droit au complément de mobilité et au complément de garde d’enfants",
            "37": " Chômeur temps partiel volontaire ayant droit au complément de mobilité et au complément de 247,89 EUR pour avoir suivi une formation professionnelle", 
            "38": " Chômeur temps partiel volontaire ayant droit au complément de garde d\'enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle",
           
            "39": " Chômeur temps partiel volontaire ayant droit au complément de mobilité, au complément de garde d\'enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle",
            "40": " Allocation d’établissement",
            "44": " Chômeur complet ayant droit au complément de mobilité",
            "45": " Chômeur complet ayant droit au complément de garde d’enfants",
            "46": " Chômeur complet ayant droit au complément de mobilité et au complément de garde d’enfants",
            "47": " Chômeur temps complet ayant droit au complément de mobilité et au complément de 247,89 EUR pour avoir suivi une formation professionnelle ",
            "48": " Chômeur temps complet ayant droit au complément de garde d’enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle",
            "49": " Chômeur temps complet ayant droit au complément de mobilité, au complément de garde d’enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle ",
            "57": " Travailleur à temps partiel ayant droit à l’allocation de garantie de revenus (mesure à partir du 01.07.2005) ",
            "58": " Travailleur à temps partiel volontaire ayant droit à l’allocation de garantie de revenu (AGR) art.104, §1bis (en vigueur à partir du 01/07/2013) ",

            
            "month-01":" Janvier ",
            "month-02":" Février ",
            "month-03":" Mars ",
            "month-04":" Avril ",
            "month-05":" Mai ",
            "month-06":" Juin ",
            "month-07":" Juillet ",
            "month-08":" Août ",
            "month-09":" Septembre ",
            "month-10":" Octobre ",
            "month-11":" Novembre ",
            "month-12":" Décembre "
        
        }
	},
	"NL": {
		
        "val": {

           

        }
    
	},
	"EN" : {
		
        "val": {

          
        }
	}
}';

$code = (json_decode(utf8_encode($code)));

$elem = $code->{'FR'};

    
/* 
$m[] = $code;
foreach ($m as $string) {
    
    
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Aucune erreur';
            break;
        case JSON_ERROR_DEPTH:
            echo ' - Profondeur maximale atteinte';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Inadéquation des modes ou underflow';
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Erreur lors du contrôle des caractères';
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Erreur de syntaxe ; JSON malformé';
            break;
        case JSON_ERROR_UTF8:
            echo ' - Caractères UTF-8 malformés, probablement une erreur d\'encodage';
            break;
        default:
            echo ' - Erreur inconnue';
            break;
    }
    
    echo PHP_EOL;
}

*/ 
 
