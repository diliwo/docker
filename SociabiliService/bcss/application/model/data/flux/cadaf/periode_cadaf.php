<?php

require_once 'date_cadaf.php';

class PeriodeCadaf
{
	public static function format($periode)
	{
		if (isset($periode->endDate)) {
			return "du " . DateCadaf::format($periode->beginDate) . " au " . DateCadaf::format($periode->endDate);
			
		} else {
			return "du " . DateCadaf::format($periode->beginDate) . " au ...";
			
		}
	}
}