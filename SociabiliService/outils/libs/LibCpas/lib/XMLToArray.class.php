<?php
/**
*	\file XMLToArray.class.php
*	\brief Cette classe permet de manipuler et d'afficher plus aisément les chaines de caractères XML
*	\details Grâce à cette classe, on peut retrouver la valeurs de chaque balise d'un nom spécifique, ou qu'elle se trouve dans l'arborescence du XML. On peut également récupérer la chaine XML sous forme d'un tableau PHP.
*	\date Mars 2013
*	\author Thomas Favay
*	\version 2.0
*/

require_once("Tools.class.php");

/**
*	\class XMLToArray
*	\brief Cette classe permet de manipuler et d'afficher plus aisément les chaines de caractères XML.
*	\details Grâce à cette classe, on peut retrouver la valeurs de chaque balise d'un nom spécifique, ou qu'elle se trouve dans l'arborescence du XML. On peut également récupérer la chaine XML sous forme d'un tableau PHP.
*	\date Mars 2013
*	\version 2.0
*	\author Thomas Favay
*/
class XMLToArray
{	
	/**
	* \brief Cette variable est utilisée pour la transformation en Array de la chaine XML.
	*/
	private $chaine_en_cours = "";
	
	/**
	* \brief Cette variable est utilisée pour la transformation en Array de la chaine XML.
	*/
	private $derniereBalisesTrouvees = array();
	
	/**
	* \brief Cette variable contient la chaine de caractères XML originale envoyée au constructeur. Peut être néanmoins modifiée par la fonction #enleverInfo().
	*/
	private $xmlOriginal;
	
	/**
	* \brief Cette variable contient l'array correspondant à la chaine de caractères XML originale envoyée au constructeur.
	*/
	private $array;
	
	/**
	* \brief La couleur des balises xml lors de l'affichage du XML en HTML.
	*/
	private $couleurBalise;
	
	/**
	* \brief La couleur de fond à utiliser lors de l'affichage du XML en HTML.
	*/
	private $couleurFond;
	
	/**
	* \brief La couleur de la bordure lors de l'affichage du XML en HTML.
	*/
	private $couleurBordure;
	
	/**
	* \brief La couleur des données contenues dans les balises xml lors de l'affichage du XML en HTML.
	*/
	private $couleurDonnee;
	
	/**
	* \brief La couleur des attributs contenus dans les balises xml lors de l'affichage du XML en HTML.
	*/
	private $couleurAttribut;
	
	/**
	* \brief La couleur des valeurs de attributs contenus dans les balises xml lors de l'affichage du XML en HTML.
	*/
	private $couleurValeurAttribut;
	
	/**
	*
	* \param $xml Le xml en chaine de caractère à utiliser.
	* \param $couleurFondEnvoyee La couleur de fond à utiliser lors de l'affichage du XML en HTML.
	* \param $couleurBordureEnvoyee La couleur de la bordure lors de l'affichage du XML en HTML.
	* \param $couleurBaliseEnvoyee La couleur des balises xml lors de l'affichage du XML en HTML.
	* \param $couleurDonneeEnvoyee La couleur des données contenues dans les balises xml lors de l'affichage du XML en HTML.
	* \param $couleurAttributEnvoyee La couleur des attributs contenus dans les balises xml lors de l'affichage du XML en HTML.
	* \param $couleurValeurAttributEnvoyee La couleur des valeurs de attributs contenus dans les balises xml lors de l'affichage du XML en HTML.
	* \details Constructeur de la classe XMLToArray, on peut définir des couleurs pour l'affichage du XML si les couleurs par défaut.
	* \brief Constructeur de la classe XMLToArray.
	* \return Un objet XMLToArray prêt à être utilisé.
	*/
	public function __construct ($xml,$couleurFondEnvoyee ="white",$couleurBordureEnvoyee = "black",$couleurBaliseEnvoyee = "red",$couleurDonneeEnvoyee = "blue",$couleurAttributEnvoyee = "black", $couleurValeurAttributEnvoyee = "green")
    {
		
		$this->xmlOriginal = $xml; 		
		
		$this->enleverInfo();
		$this->chaine_en_cours = str_replace("\n","",str_replace("\r","",trim($this->xmlOriginal))); 
		$this->array = $this->transformeEnArray();
		
		$this->couleurBalise = $couleurBaliseEnvoyee;
		$this->couleurFond= $couleurFondEnvoyee;
		$this->couleurBordure= $couleurBordureEnvoyee;
		$this->couleurDonnee= $couleurDonneeEnvoyee;
		$this->couleurAttribut= $couleurAttributEnvoyee;
		$this->couleurValeurAttribut= $couleurValeurAttributEnvoyee;
	}
	
