<?php

class DateCadaf
{
	public static function format($date)
	{
		$dateTemp = explode("-", $date);
		return $dateTemp[2] . "/" . $dateTemp[1] . "/" .$dateTemp[0];
	}
}