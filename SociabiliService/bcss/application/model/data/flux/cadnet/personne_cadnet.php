<?php

class PersonneCadnet
{
	public static function formatNom($nom)
	{
		return rtrim($nom->name);
	}

	public static function formatPrenom($nom)
	{
		return rtrim($nom->firstName1);
	}

	public static function formatNumeroNational($nom)
	{
		return "<a href='index.php?env=member&page=person&action=display&rn=" . rtrim($nom->ssin) . "' class='rn'>" . rtrim($nom->ssin) . "</a>";
	}

	public static function format($nom)
	{
		return self::formatPrenom($nom) . " " . mb_strtoupper(self::formatNom($nom)) . " - " . self::formatNumeroNational($nom);
	}
}
