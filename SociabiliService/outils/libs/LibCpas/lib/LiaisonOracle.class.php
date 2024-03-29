<?php
/**
*	\file LiaisonOracle.class.php
*	\brief Cette classe permet de se connecter et d'envoyer des requetes sur les DB Oracle.
*	\details Cette classe permet de centraliser les variables de connexion et de faire abstraction de la librairie utilisée pour la connection.
*	\date Mars 2013
*	\author Thomas Favay
*	\version 1.0
*/

/**
*	\class LiaisonOracle
*	\brief Cette classe permet de se connecter et d'envoyer des requetes sur les DB Oracle.
*	\details Cette classe permet de centraliser les variables de connexion et de faire abstraction de la librairie utilisée pour la connection (ici OCI).
*	\date Mars 2013
*	\version 1.0
*	\author Thomas Favay
*/
	class LiaisonOracle
	{
		/**
		* \brief Cette variable contient le user à utiliser pour la connection. Est chargée dans le constructeur.
		*/
		private $user		=	'';
		
		/**
		* \brief Cette variable contient le password à utiliser pour la connection. Est chargée dans le constructeur.
		*/
		private $password	=	'';
		
		/**
		* \brief Cette variable contient le nom du domaine à utiliser pour la connection. Est chargée dans le constructeur.
		*/
		private $tns		=	'';
		
		/**
		* \brief Cette variable défini le charset à utiliser pour la connection. Est chargée dans le constructeur.
		*/
		private $charset	=	'';
		
		/**
		* \brief Cette variable contient la connexion active. Est chargée dans le constructeur.
		*/
		private $connexion;	
		
		/**
	*
	* \param $environnement L'environnement désiré : \li prod ou production
	*                                                                       \li test
	*                                                                       \li dev
	* \brief Constructeur de la classe LiaisonOracle.
	* \return Une connexion active sur une DB Oracle.
	*/
		public function __construct($environnement = "prod")
		{
			if(strcmp($environnement,"prod") == 0 || strcmp($environnement,"production") == 0)
			{
				$this->user			=	'CPASPRODUCTION';
				$this->password	=	'XYU!z1125$485';
				$this->tns				=	'CPASPROD.world';
			}
			else if(strcmp($environnement,"test") == 0)
			{
				$this->user			=	'CPASSSCTEST';
				$this->password	=	'123456789';
				$this->tns				=	'CPAS.world';
			}
			else if(strcmp($environnement,"dev") == 0)
			{
				$this->user			=	'CPASSOCIAL';
				$this->password	=	'987654321';
				$this->tns				=	'CPAS.world';
			}
			else if(strcmp($environnement,"devIgor") == 0)
			{
				$this->user			=	'CPASDEV';
				$this->password	=	'123456789';
				$this->tns				=	'CPAS.world';
			}		
			else if(strcmp($environnement,"cpasupdate2") == 0)
			{
				$this->user			=	'CPASUPDATE2';
				$this->password	=	'123456789';
				$this->tns				=	'CPAS.world';
			}		
			
			$this->connexion = oci_connect($this->user, $this->password, $this->tns);
			
			//on vérifie que la connexion a bien fonctionné
			if($this->connexion == false)
			{
				//en cas d'erreur
				exit("Impossible d'ouvrir une connexion a Oracle");
			}
		}
		
		public function close()
		{
			oci_close($this->connexion);
		}
		
		/**
		*	\brief Permet de faire un dump de l'objet en html
		*/
		public function Info()
		{
			echo "<pre>";
			var_dump($this);
			echo "</pre>";
		}
		
		/**
		* \brief Permet de récupérer un tableau html du résultat de la requete.
		* \param $requete La requete SQL
		* \param $mode Le mode OCI de la requete, par défaut 5 = OCI_ASSOC + OCI_RETURN_NULLS
		* \return Un tableau contenant les index : 
		* \li ["tableau"] = le code html du tableau représentant les résultats.
		* \li ["resultat"] = un array contenant tous les records renvoyées.
		* \li ["erreur"] = Booléen signalant si une erreur a été rencontrée.
		* \li ["message"] = Un éventuel message, par exemple pour décrire l'erreur rencontrée.
		*/
		public function recuperer_tableau_requete($requete, $mode=5)
		{
			$resultat = $this->envoyer_requete($requete, $mode);
			$resultat["tableau"] = "<table  style='border-collapse:collapse;'><tr>";
			
			if(count($resultat["resultat"]) > 0)
			{				
				foreach($resultat["resultat"][0] as $key=>$valeur)
				{
					$resultat["tableau"] .= "<th style='padding:3px;border:1px black solid;'>".$key."</th>";
				}
					
				$resultat["tableau"] .= "</tr>";
				
				foreach($resultat["resultat"] as $record)
				{
					$resultat["tableau"] .= "<tr>";
					foreach($record as $valeur)
					{
						$resultat["tableau"] .= "<td style='padding:3px;border:1px black solid;'>".$valeur."</td>";
					}
					$resultat["tableau"] .= "</tr>";
				}	
			}
			$resultat["tableau"] .= "</tr></table>";
			return $resultat;
		}
		
		/**
		* \brief Permet de modifier un champ de la table demande en logguant cette opération avec l'ancienne valeur du champ, utilisé pour la correction des demandes en fonction des données du 400.
		* \param $nom_champ Le nom du champ à modifier.
		* \param $valeur La nouvelle valeur pour le champ.
		* \param $id_demande L'id de la demande à modifier.
		* \param $id_utilisateur L'id de l'utilisateur à l'origine de la modification.
		*/
		public function modifier_champ_demande_avec_log($nom_champ,$valeur,$id_demande,$id_utilisateur)
		{
			//recup ancienne valeur
			$requete = "SELECT ".$nom_champ." FROM  SSC_DEMANDE WHERE ID_DEMANDE = ".$id_demande;
			$resultat_oracle = $this->envoyer_requete($requete);
			if($resultat_oracle["erreur"])
			{
				echo $resultat_oracle["message"];
				die();
			}
			
			$ancienne_valeur = $resultat_oracle["resultat"][0][$nom_champ];
			
			$requete = "UPDATE SSC_DEMANDE SET ".$nom_champ." = ".$valeur." WHERE ID_DEMANDE = ".$id_demande;
			$resultat_oracle = $this->envoyer_requete($requete);
			if($resultat_oracle["erreur"])
			{
				echo $resultat_oracle["message"];
				die();
			}
			
			$requete = "INSERT INTO SSC_LOGS (ACTION,ANCIENNE_VALEUR,NOUVELLE_VALEUR,ID_CIBLE,ID_UTILISATEUR,NOMCHAMPS,NOMTABLE,DATE_LOGS) VALUES ('MODIFIER','".$ancienne_valeur."','".$valeur."',".$id_demande.",".$id_utilisateur.",'".$nom_champ."','SSC_DEMANDE',TO_DATE('".date("d/m/Y h:m:s")."','DD/MM/YYYY HH:MI:SS'))";
			$resultat_oracle = $this->envoyer_requete($requete, OCI_ASSOC + OCI_RETURN_NULLS);	
			if($resultat_oracle["erreur"])
			{
				echo $resultat_oracle["message"];
				die();
			}
		}
		
		
		/**
		* \brief Permet de récupérer le résultat de la requete.
		* \param $requete La requete SQL
		* \param $mode Le mode OCI de la requete, par défaut 5 = OCI_ASSOC + OCI_RETURN_NULLS
		* \return Un tableau contenant les index : 
		* \li ["resultat"] = un array contenant tous les records renvoyées.
		* \li ["erreur"] = Booléen signalant si une erreur a été rencontrée.
		* \li ["message"] = Un éventuel message, par exemple pour décrire l'erreur rencontrée.
		*/
		public function envoyer_requete($requete, $mode=5)
		{
			$retour = array();
		
			$retour["erreur"] = false;
			$retour["message"] = "";
						
			$requete_active = oci_parse($this->connexion, $requete);
			
			if(!oci_execute($requete_active))
			{			
				//en cas d'erreur
				$retour["erreur"] = true;
				$retour["message"] = "Erreur de la requete dans le 400 : ".$requete."<br />";				
			}			
			
			$retour["resultat"] = array();
			
			//on ne chope le retour de la requete que si c'est une requete select.
			if(strpos($requete,"SELECT") !== false || strpos($requete,"select") !== false)
			{
				while($row = oci_fetch_array($requete_active, $mode))
				{
					$retour["resultat"][] = $row;
				}
			}
			
			oci_free_statement($requete_active);  
			return $retour;
		}
		
		/**
		* \brief Permet de récupérer une demande dans la DB Oracle sur base de son numéro de décision 400. Les dates date_du, date_au et date de séance sont castée au format YYMMDD pour faciliter les comparaisons avec le 400.
		* \param $numero_de_decision Le numdec de la décision dans le 400.
		* \return Un tableau contenant les index : 
		* \li ["resultat"] = un array contenant tous les records renvoyées.
		* \li ["erreur"] = Booléen signalant si une erreur a été rencontrée.
		* \li ["message"] = Un éventuel message, par exemple pour décrire l'erreur rencontrée.
		*/
		public function recuperer_decision_par_numero_de_decision($numero_de_decision)
		{
			$sql = "SELECT 
            ID_DEMANDE,DATE_DEMANDE,REGISTRE_NATIONAL,SSC_INDIVIDUS.NOM,SSC_INDIVIDUS.PRENOM,CAST(SSC_DEMANDE.PROPOSITION_MANAGER AS VARCHAR(2048)) AS PROPOSITION_MANAGER,CAST(SSC_DEMANDE.RESUME_DEMANDE AS VARCHAR(2048)) AS RESUME_DEMANDE,DATE_SEANCE,SSC_LOCALISATION.NUMERO_LOCALISATION AS DANT, SSC_DEMANDE.DATE_DU, SSC_DEMANDE.DATE_AU, SSC_DEMANDE.ID_TYPE_MANAGER AS ID_TYPE, SSC_DEMANDE.ID_SOUS_TYPE_MANAGER AS ID_SOUS_TYPE, SSC_DEMANDE.ID_VERBE_MANAGER AS ID_VERBE
            FROM SSC_DEMANDE
            LEFT OUTER JOIN SSC_INDIVIDUS ON SSC_DEMANDE.ID_INDIVIDUS = SSC_INDIVIDUS.ID_INDIVIDUS
            LEFT OUTER JOIN SSC_VERBES ON SSC_VERBES.MINI11 = SSC_DEMANDE.ID_VERBE_MANAGER
            LEFT OUTER JOIN SSC_UTILISATEURS ON SSC_UTILISATEURS.ID_UTILISATEUR = SSC_INDIVIDUS.ID_UTILISATEUR
            LEFT OUTER JOIN SSC_LOCALISATION ON SSC_LOCALISATION.ID_LOCALISATION = SSC_INDIVIDUS.ID_LOCALISATION
            WHERE 
            SSC_NUMDEC = ".$numero_de_decision;
			
			$resultat = $this->envoyer_requete($sql);
			
			for($i=0;$i<count($resultat["resultat"]);$i++)
			{
				if(!empty($resultat["resultat"][$i]["DATE_DU"]))
				{
					$resultat["resultat"][$i]["DATE_DU"] = substr($resultat["resultat"][$i]["DATE_DU"],6,2).substr($resultat["resultat"][$i]["DATE_DU"],3,2).substr($resultat["resultat"][$i]["DATE_DU"],0,2);
				}
				else
				{
					$resultat["resultat"][$i]["DATE_DU"] =0;
				}
				
				if(!empty($resultat["resultat"][$i]["DATE_AU"]))
				{
					$resultat["resultat"][$i]["DATE_AU"] = substr($resultat["resultat"][$i]["DATE_AU"],6,2).substr($resultat["resultat"][$i]["DATE_AU"],3,2).substr($resultat["resultat"][$i]["DATE_AU"],0,2);
				}
				else
				{
					$resultat["resultat"][$i]["DATE_AU"] =0;
				}
				
				$resultat["resultat"][$i]["DATE_SEANCE"] = substr($resultat["resultat"][$i]["DATE_SEANCE"],6,2).substr($resultat["resultat"][$i]["DATE_SEANCE"],3,2).substr($resultat["resultat"][$i]["DATE_SEANCE"],0,2);
			}
			return $resultat;
		}
		
	}

?>