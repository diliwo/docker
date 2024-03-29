<?php

class AdresseIdentifyPerson
{
	public static function format($adresse)
	{
		$adresseFormatee = "";
		
		// Ajout du numéro
		if ($adresse->HouseNumber != "0") {
			$adresseFormatee .= $adresse->HouseNumber;
			// Ajout de la boite
			if (isset($adresse->Box))
				$adresseFormatee .= "/" . $adresse->Box;
			// Ajout de la rue
			$adresseFormatee .= ", " . $adresse->Street;
			// Ajout du code postal
			$adresseFormatee .= " - " . $adresse->PostalCode;
			// Ajout de la ville
			$adresseFormatee .= " " . $adresse->Municipality;
		}
		
		return $adresseFormatee;
	}
}