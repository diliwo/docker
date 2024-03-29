<?php

class DescriptionUnemploymentData
{
	public static function getDescriptionNatureChomage($code)
	{
		$description = "";

		switch ($code) {
			case '00':
				$description = "Non indemnisable en tant que chômeur";

				break;

			case '01':
				$description = "Chômage complet admission à temps plein ";

				break;

			case '02':
				$description = "Chômage temporaire admission à temps plein";

				break;

			case '03':
				$description = "Chômage complet admission à temps partiel volontaire ";

				break;

			case '04':
				$description = "Chômage temporaire admission à temps partiel volontaire ";

				break;

			case '05':
				$description = "Travailleur à temps partiel ayant droit à l’allocation de garantie de revenu ";

				break;

			case '06':
				$description = "Travailleur à temps partiel indemnisable uniquement en chômage temporaire";

				break;

			case '07':
				$description = "inconnu";

				break;

			case '08':
				$description = "Importation de droits à partir d’un pays faisant partie de l’EEE";

				break;

			case '09':
				$description = "Prépensionné admission à temps plein";

				break;

			case '10':
				$description = "Prépensionné admission comme travailleur à temps partiel volontaire";

				break;

			case '11':
				$description = "Formation professionnelle ou allocation de formation ou de stage à temps plein ";

				break;

			case '12':
				$description = "Occupation en atelier protégé";

				break;

			case '13':
				$description = "inconnu";

				break;

			case '14':
				$description = "inconnu";

				break;

			case '15':
				$description = "Travailleur frontalier âgé";

				break;

			case '16':
				$description = "Allocation de chômage majorée durant le dernier mois de la formation professionnelle – travailleur à temps plein";

				break;

			case '17':
				$description = "Allocation de chômage majorée durant le dernier mois de la formation professionnelle – travailleur à temps partiel volontaire";

				break;

			case '18':
				$description = "Prépension à mi-temps";

				break;

			case '19':
				$description = "inconnu";

				break;

			case '20':
				$description = "inconnu";

				break;

			case '21':
				$description = "Allocations vacances jeunes";

				break;

			case '22':
				$description = "Allocations de vacances de seniors";

				break;

			case '23':
				$description = "inconnu";

				break;

			case '24':
				$description = "inconnu";

				break;

			case '25':
				$description = "inconnu";

				break;

			case '26':
				$description = "inconnu";

				break;

			case '27':
				$description = "inconnu";

				break;

			case '28':
				$description = "inconnu";

				break;

			case '29':
				$description = "inconnu";

				break;

			case '30':
				$description = "inconnu";

				break;

			case '31':
				$description = "Allocation de formation ou de stage à temps partiel ";

				break;

			case '32':
				$description = "inconnu";

				break;

			case '33':
				$description = "inconnu";

				break;

			case '34':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de mobilité ";

				break;

			case '35':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de garde d’enfants";

				break;

			case '36':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de mobilité et au complément de garde d’enfants";

				break;

			case '37':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de mobilité et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '38':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de garde d'enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '39':
				$description = "Chômeur temps partiel volontaire ayant droit au complément de mobilité, au complément de garde d'enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '40':
				$description = "Allocation d’établissement ";

				break;

			case '41':
				$description = "inconnu";

				break;

			case '42':
				$description = "inconnu";

				break;

			case '43':
				$description = "inconnu";

				break;

			case '44':
				$description = "Chômeur complet ayant droit au complément de mobilité";

				break;

			case '45':
				$description = "Chômeur complet ayant droit au complément de garde d’enfants";

				break;

			case '46':
				$description = "Chômeur complet ayant droit au complément de mobilité et au complément de garde d’enfants ";

				break;

			case '47':
				$description = "Chômeur temps complet ayant droit au complément de mobilité et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '48':
				$description = "Chômeur temps complet ayant droit au complément de garde d’enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '49':
				$description = "Chômeur temps complet ayant droit au complément de mobilité, au complément de garde d’enfants et au complément de 247,89 EUR pour avoir suivi une formation professionnelle";

				break;

			case '50':
				$description = "inconnu";

				break;

			case '51':
				$description = "inconnu";

				break;

			case '52':
				$description = "inconnu";

				break;

			case '53':
				$description = "inconnu";

				break;

			case '54':
				$description = "inconnu";

				break;

			case '55':
				$description = "inconnu";

				break;

			case '56':
				$description = "inconnu";

				break;

			case '57':
				$description = "Travailleur à temps partiel ayant droit à l’allocation de garantie de revenus (mesure à partir du 01.07.2005)";

				break;

			case '58':
				$description = "inconnu";

				break;

			case '59':
				$description = "inconnu";

				break;

		}

		return $description;
	}

	public static function getDescriptionSituationFamiliale($code)
	{
		$description = "";

		switch($code) {
			case 'EMPLOYEE_WITH_DEPENDANTS':
				$description = "Travailleur avec charge de famille. <img class='infobulle' title=\"une personne qui vit seule, mais qui paie par exemple une pension alimentaire, tombe sous cette catégorie\" src='includes/images/info.png'>";

				break;

			case 'SOLITARY':
				$description = "Isolé";

				break;

			case 'COHABITING':
				$description = "Cohabitant";

				break;
		}

		return $description;
	}

	public static function getDescriptionStatutApprobation($code)
	{
		$description = "";

		switch($code) {
			case 'COMPLETED':
				$description = "DEFINITIF <img class='infobulle' title=\"la procédure de vérification est terminée et le montant approuvé est communiqué\" src='includes/images/info.png'>";

				break;

			case 'PROVISIONAL':
				$description = "PROVISOIRE <img class='infobulle' title=\"la procédure de vérification est en cours, mais le montant approuvé provisoirement sera communiqué\" src='includes/images/info.png'>";

				break;

			case 'NOT_STARTED':
				$description = "NON COMMENCE <img class='infobulle' title=\"la procédure de vérification doit encore être entamée et le montant approuvé n'est pas rempli\" src='includes/images/info.png'>";

				break;
		}

		return $description;
	}
}
