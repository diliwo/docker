<?php

class AdresseTypeTransaction25
{
	public static function format($adresse)
	{
		$adresseFormatee = "";
		
		// Graphic1 = ???
		if (isset($ti->Graphic1))
			$adresseFormatee .= "G1 " . $adresse->Graphic1;
		
		// Graphic2 = ???
		if (isset($ti->Graphic2))
			$adresseFormatee .= " - G2 " . $adresse->Graphic2;
		
		// Graphic3 = ???
		if (isset($ti->Graphic3))
			$adresseFormatee .= " - G2 " . $adresse->Graphic3;
		
		// Ajout du pays
		if (isset($ti->Country))
			$adresseFormatee .= " (" . $adresse->Country->Label . ")";
		
		
		return $adresseFormatee;
	}
}