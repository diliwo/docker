<?php

class StatutSocialHealthinsurance
{
	public static function format($regime, $statuSocial, $typeCodeTitulaire=1, $typeRegimeCodeTitulaire1='')
	{
		if ($typeCodeTitulaire == 1) {
			if  ($regime == 1) {
				switch ($statuSocial) {
					case "0":
						return "résident";
						
						break;
						
					case "1":
						return "actif ou étudiant";
					
						break;
						
					case "2":
						return "invalide ou handicapé";
					
						break;
						
					case "3":
						return "pensionné";
							
						break;
						
					case "4":
						return "veuf/veuve";
							
						break;
						
					case "5":
						return "orphelin";
							
						break;
						
					case "8":
						return "convention internationale";
							
						break;
						
					default:
						return "inconnu";
						
						break;
						
				}
				
			} elseif($regime == 4) {
				switch ($statuSocial) {
					case "1":
						return "actif";
							
						break;
				
					case "2":
						return "invalide";
							
						break;
				
					case "3":
						return "pensionné";
							
						break;
				
					case "4":
						return "veuf/veuve";
							
						break;
				
					case "5":
						return "orphelin";
							
						break;
				
					case "7":
						return "membre d'une communauté religieuse";
							
						break;
				
					default:
						return "inconnu";
				
						break;
				
				}
				
			} else {
				return "inconnu";
				
			}
			
		} elseif ($typeCodeTitulaire == 2) {
			if (!empty($typeRegimeCodeTitulaire1)) {
				if ($typeRegimeCodeTitulaire1 == 1) {
					if  ($regime == 1) {
						switch ($statuSocial) {
							case "0":
								return "résident";
								
								break;
								
							case "1":
								return "actif ou étudiant";
							
								break;
								
							case "2":
								return "invalide ou handicapé";
							
								break;
								
							case "3":
								return "pensionné";
									
								break;
								
							case "4":
								return "veuf/veuve";
									
								break;
								
							case "5":
								return "orphelin";
									
								break;
								
							case "8":
								return "convention internationale";
									
								break;
								
							default:
								return "inconnu";
								
								break;
								
						}
						
					} else {
						return "inconnu";
						
					}
				} elseif ($typeRegimeCodeTitulaire1 == 4) {
					if  ($regime == 0) {
						switch ($statuSocial) {
							case "0":
								return "indépendant sans petits risques assurance libre";
									
								break;
									
							default:
								return "inconnu";
									
								break;
									
						}
							
					} elseif($regime == 1) {
						switch ($statuSocial) {
							case "0":
								return "résident";
									
								break;
									
							case "1":
								return "actif ou étudiant";
									
								break;
									
							case "2":
								return "invalide ou handicapé";
									
								break;
									
							case "3":
								return "pensionné";
									
								break;
									
							case "4":
								return "veuf/veuve";
									
								break;
									
							case "5":
								return "orphelin";
									
								break;
									
							case "8":
								return "convention internationale";
									
								break;
									
							default:
								return "inconnu";
									
								break;
									
						}
					} elseif($regime == 4) {
						switch ($statuSocial) {
							case "6":
								return "indepéndant avec droit petits risques tiré de l’assurance obligatoire";
					
								break;
									
							default:
								return "inconnu";
									
								break;
									
						}

					} elseif($regime == 9) {
						switch ($statuSocial) {
							case "0":
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
					return "inconnu";
					
				}
				
			} else {
				return "inconu";
			}
			
		}
	}
}