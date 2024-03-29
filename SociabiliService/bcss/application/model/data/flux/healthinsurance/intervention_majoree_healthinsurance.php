<?php

class InterventionMajoreeHealthinsurance
{
	public static function format($interventionMajoree)
	{
		switch ($interventionMajoree) {
			case "0":
				return "sans droit sur intervention majorée";
				
				break;
				
			case "1":
				return "avec droit sur intervention majorée";
				
				break;
				
			default:
				return "inconnu";
				
				break;
				
		}
			
	}
}