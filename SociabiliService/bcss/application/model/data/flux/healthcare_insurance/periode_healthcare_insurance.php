<?php

class PeriodeHealthcareInsurance
{
	public static function format($periode)
	{
		if (isset($periode->startDate)) {
			$dateTemp = explode("-", $periode->startDate);
			$dateDebut = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
				
			if (isset($periode->endDate)) {
				$dateTemp = explode("-", $periode->endDate);
				$dateFin = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
		
				return "du " . $dateDebut . " au " . $dateFin;
		
			} else {
				return "du " . $dateDebut . " au ...";
		
			}
				
		} else {
			if (isset($periode->endDate)) {
				$dateTemp = explode("-", $periode->endDate);
				$dateFin = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
		
				return "du ... au " . $dateFin;
					
			} else {
				return "aucune période définie";
		
			}
				
		}
	}
	
}