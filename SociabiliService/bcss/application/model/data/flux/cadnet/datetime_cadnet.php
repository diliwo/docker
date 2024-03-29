<?php

class DatetimeCadnet
{
	public static function format($datetime)
	{
		$datetimeTemp = new DateTime($datetime);
		return $datetimeTemp->format('d/m/Y');
		
		/*
		$dateTemp = explode("T", $datetime);
		return $dateTemp[2] . "/" . $dateTemp[1] . "/" .$dateTemp[0];
		*/
	}
}