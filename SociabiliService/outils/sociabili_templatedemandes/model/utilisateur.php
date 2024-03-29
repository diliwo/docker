<?php
	
	class Utilisateur
	{
		
		private $samaccountname;
		private $id_utilisateur;
		
		public function __construct($samaccountname)
		{
		
			$this->samaccountname=$samaccountname;
		}
		
		public function droit_valide($DBM)
		{
		
			$requete_droit="select count(*) as COMPTE
						FROM ssc_droit_template d_t
						JOIN ssc_utilisateurs u on d_t.id_utilisateur = u.id_utilisateur 
						WHERE u.samaccountname = '".$this->samaccountname."'
						AND softdelete is null";
			
			//echo $requete_droit;
			
			$connexionActive = oci_parse($DBM, $requete_droit);
			
			if (oci_execute($connexionActive))
			{
				$row = oci_fetch_array($connexionActive); // sert a recuperer la valeur de la requete_droit 
				if($row["COMPTE"]==1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				$e = oci_error($connexionActive);
					
					?>
					<p class='error'><?php echo "La requete : '".$requete_droit."' a genere une erreur : ' ".$e['message']."'"; ?></p>
				<?php
				
				include("view/footer.php");
				exit();
			} 
		}
		
		public function connect()
		{
			$_SESSION["TEMPLATE_LOGGED_IN"] = true;
		}
		
		public function disconnect()
		{
			$_SESSION["TEMPLATE_LOGGED_IN"] = false;
		}
	}

?>