	/**
	* \details Supprime les balises de type <? ?> comme par exemple : <?xml version="1.0" encoding="UTF-8"?> de la variable #$xmlOriginal .
	* \brief Cette fonction enleve les balises d'information de la variable #$xmlOriginal .
	*/
	private function enleverInfo()
	{
		$position1 = strpos($this->xmlOriginal,"<?");
		if($position1 !== false)
		{
			$position2 = strpos($this->xmlOriginal,"?>");
			$this->xmlOriginal = substr($this->xmlOriginal,$position2+2);
		}
	}
	
	/**
	* \brief Transforme en Array la chaine en cours.
	* \sa recupererProchaineBaliseEtSesAttributs(), recupererChaineApresProchaineBalise(), analyseContenuBalise(), recupererTexte()
	*/
	public function transformeEnArray()
	{
		//Entree dans un nouveau niveau avec la chaine $this->chaine_en_cours.
		$balisesTrouvees = array(); 
				
		while(!empty($this->chaine_en_cours))
		{
			//On analyse la chaine $this->chaine_en_cours.
			$analyseContenu = $this->analyseContenuBalise($this->chaine_en_cours);
			if($analyseContenu == 1)
			{
				//La chaine contient une ou des balises.
				$balise = $this->recupererProchaineBaliseEtSesAttributs($this->chaine_en_cours);				
				$this->derniereBalisesTrouvees[] = $balise;	
				$balisesTrouvees[] = $balise;
				$this->chaine_en_cours = $this->recupererChaineApresProchaineBalise($this->chaine_en_cours);		
				
				if (strcmp($this->chaine_en_cours,'')!=0)
				{
					//Si la chaine en cours n'est pas vide
					$analyseContenu = $this->analyseContenuBalise($this->chaine_en_cours);
					if($analyseContenu == 0)
					{
						//La balise ne contient que du texte.						
						$balisesTrouvees[count($balisesTrouvees)-1]["contenu"] = $this->recupererTexte($this->chaine_en_cours);
						
						$this->chaine_en_cours = $this->recupererChaineApresProchainTexte($this->chaine_en_cours);		
						array_pop($this->derniereBalisesTrouvees);				
						$this->chaine_en_cours = $this->recupererChaineApresProchaineBalise($this->chaine_en_cours);	
					}	
					else
					{
						//la balise contient d'autres balises.
						$temp = $this->transformeEnArray($this->chaine_en_cours);												
						if(empty($temp))
						{
							$balisesTrouvees[count($balisesTrouvees)-1]["contenu"] = "";
						}
						else
						{
							$balisesTrouvees[count($balisesTrouvees)-1]["contenu"] = $temp;
						}						
					}					
				}				
			}
			else if($analyseContenu == 2)
			{				
				array_pop($this->derniereBalisesTrouvees);				
				$this->chaine_en_cours = $this->recupererChaineApresProchaineBalise($this->chaine_en_cours);	
				return $balisesTrouvees;
			}
			else if($analyseContenu == 3)
			{
			
				$balise = $this->recupererProchaineBaliseEtSesAttributs($this->chaine_en_cours);	
			
				$balisesTrouvees[] = $balise;
				$this->chaine_en_cours = $this->recupererChaineApresProchaineBalise($this->chaine_en_cours);	
			}			
			else
			{
				//La chaine ne contient que du texte.			
				$this->chaine_en_cours = $this->recupererChaineApresProchainTexte($this->chaine_en_cours);
				return $this->recupererTexte($this->chaine_en_cours);
			}		
		}
		
		return $balisesTrouvees;
	}
	
	public function getArray()
	{
		return $this->array;		
	}
	
	/**
	* \brief Recherche les balises voulues dans l'Array envoyé.
	* \param $array_a_traiter Array dans lequel rechercher les balises.
	* \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	* \param $nom Nom des balises recherchées.
	* \returns Un Array contenant les résultat trouvés.
	*/
	public function rechercherBalises($array_a_traiter,$array_contenu,$nom)
	{
		if(is_array($array_a_traiter))
		{
			foreach($array_a_traiter as $element_a_traiter)
			{
				if(is_array($element_a_traiter["contenu"]))
				{					
					$array_contenu = $this->rechercherBalises($element_a_traiter["contenu"],$array_contenu,$nom);
				}
				
				if(strcmp($element_a_traiter["nom"],$nom) == 0)
				{					
					$temp = array();
					$temp["nom"] = $element_a_traiter["nom"];
					$temp["contenu"] = $element_a_traiter["contenu"];
					$temp["attributs"] = $element_a_traiter["attributs"];
					
					$array_contenu[] = $temp;
				}				
			}				
		}
		return $array_contenu;
	}
	
	
	
