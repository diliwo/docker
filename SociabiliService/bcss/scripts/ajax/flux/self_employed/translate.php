<?php

$code ='{ 
    
	"FR": {
		
        "val": {
        
            "MSG00000":"Traitement réussi.",
            "MSG00003":"Erreur interne.",
            "MSG00005":"Le registre national donné dans la requéte n\'existe pas.",
            "MSG00006":"Le registre national donné dans la demande est remplacé.",
            "MSG00007":"Le registre national donné dans la demande est annulé.",
            "MSG00011":"La structure du registre national donnée dans request est invalide.",
            "MSG00012":"Le registre national donné dans la demande n\'est pas intégré pour la source (client).",
            "MSG00013":"L\'accés à cette opération n\'est pas autorisé avec le contexte juridique et les informations d\'identification donnés.",
            "MSG00014":"Les informations d\'identification fournies par le client ne correspondent pas à l\'organisation du client.",
            "MSG00015":"Autorisation refusée. ",
            "MSG00020":"Fournisseur indisponible.",
            "MSG00021":"Le registre national donné est inconnu du fournisseur (non intégré).",
            "MSG00023":"Réponse incorrecte du fournisseur (interne).",
            "MSG00025":"Désolé, l\'opération n\'est pas encore implémentée.",
            "SES00100":"Aucune donnée pour la personne recherchée.",
            "SES00200":"Aucune donnée pour la période demandée.",
            "SES00300":"Période n\'est pas correcte.",
            "SES00400":"Trimestre n\'est pas correct.",
            "SES00500":"Code de retour inattendu du fournisseur.",
            "SES00600":"CbeNumber n\'est pas un CPAS.",

            "selfEmployed":"Indépendant(e)",

            "titleCareer":" Carrière ",
            "titleContributions":" Contributions ",
            "titleCareerAndContributions":" Carrière et contributions ",

            "nisseReference": "N.I.S.S.E. Reference FR ",
            "selfEmployedEnterpriseNumber": " Enterprise Number FR ",
            "occupation": " Occupation FR ",
            "affiliations": " Affiliations FR ",

            "beginMonth": " Mois de début: ",
            "endMonth": " Mois de fin: ",
            "status": " Statut: ",
            "criteria": " Critéres ",
            "period": "Période ",
            "value": " Valeur: ",
            "desc": " Description: ",
            "description": " Description: ",
            "entitledPerson" : " Registre national du Bénéficiaire: ",
            "fileNumber" : " Numéro de dossier ",
            "enterpriseNumber" : " Numéro d\'enterprise: ",
            "results" : " Résultats:  ",
            
            "ssin": " Registre national: ",
            "code": " La caisse d’assurance sociale: ",
            "file": "Dossier: ",
            "no_data": " Aucune donnée",

            "fieldName": "Nom de domaine: ",
            "fieldValue": "Valeur: ",
            "selfEmployedCbeNumber": "N. BCE du travailleur indépendant: ",
            "membership":"Données  d\'affiliations:",
            "socialInsuranceFund": "Assurance sociale: ",
            "careerComponent": "Code cotisant spécifique: ",
            "contributionCode": "Type  de  cotisation  payée: ",
            "nisseEqualizedCode": "Code  généré  par  l\'INASTI: ",

            "beginDate": "Date de début: ",
            "endDate": "Date de fin: ",
            "cbeNumber": " Numéro d\'entreprise: ",
            "contributionSituation":"Contribution situation: ",
            "lastPayment":"Dernier paiement",

            "quarterContribution":"Quart de contribution: ",
            "quarter":"Trimestre: ",

            "year":"Année: ",
            "careerData":"Données de carrière: ",
            "contributionsData":"Contributions données: ",
            "feedback":"Retour d\'information: ",

            "DATA_FOUND" :"Le traitement s\'est déroulé avec succès et les données sont retrouvées.",
            "NO_DATA_FOUND" :"Le traitement s\'est déroulé avec succès, mais aucune donnée n\'a été trouvée dans la source authentique.",
            "TECHNICAL_ERROR" :"Erreur technique dans la communication avec la source. ",
            "NO_RESULT" :"Le traitement a échoué. Le fournisseur n\'a pas été interrogé et il n\'y a donc aucun résultat à afficher.",
            

            "BEGIN_DESC-ListeDesCategoriesDeCotisation":"COMMENT# ABCDE.....Z",
            
            "COMMENT#A":"BEGIN 01/07/1956 END 00/00/0000 ",
            "A":"Activité principale Les travailleurs indépendants qui pour l\'application du statut  social  sont  supposés  exercer  leur  activité  indépendante  à  titre principal (art. 12 par. 1 de l\'AR n°38 du 27/07/2005)",
            
            "COMMENT#B":"BEGIN 01/07/1956 END 31/12/1972 ",
            "B":"Usage assurance vie Il s\'agit des personnes qui ont conclu une assurance vie  auprès  d\'une  caisse  de  pension  et  qui  bénéficie  d\'une  réduction  de cotisation sociale Voir point 2.4.1. (pension) ",
            
            "COMMENT#B#01":"BEGIN 01/01/1984 END 31/12/1992 ",
            "B#01":"Activité autorisée  avant  l’âge  normal  de  la  retraite  (2/3  de  pension  de survie)",
            
            "COMMENT#C":"BEGIN 01/07/1956 END 31/12/1972 ",
            "C":"Usage bien immobilier Il s\'agit  de  personnes qui avaient utilisé un bien immobilier  en  vue  de  la  constitution  d\'une  caisse  de  pension  et  qui pouvaient  bénéficier  d\'une  réduction  de  cotisation  Voir  point  2.4.1. (pension)",
            
            "COMMENT#D":"BEGIN 01/07/1956 END 00/00/0000 ",
            "D":"Activité complémentaire (à titre accessoire) avant l’âge légal de la retraite Les personnes qui, outre l’activité indépendante, exercent habituellement et à titre principal une autre activité",
            
            "COMMENT#E":"BEGIN 01/07/1963 END 00/00/0000 ",
            "E":"Activité  autorisée  après  l’âge  normal  de  la  retraite  Les  travailleurs indépendants qui exercent une activité après l’âge normal de la retraite et qui  bénéficient  depuis  le  01/01/1976  d’une  pension  de  retraite  ou  de survie",
            
            "COMMENT#F":"BEGIN 01/07/1963 END 00/00/0000 ",
            "F":"Activité  autorisée  avant  l’âge  normal  de  la  retraite  Les  pesonnes  qui exercent une activité indépendante et qui, avant l’âge légal de la retraite, bénéficie  déjà  d’une  pension  qui  fait  l’objet  de  la  réglementation  en matière d’activité professionnelle autorisée",
            
            "COMMENT#G":"BEGIN 01/01/1968 END 00/00/0000 ",
            "G":"Aidant sans revenus Assurance libre pour le(s) aidant(s) non rémunéré(s)",
            
            "COMMENT#H":"BEGIN 01/01/1968 END 00/00/0000 ",
            "H":"Marié(e)s,  veuf(s)/veuve(s),  étudiants  (art.  37.1)  Les  personnes  qui n’exercent pas une autre profession mais qui sont bien titulaires de droits dérivés",
            
            "COMMENT#I":"BEGIN 01/01/1982 END 00/00/0000 ",
            "I":"Début activité (art. 40.3) Une cotisation provisoire au début de l’activité pour les personnes qui ont invoqué l’application de l’article 37 (catégorie H) ",
            
            "COMMENT#J":"BEGIN 01/01/1982 END 30/09/1985 ",
            "J":"Homme,  aidant  de  son  épouse (art.  12)  À  l’homme  qui  assiste  ou remplace  son  épouse  dans  l’exercice  de  sa  fonction,  il  est  offert  la possibilité d’être considéré à sa place comme étant le cotisant.",
            
            "COMMENT#K":"BEGIN 01/07/1995 END 30/06/1997 ",
            "K":"Assurance continuée –faillite Avec droit à la pension",

            "COMMENT#K#01":"BEGIN 01/07/1995 END 30/06/1997 ",
            "K#01":"Assurance sociale en cas de faillite Sans droit à la pension",
            
            "COMMENT#L":"BEGIN 01/01/2003 END 00/00/0000 ",
            "L":"Conjoint aidant (statut maximal)",

            "COMMENT#M":"BEGIN 01/01/1968 END 00/00/0000 ",
            "M":"Âge  de  la  retraite  atteint  avant  le  04.01.1957  Les  personnes  qui  font partie  de  cette  catégorie  paient  uniquement une  cotisation  pour  le secteur des allocations familiales",
            
            "COMMENT#N":"BEGIN 01/07/1956 Fin =31/12/1975 ",
            "N":"Clergé",

            "COMMENT#O":"BEGIN 01/01/1993 END 00/00/0000 ",
            "O":"Activité autorisée avant l’âge normal de la retraite (pension de survie)",

            "COMMENT#P":"BEGIN 01/07/1956 END 31/12/1975 ",
            "P":"Communautés religieuses",
            
            "COMMENT#Q":"BEGIN 01/01/1990 END 00/00/0000 ",
            "Q":"Conjoint aidant –  mini   -statut  Jusqu’au  31/12/2002  :  assujettissement volontaire À partir de 01/01/2003 : assujettissement obligatoire",
            
            "COMMENT#R":"BEGIN 01/07/1956 END 00/00/0000 ",
            "R":"Assurance continuée – uniquement pension Font partie de cette catégorie les membres qui n’exercent plus d’activité indépendante mais qui paient pour une assurance continuée dans le secteur des pensions",
           
            "COMMENT#S":"BEGIN 01/07/1956 END 00/00/0000 ",
            "S":"Assurance continuée –pension et AMI Font partie de cette catégorie les membres  qui  n’exercent  plus  d’activité  indépendante  mais  qui  paient pour  une assurance  continuée  dans  le  secteur  des  pensions  et  dans  le secteur AMI",
            
            "COMMENT#T":"BEGIN 01/01/1957 END 00/00/0000 ",
            "T":"Assimilation  période  d’études  ou  comme  apprenti  avec  paiement  de cotisations sociales Élargi à partir du  01/10/1981 de : assimilation pour une période inférieure à un an, située entre la fin du service militaire et le début de la période assimilable pour étude ou contrat d’apprentissage",

            "COMMENT#T#01":"BEGIN 01/01/1957 END 00/00/0000 ",
            "T#01":"Assimilation maladie par cotisation volontair",

            "COMMENT#U":"BEGIN 01/07/1956 END 00/00/0000 ",
            "U":"Assimilation  (maladie,  service  militaire, détention  provisoire,  soins palliatifs,  enfant  malade)  Il  s’agit  en  l’occurrence  d’assimilations  pour lesquelles aucune cotisation n’a été payée",
           
            "COMMENT#V":"BEGIN 01/01/1976 END 31/12/1996 ",
            "V":"Activité autorisée avant l’âge normal de la retraite (perte ou renoncement au droit à la retraite anticipée",
           
            "COMMENT#W":"BEGIN 01/01/1976 END 31/12/1996 ",
            "W":"Activité après l’âge normal de la retraite (pas de pension de retraite ou de survie)",

            "COMMENT#X":"BEGIN 01/07/1956  END 31/12/1969 ",
            "X":"Aidant dans une entreprise familiale",
           
            "COMMENT#Y":"BEGIN 01/01/1976  END 00/00/0000 ",
            "Y":"Activité après l’âge normal de la retraite (pas de pension de retraite ou de survie)",
            
            "COMMENT#Z":"BEGIN 01/07/1956  END 31/12/1967 ",
            "Z":"Prime  unique  (paiement  de  la  valeur  d’achat  suite  au  renoncement  de l’utilisation d’un bien immobilier) Ou utilisation d’un bien immobilier pour couvrir la période entre le 01/07/1956 et le 31/12/1967",
            
            "END_DESC-ListeDesCategoriesDeCotisation":"COMMENT# ABCDE.....Z",
            "fluxError": " Erreur : ",
            "problemeCommentDate": "Peut-être problème avec le format de date dans un fichier translete ",

            "PAYED": "les cotisations du trimestre sont payées",
            "NOT_PAYED":" les    cotisations du trimestre ne sont pas payé",
            "EXEMPTION":" : le travailleur est exempté de paiements pour le trimestre par la Commission d’exemption des cotisations",

            "000":"CGER",
            "001":"Groupe S",
            "002":"Xerius",
            "003":"Zenito",
            "004":"S.B.B.",
            "005":"nterfederale",
            "006":"---",
            "007":"Partena",
            "008":"Partena",
            "009":"---",
            "010":"Acerta",

            "011":"Arenberg Sociaal verzekeringsfonds voor zelfstandigen",
            "012":"SECUREX-Integrit",
            "013":"Incozina",
            "014":"Intersociale",
            "015":"Multipen",
            "016":"H.D.P.",
            "017":"L\'ENTRAIDESteunt Elkander",
            "018":"Zekerheid voor zelfstandigen, Interprovinciale socialeverzekeringsklas voor zelfstandige arbeiders",
            "019":"U.C.M.",
            "020":"Assurances générales (A.G.) ",

            "021":"Royale Belge ",
            "022":"Assurances P&V ",
            "023":"Centrale Levensverzekeringsmaatschappij ",
            "024":"De Nederlanden 1870 N.V. ",
            "025":"Alg. Verzekeringsmij voor de Middenstand ",
            "026":"Belg. Verzekeringsmij voor de Middenstand (gefusioneerd met V.M. 20 : A.G.) ",
            "027":"Mercator ",
            "028":"De Volksverzekering ",
            "029":"Belfort (gefusioneerd met V.M. 110 : A.S.L.K.) ",
            "030":"THEMIS - dossiers à la Cie 065 ",

            "031":"De Vaderlandsche ",
            "032":"La Mutuelle générale Française Vie (gefusioneerd met V.M. 90 : LE MANS) ",
            "033":"De Nationale Verzekeringen - G.A.N. ",
            "034":"Het Nieuw Leven - Patrimoine (gefusioneerd met V.M. 79 : AXA) ",
            "035":"Vereniging der Belgische Eigenaars (gefusioneerd met V.M. 21 : La Royale Belge) ",
            "036":"Association d\'Assurances Mutuelles sur la Vie de la Société Coopérative (Fédér. de Belgique) A.M.F.B.",
            "037":"PHENIX (gefusioneerd met V.M. 87 : van Frankrijk)",
            "038":"DE ZON (gefusioneerd met V.M. 33 : G.A.N.) ",
            "039":"Le Foyer Luxembourgeois ",
            "040":"Onderling Hypothecair Krediet (gefusioneerd met V.M. 46-58 en 60 : U.A.P.)",

            "041":"DE BIJ (gefusioneerd met V.M. 57 : De Bij-Vrede) ",
            "042":"De Nationale Waarborg",
            "043":"De Federale Verzekeringen",
            "044":"Maatschappij voor Verenigde Eigenaars (gefusioneerd met V.M. 20 : A.G.)",
            "045":"DE AREND (gefusioneerd met V.M. 33 : G.A.N.) ",
            "046":"L\'URBAINE - U.A.P. (Dienst Renten) (gefusioneerd met V.M. 40-58 EN 60 : U.A.P.)",
            "047":"Le Globe (gefusioneerd met V.M. 20 : A.G.) ",
            "048":"ELVIA Verzekeringen N.V. Voorheen ",
            "049":"De Belgische Lloyd ",
            "050":"Fidelitas ",

            "051":"De Verenigde Meesters (gefusioneerd met V.M. 55 : GENERALI BELGIUM) ",
            "052":"LA CONCORDE (gefusioneerd met V.M. 55 : GENERALI BELGIUM)",
            "053":"Foncière - Camer - PRECAM (gefusioneerd met V.M. 67 : AEGON) ",
            "054":"PHENIX belge (gefusioneerd met V.M. 20 : A.G.) ",
            "055":"GENERALI BELGIUM ",
            "056":"MINERVE (gefusioneerd met V.M. 55 : GENERALE BELGIUM)",
            "057":"DE BIJ-VREDE",
            "058":"Union des Assurances de Paris - Urbaine (gefusioneerd met V.M. 46-60 -40 : U.A.P.) ",
            "059":"The General Life Assurance Compagny à Londres (gefusioneerd met V.M. 21 : Royale Belge)",
            "060":"ATLANTA (gefusioneerd met V.M. 46-58-40 : U.A.P.) ",

            "061":"DE MEDISCHE ",
            "062":"La Fédérale de Belgique (gefusioneerdmet V.M. 20 : A.G.) ",
            "063":"NOORD-BRABANT (gefusioneerd met V.M. 102 : Ver. Provinciën-OCEAN)",
            "064":"Noord Hollandsche (overgenomen door groep CORONA) ",
            "065":"De Noordstar & Boerhaave",
            "066":"Union & Phenix espagnol ",
            "067":"AEGON :voorheen ENNIA -De Eerste Nederlands",
            "068":"R.V.S. ",
            "069":"A.M.E.V. Leven Verzekeringen N.V.",
            "070":"ZURICH LIVE ",

            "071":"DE STER (gefusioneerd met V.M. 69 : A.M.E.V.) ",
            "072":"NATIONALE-SUISSE Verzekeringen ",
            "073":"ANTVERPIA ",
            "074":"CARITAS (gefusioneerd met V.M. 86 : A.G.P. Benelux)",
            "075":"De Kortrijkse Verzekering ",
            "076":"OHRA : Voorheen De Nationale Onderlinge Leven ",
            "077":"DE METROPOOL voorheen ADRIATIQUE ",
            "078":"Fédérale de Belgique (gefusioneerd met V.M. 20 : A.G.) ",
            "079":"AXA voorheen Groep DROUOT, voorheen Patroonkas",
            "080":"ASSUBEL-VIE N.V. (Dienst indiv. leven - Vereffeningen) ",

            "081":"Assurantie van de Belgische Boerenbond",
            "082":"SECURITAS (gefusioneerd met V.M. 20 : A.G.) ",
            "083":"MONDIALE - Live Belgium N.V.",
            "084":"Het   Belgische Verhaal",
            "085":"De Belgische Leeuw ",
            "086":"A.G.P. BENELUX voorheen De Voorzorg (gefusioneerd met V.M. 79 : AXA)",
            "087":"A.G.F. BELGIUM voorheen Alg. Verz. van Frankrijk",
            "088":"Alg. Maatschappij van Verzekeringen en Grondkrediet ",
            "089":"BELGIE LEVEN voorheen Belgische AREND (gefusioneerd met V.M. 21 : Royale Belge)",
            "090":"LE MANS ASSURANCES ",

            "091":"BAZEL ",
            "092":"EAGLE STAR, Brusselse Maatschappij",
            "093":"DE SCHELDE ",
            "094":"LA GENEVOISE (gefusioneerd met V.M. 20 : A.G.) ",
            "095":"Helvetia Vie de Geneve (gefusioneerd met V.M. 48 : ELVIA",
            "096":"MINERVE-LEVEN (gefusioneerd met V.M. 55 : GENERALI)",
            "097":"L\'Assurance Liégeoise (gefusioneerd met V.M. 21 : Royale Belge) ",
            "098":"Lloyd de France (gefusioneerd met V.M. 53 : PRECAM) ",
            "099":"NORWICH UNION LIFE I.S. ",
            "100":"CONDOR voorheen NOORD daarna CITE-VIE",

            "101":"La Préservatrice-Leven     (gefusioneerd met V.M. 53 : PRECAM)",
            "102":"Commercial Union Belgium N.V. ",
            "103":"DE TOEKOMST (gefusioneerd met V.M. 64 : Groep CORONA) ",
            "104":"L\'Union belge",
            "105":"WINTERTHUR EUROPE VERZEKERINGEN N.V. ",
            "106":"WINTERTHUR",
            "107":"Ancienne mutuelle - Vie à Rouen (France)",
            "108":"Antwerpse Volksverzekering ",
            "109":"L\'Ardenne Prévoyante (gefusioneerd met V.M. 106 : WINTERTHUR) ",
            "110":"Levensverzekeringskas van de A.S.L.K. ",

            "111":"La Confiance ",
            "112":"NAVIGA ",
            "113":"MORTELIUS ",
            "114":"PATERNELLE - VIE",
            "115":"Onderlinge Maatschappij der Openbare Besturen",
            "116":"Zwitserse Maatschappij ",
            "117":"EIGEN LEVEN ",
            "118":"VICTORIA VESTA, De Nieuwe Vaderlandsche",
        
            "900":"cCisse auxiliaire nationaleNationale Hulpkas",


            "30":"Début assimilation maladies",
            "3A":"Début assimilation conjoint aidant",
            "3B":"Fin assimilation conjoint aidant ",
            "3C":"Début assimilation enfant gravement malade ",
            "3D":"Fin assimilation enfant gravement malade",
            "3E":"Début assimilation soins palliatifs",
            "3F":"Fin assimilation soins palliatifs ",
            "3G":"Début assimilation maladie parent/membre de la famill",
            "3H":"Fin assimilation maladie parent/membre de la famille",
            "3I":"Début assimilation soins palliatifs parent/membre fami",
            "3J":"Fin assimilation soins palliatifs parent/membre famill ",
            "3K":"Début assimilation enfant handicapé ",
            "3L":"Fin assimilation enfant handicapé ",
            "31":"Début assimilation études  ",
            "32":"Début assimilation service militaire",
            "33":"Début assimilation détention préventive",
            "34":"Début assurance continuée"
           
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
            echo ' - Erreur lors du contréle des caractéres';
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Erreur de syntaxe ; JSON malformé';
            break;
        case JSON_ERROR_UTF8:
            echo ' - Caract�res UTF-8 malformés, probablement une erreur d\'encodage';
            break;
        default:
            echo ' - Erreur inconnue';
            break;
    }
    
    echo PHP_EOL;
}
*/
 
