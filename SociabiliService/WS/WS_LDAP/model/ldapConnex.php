<?php


/**
*
*	Classe de connexion au LDAP:
*	In : Login / MDP
*	Out : - False erreur de connexion
*		  - Array contenant tous les datas de la personne si bien connecté
*
*/

class ldapConnex{
	
	/**
	 * Idem à htmlentities avec remplacement des caractères spéciaux
	 */
	protected function remplacer_caracteres_speciaux($ressource, $withoutSpaces = true)
	{
		// Remplacement de la TAB par un espace
		//$ressource = str_replace(chr(9), " ", $ressource);
		
		// Remplacement des CR LN en &#13; (ASCII de CR)
		$ressource = str_replace("\r\n", "&#13;", $ressource);
		$ressource = str_replace("&#8364;", "a", $ressource);
		// Remplacement de < par #'39'# car < dans une balise xml ne passe pas
		$ressource = str_replace("<", "#'39'#", $ressource);
		
		$ressource = str_replace("<", "#'39'#", $ressource);
		$ressource = str_replace("<", "#'39'#", $ressource);
		$ressource = str_replace("<", "#'39'#", $ressource);
		
		if ($withoutSpaces == true)
		{
			// Remplacement d'un double espace en un espace unique
			$ressource = preg_replace("/\s{2,}/", " ", $ressource);
		}
		
		// Remplacement des accents et caractères spéciaux en code ASCII de type &...;
		$ressource = htmlentities($ressource);
		
		return $ressource;
	}
	
	// Fonction de connexion au LDAP avec vérification supplémentaire dans la db mysql pour voir si c'est un admin
	public function connexion($log,$mdp)
	{
		
		//vérif non vide
		if(trim($log) != "" && trim($mdp) != "")
		{
			$login = addslashes($log);
			$pswd =  addslashes($mdp);
				
								
							//-------------------	
							//NOUVEAU DOMAINE
							//-------------------	
			
			
			// Fichier de configuration pour l'interface PHP
		   //  de notre annuaire LDAP
		   $server2 = "dc03.Cpas.schaerbeek.Dom";
		  
		
			$ldapconn2=ldap_connect($server2) or die ('hum qqch ne marche pas...');
			
			// Eléments d'authentification LDAP
			$ldaprdn2  = $login.'@cpas';     // DN ou RDN LDAP
			$ldappass2 = $pswd;  // Mot de passe associé
			
			//si on a su avoir une connexion au serveur ldap
			if ($ldapconn || $ldapconn2)
			{
				// Bind avec le serveur avec les donnée de l'utilisateur essayant de se connecter au serveur LDAP
				$ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
				// Bind avec le serveur avec les donnée de l'utilisateur essayant de se connecter au serveur LDAP
				$ldapbind2 = @ldap_bind($ldapconn2, $ldaprdn2, $ldappass2);
				
				// Vérification de l'authentification on teste d'abord si authentifié sur l'ancien domaine
				if ($ldapbind)
				{
					//recup les datas du user connecté
					$sr=  @ldap_search($ldapconn,"dc=cpas,dc=schaerbeek,dc=dom",'SAMAccountName='.$login.'');
					$info = @ldap_get_entries($ldapconn, $sr);
					
				
					$string = "";
					$string .= "<?xml version='1.0' encoding='ISO-8859-1'?>";
					$string .= "<user>";
						$string .= "<prenom>".str_replace('ç','c',$info[0]['givenname'][0])."</prenom>";
						$string .= "<nom>".str_replace('ç','c',$info[0]['sn'][0])."</nom>";
						$string .= "<email>".$info[0]['mail'][0]."</email>";
						$string .= "<samaccountname>".$info[0]['samaccountname'][0]."</samaccountname>";
						//$string .= "<dn>".$info[0]['dn']."</dn>";
						//$string .= "<cn>".$info[0]['cn'][0]."</cn>";
						$string .= "<groupes>";
						
					foreach($info[0]['memberof'] as $key=>$val)
					{
						$string .= "<donnee>".htmlentities($val)."</donnee>";	
					}
						
						$string .= "</groupes>";
					$string .= "</user>";
					
					return($string);
					
				//si pas on regarde sur le nouveau
				}
				elseif($ldapbind2)
				{
					// changement de la version du protocole pour pouvoir récupérer les users à partir de la racine (cpas.intra)
					ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($ldapconn2, LDAP_OPT_REFERRALS, 0);
					
					//recup les datas du user connecté
					$sr=  @ldap_search($ldapconn2,"DC=cpas,DC=schaerbeek,DC=dom","SAMAccountName=".$login."");
					$info = @ldap_get_entries($ldapconn2, $sr);
					
					$string = "";
					$string .= "<?xml version='1.0' encoding='ISO-8859-1'?>";
					$string .= "<user>";
						$string .= "<prenom>".$info[0]['givenname'][0]."</prenom>";
						$string .= "<nom>".str_replace('ç','c',$info[0]['sn'][0])."</nom>";
						$string .= "<email>".$info[0]['mail'][0]."</email>";
						$string .= "<samaccountname>".$info[0]['samaccountname'][0]."</samaccountname>";
						//$string .= "<dn>".str_replace(array("&ccedil;","&eacute;","&egrave;","&ecirc;","&agrave;","&euml;"),array("c","e","e","e","a","e"),htmlentities(utf8_decode($info[0]['dn'])))."</dn>";
						//$string .= "<cn>".str_replace(array("&ccedil;","&eacute;","&egrave;","&ecirc;","&agrave;","&euml;"),array("c","e","e","e","a","e"),htmlentities(utf8_decode($info[0]['cn'][0])))."</cn>";
						$string .= "<groupes>";
						
						foreach($info[0]['memberof'] as $key=>$val)
						{
							$string .= "<donnee>".str_replace(array("&eacute;","&egrave;","&ecirc;","&agrave;","&euml;"),array("e","e","e","a","e"),htmlentities(utf8_decode($val)))."</donnee>";
						}
						
						$string .= "</groupes>";
					$string .= "</user>";
					
					return($string);
					
					
				}
				else
				{
					//Error Code 2 : "Vous avez entré un mauvais login ou mauvais mot de passe"
					return (2);
				}
		
			}
			else
			{
				//Error Code 5 : 'Erreur de connexion au réseau du CPAS'
				return (5);	
			}
		}
		else
		{
			//Error Code 4 : 'Veuillez remplir tous les champs du formulaire de connexion'
			return (4);	
		}
	}
	