	/**
	* \brief Recherche les balises voulues dans l'objet courant.
	* \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	* \param $nom Nom des balises recherchées.
	* \param $numero Numéro d'ordre de la balise recherchée. Par défaut, toutes les balises sont renvoyées
	* \returns Un Array contenant les résultat trouvés.
	*/
	public function rechercherBalisesDansObjet($nom, $numero = -1)
	{
		$array_contenu = array();
		
		$array_a_renvoyer = array();
		
		if(empty($this->array))
		{
			$this->array = $this->transformeEnArray();
		}		
		
		if(is_array($this->array))
		{
			foreach($this->array as $element_a_traiter)
			{
				if( isset( $element_a_traiter["contenu"]) )
				{
					if( is_array( $element_a_traiter["contenu"] ) )
					{					
						$array_a_renvoyer = $this->rechercherBalises($element_a_traiter["contenu"],$array_a_renvoyer,$nom);
					}
				}
				
				if(!empty($element_a_traiter["nom"]) && strcmp($element_a_traiter["nom"],$nom) == 0)
				{
					$temp = array();
					$temp["nom"] = $element_a_traiter["nom"];
					$temp["contenu"] = $element_a_traiter["contenu"];
					$temp["attributs"] = $element_a_traiter["attributs"];
					
					if(empty($array_a_renvoyer))
					{
						$array_a_renvoyer = $temp;
					}
					else if (array_key_exists("nom", $array_a_renvoyer))
					{
						$temp2 = array();
						$temp2[] = $array_a_renvoyer;
						$temp2[] = $temp;
						$array_a_renvoyer = $temp2;
					}
					else 
					{
						$array_a_renvoyer[] = $temp;
					}
				}
			}				
		}
				
		if($numero-1 < 0)
		{
			return $array_a_renvoyer;			
		}
		else if(array_key_exists($numero-1, $array_a_renvoyer) || $numero == 0)
		{
			return $array_a_renvoyer[$numero-1];
		}
		else
		{
			return array();			
		}
	}
	
	
	
	/**
	* \brief Recherche les balises voulues dans l'Array envoyé.
	* \param $array_a_traiter Array dans lequel rechercher les balises.
	* \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	* \param $nom Nom des balises recherchées.
	* \returns Un Array contenant les résultat trouvés.
	*/
	public static function rechercherBalisesDansArray($array_a_traiter,$array_contenu,$nom)
	{
		if(is_array($array_a_traiter))
		{
			if(isset($array_a_traiter[0]["contenu"]))
			{
				//tableau de l'objet XMLToArray avec sa structure particulière
				foreach($array_a_traiter as $element_a_traiter)
				{
					if(is_array($element_a_traiter["contenu"]))
					{					
						$array_contenu = XMLToArray::rechercherBalisesDansArray($element_a_traiter["contenu"],$array_contenu,$nom);
					}
					
					if(strcmp($element_a_traiter["nom"],$nom) == 0)
					{
						$temp = array();
						$temp["nom"] = $element_a_traiter["nom"];
						$temp["contenu"] = $element_a_traiter["contenu"];
						$temp["attributs"] = $element_a_traiter["attributs"];
						
						$array_contenu[] = $temp;
					}				
				}
			}
			else
			{
				//tableau classique			
				foreach($array_a_traiter as $key => $contenu)
				{
					if(is_array($contenu))
					{					
						$array_contenu = XMLToArray::rechercherBalisesDansArray($contenu,$array_contenu,$nom);
					}
					
					if(strcmp($key,$nom) == 0)
					{
						$temp = array();
						$temp["nom"] = $key;
						$temp["contenu"] = $contenu;
						
						
						$array_contenu[] = $temp;
					}				
				}	
			}
		}
		return $array_contenu;		
	}
	
	/**
	* \brief Recherche la première balise voulue dans l'Array envoyé.
	* \param $array_a_traiter Array dans lequel rechercher la balise.
	* \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	* \param $nom Nom de la balise recherchée.
	* \returns Le contenu de la balise trouvée.
	*/
	public static function PremierDansArray($array_a_traiter,$array_contenu,$nom,$niveau = 0)
	{
		$niveau++;
		if(is_array($array_a_traiter))
		{
			if(isset($array_a_traiter[0]["contenu"]))
			{
				//tableau de l'objet XMLToArray avec sa structure particulière
				foreach($array_a_traiter as $element_a_traiter)
				{
					if(is_array($element_a_traiter["contenu"]))
					{					
						$array_contenu = XMLToArray::PremierDansArray($element_a_traiter["contenu"],$array_contenu,$nom,$niveau);
					}
					
					if(strcmp($element_a_traiter["nom"],$nom) == 0)
					{
						$temp = array();
						$temp["nom"] = $element_a_traiter["nom"];
						$temp["contenu"] = $element_a_traiter["contenu"];
						$temp["attributs"] = $element_a_traiter["attributs"];
						
						$array_contenu[] = $temp;
					}				
				}
			}
			else
			{
				//tableau classique			
				foreach($array_a_traiter as $key => $contenu)
				{
					if(is_array($contenu))
					{					
						$array_contenu = XMLToArray::PremierDansArray($contenu,$array_contenu,$nom,$niveau);
					}
					
					if(strcmp($key,$nom) == 0)
					{
						$temp = array();
						$temp["nom"] = $key;
						$temp["contenu"] = $contenu;
						
						$array_contenu[] = $temp;
					}				
				}	
			}
		}
		
		if($niveau == 1)
		{
			return $array_contenu[0]["contenu"];	
		}
		else
		{
			return $array_contenu;	
		}		
	}
	
