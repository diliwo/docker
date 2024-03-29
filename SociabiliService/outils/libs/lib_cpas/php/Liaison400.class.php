<?php

	class Liaison400
	{
		private $dsn ="DRIVER={iSeries Access ODBC Driver};SYSTEM=CPAS400;DBQ=CPAS400";
		private $user = "envpc";
		private $passwd = "envpc";
		private $connexion;
		
		public function __construct()
		{
			$this->connexion = odbc_connect($this->dsn, $this->user, $this->passwd);
			//on vérifie que la connexion a bien fonctionné
			if($this->connexion == false)
			{
				//en cas d'erreur
				exit("Impossible d'ouvrir une connexion au 400");
			}
		}
		
		public function Info()
		{
			echo "<pre>";
			var_dump($this);
			echo "</pre>";
		}
		
		public function recuperer_libelle_par_numero_de_decision($numero_de_decision)
		{
			$sql = "select libel from sscf.fplibssc where numdec = ".$numero_de_decision." and (nfic = 2 or nfic = 4)";
			$resultat = $this->envoyer_requete($sql);
			
			$texte = "";
			
			foreach($resultat["resultat"] as $ligne)
			{
				$texte .= " ".$ligne["LIBEL"];
			}
			return $texte;

		}
		
		public function recuperer_tableau_requete($requete)
		{
			$resultat = $this->envoyer_requete($requete);
			
			$resultat["tableau"] = "<table style='border-collapse:collapse;'><tr>";
			
			if(count($resultat["resultat"]) > 0)
			{
				foreach($resultat["resultat"][0] as $key=>$valeur)
				{
					$resultat["tableau"] .= "<th style='padding:3px;border:1px black solid;'>".$key."</th>";
				}
				
				$resultat["tableau"] .= "</tr>";
				
				foreach($resultat["resultat"] as $row)
				{
					$resultat["tableau"] .= "<tr>";
					foreach($row as $valeur)
					{
						$resultat["tableau"] .= "<td style='padding:3px;border:1px black solid;'>".$valeur."</td>";
					}
					$resultat["tableau"] .= "</tr>";
				}
			}
			$resultat["tableau"] .= "</tr></table>";
			
			return $resultat;
		}
		
		public function recuperer_decision_par_numero_de_decision($numero_de_decision)
		{
			//DECISI
			$requete = "SELECT INOM,DANT,REGIND AS REGISTRE_NATIONAL,NUMDEC, DDTYPA AS ID_TYPE, DDSTYP AS ID_SOUS_TYPE, DNATDE AS ID_VERBE, DEOCTR AS DATE_DU, DFOCTR AS DATE_AU, DIOCTR  AS DATE_SEANCE
							FROM sscf.fpdecisi 
							JOIN sscf.fpanten ON sscf.fpanten.ANTEN = sscf.fpdecisi.DANT
							JOIN sscf.pnindiv ON sscf.pnindiv.INORD = sscf.fpdecisi.DNORD
							WHERE NUMDEC = ".$numero_de_decision;
					
			$resultat = $this->envoyer_requete($requete);
			
			if(count($resultat["resultat"])>0)
			{
				return $resultat;
			}
			
			//DECIDV
			$requete = "SELECT INOM,DANT,REGIND AS REGISTRE_NATIONAL,NUMDEC, DDTYPA AS ID_TYPE, DDSTYP AS ID_SOUS_TYPE, DNATDE AS ID_VERBE, DEOCTR AS DATE_DU, DFOCTR AS DATE_AU, DIOCTR  AS DATE_SEANCE
							FROM sscf.fpdecidv 
							JOIN sscf.fpanten ON sscf.fpanten.ANTEN = sscf.fpdecidv.DANT
							JOIN sscf.pnindiv ON sscf.pnindiv.INORD = sscf.fpdecidv.DNORD
						WHERE NUMDEC = ".$numero_de_decision;					
					
			$resultat = $this->envoyer_requete($requete);
			
			if(count($resultat["resultat"])>0)
			{
				return $resultat;
			}
			
			//DECIDS
			$requete = "SELECT INOM,DANT,REGIND AS REGISTRE_NATIONAL,NUMDEC, DTYPE AS ID_TYPE, DSTYPE AS ID_SOUS_TYPE, DNATDE AS ID_VERBE, DEOCTR AS DATE_DU, DFOCTR AS DATE_AU, DIOCTR  AS DATE_SEANCE
							FROM sscf.fpdecids 
							JOIN sscf.fpanten ON sscf.fpanten.ANTEN = sscf.fpdecids.DANT
							JOIN sscf.pnindiv ON sscf.pnindiv.INORD = sscf.fpdecids.DNORD
						WHERE NUMDEC = ".$numero_de_decision;
					
			$resultat = $this->envoyer_requete($requete);
			
			if(count($resultat["resultat"])>0)
			{
				return $resultat;
			}	
			
			$resultat["message"] = "Aucune décision trouvée avec ce numéro de décision dans le 400.";
			return $resultat;
		}
		
		public function envoyer_requete($requete)
		{
			$retour = array();			
			$rows = array();
			
			$retour["erreur"] = false;
			$retour["message"] = "";
			
			$resultat_de_la_requete = odbc_exec($this->connexion, $requete);
		
			if($resultat_de_la_requete == false)
			{
				//en cas d'erreur
				$retour["erreur"] = true;
				$retour["message"] = "Erreur de la requete dans le 400 : ".$requete."<br />";				
			}
			
			$retour["resultat"] = array();
			
			while($row = odbc_fetch_array($resultat_de_la_requete))
			{
				$retour["resultat"][] = $row;
			}

			return $retour;
		}
	}

?>