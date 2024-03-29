<?php

class DateUnemploymentData
{
	public static function format($date)
	{
		$dateTemp = explode("-", $date);
		return $dateTemp[2] . "/" . $dateTemp[1] . "/" . $dateTemp[0];
	}
	public static function formatMonth($month)
	{
		$dateTemp = explode("-", $month);
		switch ($dateTemp[1]) {
			case '1':
				return "janvier " . $dateTemp[0];
				break;

			case '2':
				return "février " . $dateTemp[0];
				break;

			case '3':
				return "mars " . $dateTemp[0];
				break;

			case '4':
				return "avril " . $dateTemp[0];
				break;

			case '5':
				return "mai " . $dateTemp[0];
				break;

			case '6':
				return "juin " . $dateTemp[0];
				break;

			case '7':
				return "juillet " . $dateTemp[0];
				break;

			case '8':
				return "août " . $dateTemp[0];
				break;

			case '9':
				return "septembre " . $dateTemp[0];
				break;

			case '10':
				return "octobre " . $dateTemp[0];
				break;

			case '11':
				return "novembre " . $dateTemp[0];
				break;

			case '12':
				return "décembre " . $dateTemp[0];
				break;
			
			default:
				return "? " . $dateTemp[0];
				break;
		}
		
	}
}