	/**
	* \brief Analyse la chaine envoyée.
	* \param $reste Chaine à analyser.
	* \returns \li 0 Si la chaine ne contient que du texte.
	*             \li 1 Si la première balise trouvée est une balise ouvrante .
	*             \li 2 Si la première balise trouvée est une balise fermante .
	*             \li 3 Si la première balise trouvée est une balise auto-fermante (&lt;nom /&gt;) .
	*/
	public function analyseContenuBalise($reste)
	{
		//On trouve la premiere balise a apparaitre
		$position1 = strpos($reste,"<");
		$position2 = strpos($reste,"</");
		
		$position3 = strpos($reste,"/>");
		$position4 = strpos($reste,">");
		
		if($position1 > 0)
		{
			//il y a du texte
			return 0;
		}
		else
		{
			if($position1 === false)
			{			
				return 0;
			}
			else if($position2 == $position1 && $position2 !== false)
			{
				return 2;			
			}
			else
			{
				// a vérifier si balise auto-fermante
				if($position3!==false && $position3+1 == $position4)
				{
					return 3;
				}
				else
				{
					return 1;
				}				
			}
		}		
	}
	
	/**
	* \brief Détecte la première balise rencontrée dans la chaine envoyée ainsi que ses attributs.
	* \param $reste Chaine à analyser.
	* \returns La balise trouvée avec ses attributs sous forme d'un array.
	*/
	public function recupererProchaineBaliseEtSesAttributs($reste)
	{
		//On trouve la premiere balise a apparaitre
		$position1 = strpos($reste,"<");
		if($position1 === false)
		{
			//pas de balise trouvee
			echo "ERREUR !!!";
			return -1;
		}
		else
		{
			$balise["attributs"] = array();
			$temp = array();
			$temp2 = array();
			$temp3 = array();
			
			//on a au moins une balise
			$position2 = strpos($reste,">",$position1);
			$position4 = strpos($reste," ",$position1);		
			$position6 = strpos($reste,"/>",$position1);
			
			//on regarde les attributs
			$debut_recherche_attribut = $position1+1;
			
			$reste_pour_recherche_attribut = $reste;				
			
			$reste_pour_recherche_attribut = substr($reste_pour_recherche_attribut,$debut_recherche_attribut,$position2-$debut_recherche_attribut);
			
			while(strpos($reste_pour_recherche_attribut,"=") !== false)
			{
				// echo "\nOn analyse ->".htmlentities($reste_pour_recherche_attribut)."<-<br />";
				
				$position_debut_attribut = strpos(substr($reste_pour_recherche_attribut,0)," ")+1;
				// echo "position_debut_attribut : ".($position_debut_attribut)."<br />";
				
				// echo "On recherche le premier attribut dans ->".substr($reste_pour_recherche_attribut,$position_debut_attribut,$position2-$position_debut_attribut)."<- avec les valeurs : ".($position_debut_attribut).",".($position2-$position_debut_attribut)."<br />";
				
				
				//est-ce d'abord des " ou des ' ?
				$position_debut_valeur_attribut1 = strpos(substr($reste_pour_recherche_attribut,$position_debut_attribut,$position2-$position_debut_attribut),"'");
				$position_debut_valeur_attribut2 = strpos(substr($reste_pour_recherche_attribut,$position_debut_attribut,$position2-$position_debut_attribut),"\"");
				
				$delimiteur = "";
				
				if($position_debut_valeur_attribut1 !== false && $position_debut_valeur_attribut2 !== false)
				{
					//si il y a les deux types de guillements
					if($position_debut_valeur_attribut1 < $position_debut_valeur_attribut2)
					{
						//ca commence par des '
						$delimiteur = "'";
					}
					else
					{
						//ca commence par des "
						$delimiteur = "\"";
					}
				}
				else if($position_debut_valeur_attribut1 === false && $position_debut_valeur_attribut2 === false)
				{
					echo "Erreur dans un attribut<br />";
					return 0;
				}
				else
				{
					if($position_debut_valeur_attribut1 === false)
					{
						$delimiteur = "\"";
					}
					else
					{
						$delimiteur = "'";
					}
				}					
			
				$position_debut_valeur_attribut = strpos(substr($reste_pour_recherche_attribut,$position_debut_attribut,$position2-$position_debut_attribut),$delimiteur);//+$position_debut_attribut;					
				
				$position_debut_valeur_attribut += $position_debut_attribut;
				// echo "la valeur de l'attribut commence en position : ".$position_debut_valeur_attribut ."<br />";
				//on chope le deuxieme
				// echo "On recherche le 2eme \" dans ->".substr($reste_pour_recherche_attribut,$position_debut_valeur_attribut+1,$position2-$position_debut_valeur_attribut)."<-<br />";
				$position_fin_valeur_attribut = strpos(				 substr($reste_pour_recherche_attribut,$position_debut_valeur_attribut+1,$position2-$position_debut_valeur_attribut),$delimiteur);						
				
				$position_fin_valeur_attribut += $position_debut_valeur_attribut+2;
				// echo "la valeur de l'attribut fini en position : ".$position_fin_valeur_attribut ."<br />";
				// echo "la balise se ferme en position : ".$position2."<br />";
				
				$chaine = substr($reste_pour_recherche_attribut,$position_debut_attribut, $position_fin_valeur_attribut-$position_debut_attribut);
				// echo "On travaille alors sur la chaine ->".$chaine."<-<br />";
									
				
				$temp = explode("=", $chaine);
				$temp2 = array();
				$temp2["nom"] = $temp[0];
				
				$temp2["valeur"] = substr($temp[1],1,strlen($temp[1])-2);
				$temp3[] = $temp2;
				
				// echo "Attribut détecté pour ->".htmlentities($chaine)."<-<br />";
				// echo "on a  : ".$temp2["nom"]."->".$temp2["valeur"]."<-<br />";
				
				$reste_pour_recherche_attribut = substr($reste_pour_recherche_attribut,$position_fin_valeur_attribut,$position2-$position_fin_valeur_attribut);
				// echo "reste a checker : <pre> ".htmlentities($reste_pour_recherche_attribut)."</pre><br /><br />";
			}
							
			//si c'est une balise fermante, ça change tout !		
			if(($position6 < $position2) && (!empty($position6)))
			{
				//La balise se ferme direct sans contenu
				if($position6 < $position4 && (!empty($position4)))
				{
					$nomBalise = (substr($reste,$position1+1,$position6-$position1-1));
				}
				else
				{
					$nomBalise =  (substr($reste,$position1+1,$position4-$position1-1));											
				}			
				//$tableau["balise"] = $nomBalise;						
				$balise["nom"] = $nomBalise;
				$balise["attributs"] = $temp3;
				$balise["contenu"] = "";
				
				
				$tableau_de_balise[] = $balise;	
				
				$reste = substr($reste,$position6+2);
			}
			else
			{				
				if($position2 < $position4 || (empty($position4)))
				{
					$nomBalise = (substr($reste,$position1+1,$position2-$position1-1));
					$balise["nom"] = $nomBalise;	
					$balise["attributs"] = $temp3;
				}
				else
				{
					$nomBalise =  (substr($reste,$position1+1,$position4-$position1-1));
					$balise["nom"] = $nomBalise;
					$balise["attributs"] = $temp3;
				}
			}
		}
		
		
		return $balise;		
	}
	
