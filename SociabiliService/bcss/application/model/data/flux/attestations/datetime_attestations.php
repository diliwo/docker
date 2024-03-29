<?php

class DatetimeAttestations
{
	public static function format($datetime)
	{
		$datetimeTemp = new DateTime($datetime);
		return $datetimeTemp->format('d/m/Y');
	}
}