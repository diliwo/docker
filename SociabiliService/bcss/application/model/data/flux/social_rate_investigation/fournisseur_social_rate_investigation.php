<?php

class FournisseurSocialRateInvestigation
{
	public static function format($adresse)
	{
		$adresseFormatee = "";

		// Ajout du numéro
		if ($adresse->houseNu != "0") {
			$adresseFormatee .= $adresse->houseNu;
			// Ajout de la boite
			if (isset($adresse->boxNu))
				$adresseFormatee .= "/" . $adresse->boxNu;
			// Ajout de la rue
			$adresseFormatee .= ", " . $adresse->streetName;
			// Ajout du code postal
			$adresseFormatee .= " - " . $adresse->postalCode;
			// Ajout de la ville
			$adresseFormatee .= " " . $adresse->cityName;
		}

		return $adresseFormatee;
	}
}