	/**
	* \brief Récupère la chaine après la première balise détectée dans la chaine envoyée.
	* \param $reste Chaine à analyser.
	* \returns La chaine après la première balise détectée dans la chaine envoyée.
	*/
	public function recupererChaineApresProchaineBalise($reste)
	{
		$position = strpos($reste,">");
		return substr($reste,$position+1);
	}
	
	/**
	* \brief Récupère la chaine commençant à partir de la première balise trouvée.
	* \param $reste Chaine à analyser.
	* \returns La chaine commençant à partir de la première balise trouvée.
	*/
	public function recupererChaineApresProchainTexte($reste)
	{
		$position = strpos($reste,"<");
		return substr($reste,$position);
	}
	
	/**
	* \brief Récupère la chaine se trouvant avant la première balise trouvée.
	* \param $reste Chaine à analyser.
	* \returns La chaine se trouvant avant la première balise trouvée.
	*/
	public function recupererTexte($reste)
	{
		$position = strpos($reste,"<");
		return substr($reste,0,$position);
	}
	
	/**
	* \brief Affiche une balise div contenant le XML.
	* \param $afficherNiveaux Défini si il faut afficher les niveaux du XML avec des lignes verticales. True par défaut.
	* \sa transformeEnArray(), printInHTML()
	*/
	public function afficherEnHtml($afficherNiveaux = true)
	{
		if(empty($this->array))
		{
			$this->array = $this->transformeEnArray();
		}		
		$table = $this->array;
		echo "<div style='margin:auto;width:800px;overflow:scroll;border:1px ".$this->couleurBordure." solid;padding:5px;background-color:".$this->couleurFond.";text-align:left;'>";		
		$this->printInHTML($table,-1,$afficherNiveaux);	
		echo "</div>";
	}
	
	/**
	* \brief Affiche la tableau envoyé comme une balise div contenant le XML .
	* \param $array Le tableau à afficher.
	* \sa staticPrintInHTML()
	*/
	public static function afficherArrayEnXml($array)
	{		
		echo "<div style='margin:auto;width:800px;overflow:scroll;border:1px black solid;padding:5px;background-color:white;text-align:left;'>";		
		XMLToArray::staticPrintInHTML($array,-1,false);	
		echo "</div>";
	}
	
