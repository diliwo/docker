<?php

class IdentificationPasseportTransaction25
{
	public static function format($identificationPasseport)
	{
		$identificationPasseportFormate = "";
		
		// Type
		$identificationPasseportFormate .= $identificationPasseport->PassportType->Label;
		// Pays
		if (isset($identificationPasseport->PassportNumber)) {
			$identificationPasseportFormate .= " ( " . $identificationPasseport->PassportNumber.")";
		}
		
		return $identificationPasseportFormate;
	}
}