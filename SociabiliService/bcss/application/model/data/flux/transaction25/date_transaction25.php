<?php

class DateTransaction25
{
	public static function format($date)
	{
		return $date->Day . "/" . $date->Month . "/" . $date->Century . $date->Year;
	}
}