	/**
	* \brief Affiche la tableau envoyé comme du code HTML représentant le XML .
	* \param $array_a_traiter Le tableau à afficher.
	* \param $niveau Le niveau actuel dans l'arborescence, utilisé récursivement pour gérer l'indentation.
	* \param $afficherNiveaux Défini si il faut afficher les niveaux du XML avec des lignes verticales. 
	* \sa genereEspace(), staticGenereEspace()
	*/
	private static function staticPrintInHTML($array_a_traiter,$niveau,$afficherNiveaux)
	{
		//si un tableau est envoyé
		if(is_array($array_a_traiter))
		{			
			$niveau ++;
			$size = count($array_a_traiter);
			$keys = array_keys($array_a_traiter);
			
			for($a = 0; $a < $size; $a++)
			{					
				echo  XMLToArray::genereEspace($niveau,$afficherNiveaux)."<span style='color:red;'>&lt;".$keys[$a];
					
				echo "&gt;</span>";
				if(is_array($array_a_traiter[$keys[$a]]) && !empty($array_a_traiter[$keys[$a]]))
				{		
					echo "<br />";
					XMLToArray::staticPrintInHTML($array_a_traiter[$keys[$a]],$niveau,$afficherNiveaux);
					echo XMLToArray::staticGenereEspace($niveau,$afficherNiveaux);
				}
				else
				{						
					echo "<span style='color:blue' >";
					if(empty($array_a_traiter[$keys[$a]]))
					{
						if($array_a_traiter[$keys[$a]]=== 0 || strcmp('0',$array_a_traiter[$keys[$a]]) ==0)
						{
							echo '0';
						}
						else
						{
							echo "<span style='font-size:14px;color:blue;'><i>vide</i></span>";
						}
					}
					else
					{
						echo $array_a_traiter[$keys[$a]];
					}
					echo "</span>";				
				}	
				
				echo "<span style='color:red;'>&lt;/".$keys[$a]."&gt;</span><br />";
			}				
		}
		else
		{
			//ce n'est pas censé arriver
			echo "ERROR, le tableau envoyé est vide.<br />";
		}		
	}
	
	/**
	* \brief Crée une indentation par la génération de caractères 'espace' html soit '&nbsp;' .
	* \param $niveau Le niveau actuel dans l'arborescence, utilisé récursivement pour gérer l'indentation.
	* \param $afficherNiveaux Défini si il faut afficher les niveaux du XML avec des lignes verticales. 
	* \returns La chaine de caractères contenant le bon nombre d'espace.
	*/
	private static function staticGenereEspace($niveau,$afficherNiveaux)
	{
		$chaine = "";
		for($a=0;$a<$niveau;$a++)
		{
			if($a != 0 && $afficherNiveaux)
			{
				$chaine .=  "|&nbsp;&nbsp;&nbsp;";
			}
			else
			{
				$chaine .=  "&nbsp;&nbsp;&nbsp;&nbsp;";
			}			
		}		
		return $chaine;
	}
	
	/**
	* \brief Crée une indentation par la génération de caractères 'espace' html soit '&nbsp;' .
	* \param $niveau Le niveau actuel dans l'arborescence, utilisé récursivement pour gérer l'indentation.
	* \param $afficherNiveaux Défini si il faut afficher les niveaux du XML avec des lignes verticales. 
	* \returns La chaine de caractères contenant le bon nombre d'espace.
	*/
	private function genereEspace($niveau,$afficherNiveaux)
	{
		$chaine = "";
		for($a=0;$a<$niveau;$a++)
		{
			if($a != 0 && $afficherNiveaux)
			{
				$chaine .=  "|&nbsp;&nbsp;&nbsp;";
			}
			else
			{
				$chaine .=  "&nbsp;&nbsp;&nbsp;&nbsp;";
			}			
		}		
		return $chaine;
	}
	
	/**
	* \brief Récupère sous forme de tableau toutes les balises du XML et leur contenu, quel que soit leur position dans l'arborescence
	* \param $array_a_traiter L'Array à traiter.
	* \param $array_contenu L'Array à renvoyé, utilisé récursivement par la méthode. 
	* \returns L'Array contenant toutes les balises du XML.
	*/
	public function recupererToutContenuDeArray($array_a_traiter,$array_contenu)
	{				
		if(is_array($array_a_traiter))
		{
			foreach($array_a_traiter as $element_a_traiter)
			{
				if(is_array($element_a_traiter["contenu"]))
				{
					$array_contenu = $this->recupererToutContenuDeArray($element_a_traiter["contenu"],$array_contenu);
				}
				
				$temp = array();
				$temp["nom"] = $element_a_traiter["nom"];
				$temp["valeur"] = $element_a_traiter["contenu"];
				
				$array_contenu[] = $temp;
			}				
		}
		return $array_contenu;
	}
	
