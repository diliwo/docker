<?php
	class Tools
	{
		static function dump($variable)
		{
			echo "<pre style='text-align:left;'>";	
			if(is_string($variable))		
			{
				print_r(htmlentities($variable));		
			}		
			else		
			{		
				print_r($variable);		
			}
			echo "</pre>";	
		}
		
		static function completer_avec_caractere_a_gauche($variable_a_completer, $caractere, $longueur)
		{
			return sprintf("%".$caractere.$longueur."d", $variable_a_completer);
		}
		
		static function indexedArrayToXml($array, $xml = "")		
		{		
			foreach($array as $key => $value)		
			{		
				$xml .= "<".$key.">";		
				if(is_array($value))		
				{		
					$xml .= Tools::indexedArrayToXml($value);		
				}		
				else		
				{		
					$xml .= $value;		
				}		
				$xml .= "</".$key.">";		
			}		
			return $xml;		
		}
	}
	
?>