	//ajouté par Thomas le 27/12/2011
	public function GetMembresGroupe($groupe)
	{
		
		$server2 = "msrv4";
		$ldapconn2=ldap_connect($server2) or die ('hum qqch ne marche pas...');
		if ($ldapconn2) 
		{
			$ldaprdn2  = 'SOCIAL';     // DN ou RDN LDAP
			$ldappass2 = '@ccèsLDAP-O-L0g1ciel_SOçiAl&bAnque4foµr';  // Mot de passe associé
			
			$ldapbind2 = @ldap_bind($ldapconn2, $ldaprdn2, $ldappass2);
			if($ldapbind2 )
			{
				// changement de la version du protocole pour pouvoir récupérer les users à partir de la racine (cpas.intra)
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				ldap_set_option($ldapconn2, LDAP_OPT_REFERRALS, 0);
			
				//recup les datas du user connecté
				$sr=  @ldap_search($ldapconn2,"dc=cpas,dc=schaerbeek,dc=dom",$groupe);
				$info = @ldap_get_entries($ldapconn2, $sr);	
				
				ob_start(); 
				var_dump($info[0]["member"][0]);
				$tab_debug=ob_get_contents(); 
				ob_end_clean(); 
				
				$string = "<?xml version='1.0' encoding='ISO-8859-1'?>";
				for($i = 0; $i < $info[0]["member"]["count"]; $i++)
				{
					$temp = substr(htmlentities($info[0]["member"][0]),3, strpos(htmlentities($info[0]["member"][0]),',',3)-3);
					$prenom = substr($temp,'0',strpos($temp,' '));
					$nom = substr($temp,strpos($temp,' ')+1);
					$string .= "<user><prenom>".str_replace('ç','c',$prenom)."</prenom><nom>".str_replace('ç','c',$nom)."</nom></user>";
				}
			}
			else
			{
				$string = "<?xml version='1.0' encoding='ISO-8859-1'?><test>erreur</test>";
			}

		}
		else
		{
			$string = "<?xml version='1.0' encoding='ISO-8859-1'?><test>erreur</test>";
		}
		
		
		return $string;
	}	
}

?>