	/**
	* \brief Affiche la tableau envoyé comme du code HTML représentant le XML .
	* \param $array_a_traiter Le tableau à afficher.
	* \param $niveau Le niveau actuel dans l'arborescence, utilisé récursivement pour gérer l'indentation.
	* \param $afficherNiveaux Défini si il faut afficher les niveaux du XML avec des lignes verticales. 
	* \sa genereEspace()
	*/
	private function printInHTML($array_a_traiter,$niveau,$afficherNiveaux)
	{
		//si un tableau est envoyé
		if(is_array($array_a_traiter))
		{			
			$niveau ++;
			foreach($array_a_traiter as $element_a_traiter)
			{		
				
				echo  $this->genereEspace($niveau,$afficherNiveaux)."<span style='color:".$this->couleurBalise.";'>&lt;".$element_a_traiter["nom"];
				
				foreach($element_a_traiter["attributs"] as $attribut)
				{
					echo " <span style='color:".$this->couleurAttribut.";'>".$attribut["nom"]."=\"<span style='color:".$this->couleurValeurAttribut.";' >".$attribut["valeur"]."</span>\"</span> ";
				}
				
				echo "&gt;</span>";
				if(is_array($element_a_traiter["contenu"]) && !empty($element_a_traiter["contenu"]))
				{		
					echo "<br />";
					$this->printInHTML($element_a_traiter["contenu"],$niveau,$afficherNiveaux);
					echo $this->genereEspace($niveau,$afficherNiveaux);
				}
				else
				{						
					echo "<span style='color:".$this->couleurDonnee."' >";
					if(empty($element_a_traiter["contenu"]))
					{
						if($element_a_traiter["contenu"] === 0 || strcmp('0',$element_a_traiter["contenu"]) ==0)
						{
							echo '0';
						}
						else
						{
							echo "<span style='font-size:14px;color:black;'><i>vide</i></span>";
						}
					}
					else
					{
						echo $element_a_traiter["contenu"];
					}
					echo "</span>";				
				}	
				
				echo "<span style='color:".$this->couleurBalise.";'>&lt;/".$element_a_traiter["nom"]."&gt;</span><br />";
			}				
		}
		else
		{
			//ce n'est pas censé arriver
			echo "ERROR, le tableau envoyé est vide.<br />";
		}		
	}

	public static function transformerArrayEnXml($array)
	{
		$xml = "";
	
		$array_contenu = array();
	
		$array_a_renvoyer = array();
	
		if(empty($array))
		{
			return "";
		}
		
		if( @array_key_exists("contenu", $array) )
		{
			if( is_array( $array["contenu"] ) )
			{
				$xml.= "<".$array["nom"];
				if( is_array( $array["attributs"] ) )
				{
					foreach($array["attributs"] as $attribut)
					{
						$xml .= " ".$attribut["nom"]."='".$attribut["valeur"]."' ";
					}
				}
				$xml .= ">".XMLToArray::transformerArrayEnXml($array["contenu"])."</".$array["nom"].">";
			}
			else
			{
				$xml.= "<".$array["nom"];
				if( is_array( $array["attributs"] ) )
				{
					foreach($array["attributs"] as $attribut)
					{
						$xml .= " ".$attribut["nom"]."='".$attribut["valeur"]."' ";
					}
				}
				$xml .= ">".$array["contenu"]."</".$array["nom"].">";
			}
		}
		else if(is_array($array))
		{
			
			foreach($array as $key => $element_a_traiter)
			{				
				//un array spécifique à notre objet
				if( @array_key_exists("contenu", $element_a_traiter) )
				{
					if( is_array( $element_a_traiter["contenu"] ) )
					{
						$xml .= "<".$element_a_traiter["nom"];
						if( is_array( $element_a_traiter["attributs"] ) )
						{							
							foreach($element_a_traiter["attributs"] as $attribut)
							{
								$xml .= " ".$attribut["nom"]."='".$attribut["valeur"]."' ";
							}
						}
						$xml .= ">".XMLToArray::transformerArrayEnXml($element_a_traiter["contenu"])."</".$element_a_traiter["nom"].">";
					}
					else
					{
						$xml.= "<".$element_a_traiter["nom"];
						if( is_array( $element_a_traiter["attributs"] ) )
						{						
							foreach($element_a_traiter["attributs"] as $attribut)
							{
								$xml .= " ".$attribut["nom"]."='".$attribut["valeur"]."' ";
							}
						}
						$xml .= ">".$element_a_traiter["contenu"]."</".$element_a_traiter["nom"].">";
					}
				}
				else
				{
					if(!empty($element_a_traiter) && !is_array($element_a_traiter))
					{
						$xml.= "<$key>$element_a_traiter</$key>";
					}
					
				}
			}
		}
		else
		{			
			return $array;
		}
		return $xml;
	}
	
