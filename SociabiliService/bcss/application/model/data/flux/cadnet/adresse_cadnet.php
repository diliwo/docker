<?php

class AdresseCadnet
{
	public static function format($adresse)
	{
		$adresseFormatee = "";
		
		// Ajout du numéro
		$adresseFormatee .= $adresse->houseNumber;
		// Ajout de la boite
		if (isset($adresse->Box))
			$adresseFormatee .= "/" . $adresse->box;
		// Ajout de la rue
		$adresseFormatee .= ", " . $adresse->street;
		// Ajout du code postal
		$adresseFormatee .= " - " . $adresse->postalCode;
		// Ajout de la ville
		$adresseFormatee .= " " . $adresse->city;
		
		return $adresseFormatee;
	}
}