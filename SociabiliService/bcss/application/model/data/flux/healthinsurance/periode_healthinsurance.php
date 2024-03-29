<?php

class PeriodeHealthinsurance
{
	public static function format($periode)
	{
		if (isset($periode->StartDate)) {
			$dateTemp = explode("-", $periode->StartDate);
			$dateDebut = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
				
			if (isset($periode->EndDate)) {
				$dateTemp = explode("-", $periode->EndDate);
				$dateFin = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
		
				return "du " . $dateDebut . " au " . $dateFin;
		
			} else {
				return "du " . $dateDebut . " au ...";
		
			}
				
		} else {
			if (isset($periode->EndDate)) {
				$dateTemp = explode("-", $periode->EndDate);
				$dateFin = $dateTemp[2] . "/" . $dateTemp[1] ."/" . $dateTemp[0];
		
				return "du ... au " . $dateFin;
					
			} else {
				return "aucune période définie";
		
			}
				
		}
	}
	
}