	/**
	 * \brief Recherche le contenu des balises voulues dans l'objet courant.
	 * \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	 * \param $nom Nom des balises recherchées.
	 * \param $numero Spécifie l'occurence à renvoyer, si vide, tous les contenus trouvés sont renvoyés.
	 * \returns Un Array contenant les résultat trouvés.
	 */
	public function rechercherContenuBalisesDansObjet($nom, $numero = -1)
	{
		$array_contenu = array();
	
		$array_a_renvoyer = array();
	
		if(empty($this->array))
		{
			$this->array = $this->transformeEnArray();
		}
	
		if(is_array($this->array))
		{
			foreach($this->array as $element_a_traiter)
			{
				if( array_key_exists("contenu", $element_a_traiter) )
				{
					if( is_array( $element_a_traiter["contenu"] ) )
					{
						$array_a_renvoyer = $this->rechercherContenuBalises($element_a_traiter["contenu"],$array_a_renvoyer,$nom);
					}
					else
					{
						if(strcmp($element_a_traiter["nom"],$nom) == 0)
						{
							$array_a_renvoyer[] = $element_a_traiter["contenu"];
						}
					}
				}
			}
		}
		
		
		if($numero-1 < 0)
		{
			return $array_a_renvoyer;			
		}
		else if(array_key_exists($numero-1, $array_a_renvoyer))
		{
			return $array_a_renvoyer[$numero-1];
		}
		else
		{
			return array();			
		}
	}
	
	/**
	 * \brief Recherche le contenu texte des balises voulues dans l'Array envoyé. Si une balise contient d'autre balise, elle est considérée comme sans contenu, même si toutes les balises qu'elle contient seront utilisées.
	 * \param $array_a_traiter Array dans lequel rechercher les balises.
	 * \param $array_contenu Array utilisé récursivement par la fonction pour contenir les résultats trouvés.
	 * \param $nom Nom des balises recherchées.
	 * \returns Un Array contenant les résultat trouvés.
	 */
	public function rechercherContenuBalises($array_a_traiter,$array_contenu,$nom)
	{
		if(is_array($array_a_traiter))
		{
			foreach($array_a_traiter as $element_a_traiter)
			{
				if(is_array($element_a_traiter["contenu"]))
				{
					$array_contenu = $this->rechercherContenuBalises($element_a_traiter["contenu"],$array_contenu,$nom);
				}
				else if(strcmp($element_a_traiter["nom"],$nom) == 0 && !empty($element_a_traiter["contenu"]))
				{						
					$array_contenu[] = $element_a_traiter["contenu"];
				}
			}
		}
		return $array_contenu;
	}
	
	public function nouvelXMLToArrayDepuisBalise($nom, $numero = -1)
	{
		$temp = $this->rechercherBalisesDansObjet($nom,$numero);
		$xml = XMLToArray::transformerArrayEnXml($temp);
		$temp = new XMLToArray($xml);
		return $temp;
	}
}

//TEST nouvelXMLToArrayDepuisBalise()
/*
$objet = new XMLToArray("<carmed><eCarmedNumber>000000647775</eCarmedNumber><versionNbr>1</versionNbr><beneficiary><ssin>56112545746</ssin><lastName>Bellaouar</lastName><firstName>Ahmed</firstName><gender>M</gender><birthDate>1956-11-25</birthDate></beneficiary><startDate>2013-04-01</startDate><endDate>2013-06-30</endDate><creationDate>2013-05-17T10:05:29.000</creationDate><lastModificationDate>2013-05-17T10:05:29.000</lastModificationDate><refundCode>31</refundCode><affiliedMutualityInd>N</affiliedMutualityInd><beneficiaryStatus>I</beneficiaryStatus><justification lang='fr' >Reg BIS - illégal - Revenus < RIS - non assuré</justification><justification lang='nl' >BISreg - illegaal - Inkomen < leefloon - niet verzekerd</justification><podmi_sppis_Hospitalization_ZIV_AMI_Part>1.00</podmi_sppis_Hospitalization_ZIV_AMI_Part><podmi_sppis_AmbulatoryCare_ZIV_AMI_Part>1.00</podmi_sppis_AmbulatoryCare_ZIV_AMI_Part><podmi_sppis_Other_ZIV_AMI_Part>1.00</podmi_sppis_Other_ZIV_AMI_Part><podmi_sppis_Hospitalization_PatientPart>1.00</podmi_sppis_Hospitalization_PatientPart><podmi_sppis_AmbulatoryCare_PatientPart>1.00</podmi_sppis_AmbulatoryCare_PatientPart><podmi_sppis_Other_PatientPart>1.00</podmi_sppis_Other_PatientPart></carmed>");
$array = $objet->nouvelXMLToArrayDepuisBalise('justification');

Tools::dump($array);

$array->afficherEnHtml();
*/

?>