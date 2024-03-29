<?php

class NomCompletTransaction25
{
	public static function formatNom($nom)
	{
		$nomFormate = "";
		
		if (is_array($nom->LastName)) {
			foreach ($nom->LastName as $lastName) {
				$nomFormate .= $lastName->Label . " ";
			}
		} else {
			$nomFormate .= $nom->LastName->Label;
		}
		
		return rtrim($nomFormate);
	}
	
	public static function formatPrenom($nom)
	{
		$prenomFormate = "";
	
		if (is_array($nom->FirstName)) {
			foreach ($nom->FirstName as $firstname) {
				$prenomFormate .= $firstname->Label . " ";
			}
		} else {
			$prenomFormate .= $nom->FirstName->Label;
		}
	
		return rtrim($prenomFormate);
	}
	
	public static function format($nom)
	{
		return self::formatPrenom($nom) . " " . mb_strtoupper(self::formatNom($nom));
	}
}