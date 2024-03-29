<?php

require_once "date_transaction25.php";

class NumeroNationalTransaction25
{
	public static function format($numeroNational)
	{
		$numeroNationalFormate = "";

		if ($numeroNational->Sex == 1) {
			$numeroNationalFormate .= "Homme";
		} else {
			$numeroNationalFormate .= "Femme";
		}
		$numeroNationalFormate .= " - <a href='index.php?env=member&page=person&action=display&rn=" . $numeroNational->NationalNumber . "' class='rn'>" . $numeroNational->NationalNumber . "</a> (" . DateTransaction25::format($numeroNational->Date) . ")";

		return $numeroNationalFormate;
	}
}
