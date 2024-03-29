<?php

class RegimeHealthinsurance
{
	public static function format($regime, $typeCodeTitulaire=1, $typeRegimeCodeTitulaire1='')
	{
		if ($typeCodeTitulaire == 1) {
			switch ($regime) {
				case "1":
					return "régime général (salarié)";
					
					break;
					
				case "4":
					return "régime indépendant";
					
					break;
					
				default:
					return "inconnu";
					
					break;
					
			}
			
		} elseif ($typeCodeTitulaire == 2) {
			if (!empty($typeRegimeCodeTitulaire1)) {
				if ($typeRegimeCodeTitulaire1 == 1) {
					if ($regime == 1) {
						return "régime général";
						
					} else {
						return "inconnu";
						
					}
					
				} elseif ($typeRegimeCodeTitulaire1 == 4) {
					switch ($regime) {
						case "0":
							return "indépendant sans petits risques assurance libre";
								
							break;
							
						case "1":
							return "régime actif pour indépendant maintien de droit";
						
							break;
								
						case "4":
							return "indepéndant avec droit petits risques tiré de l’assurance obligatoire";
								
							break;
							
						case "9":
							return "indépendant avec petits risques de l’assurance complémentaire";
						
							break;
								
						default:
							return "inconnu";
								
							break;
								
					}
					
				} else {
					return "inconnu";
					
				}
				
			} else {
				return "inconu";
			}
			
		}
	}
}