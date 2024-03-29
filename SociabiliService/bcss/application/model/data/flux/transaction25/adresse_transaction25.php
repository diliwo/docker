<?php

class AdresseTransaction25
{
	public static function format($adresse)
	{
		$adresseFormatee = "";
		
		// Ajout du numéro
		$adresseFormatee .= $adresse->HouseNumber;
		// Ajout de la boite
		if (isset($adresse->Box))
			$adresseFormatee .= "/" . $adresse->Box;
		
		// Ajout de la rue
		if (isset($adresse->Street->Graphic)) {
			$adresseFormatee .= ", " . $adresse->Street->Graphic;
		} else {
			$adresseFormatee .= ", " . $adresse->Street->Label;
		}
		
		// Ajout du code postal
		$adresseFormatee .= " - " . $adresse->ZipCode;
		
		return $adresseFormatee;
	}
}