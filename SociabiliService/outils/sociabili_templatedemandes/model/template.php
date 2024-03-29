<?php

class Template
{
	private $id_template;
	private $libelle;
	private $template;
	private $id_type;
	private $id_sous_type;
	private $id_verbe;
	private $id_code_langue;
	
	public function __construct($id_template="", $libelle="", $template="", $id_type="0", $id_sous_type="0", $id_verbe="0", $id_code_langue="0", $DBM="")
	{
		$this->id_template=$id_template;
		$this->libelle=$libelle;
		$this->template=str_replace("\n","\r\n",$template);
		$this->id_type=$id_type;
		$this->id_sous_type=$id_sous_type;
		$this->id_verbe=$id_verbe;		
		$this->id_code_langue=$id_code_langue;		
	}
	
	public function loadData($DBM)
	{		
		if(!empty($this->id_template))
		{
			$requete="SELECT id_template, RTRIM(libelle) AS libelle, template, id_type, id_sous_type, id_verbe, id_code_langue
							FROM ssc_templates 
							WHERE id_template = ".$this->id_template;
							
			$connexionActive = oci_parse($DBM, $requete);
			
			if (oci_execute($connexionActive))
			{
				$nbrows = oci_fetch_all($connexionActive, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

				foreach($res as $record){

				
					$liste_template[]= new Template($record["ID_TEMPLATE"],$record["LIBELLE"],$record["TEMPLATE"],$record["ID_TYPE"],$record["ID_SOUS_TYPE"],$record["ID_VERBE"],$record["ID_CODE_LANGUE"],$DBM);		
					
					$this->libelle = $record["LIBELLE"];
					$this->template = $record["TEMPLATE"];
					$this->id_type = $record["ID_TYPE"];
					$this->id_sous_type = $record["ID_SOUS_TYPE"];
					$this->id_verbe = $record["ID_VERBE"];
					$this->id_code_langue = $record["ID_CODE_LANGUE"];
				}
			}
			else
			{
				$e = oci_error($connexionActive);					
					?>
					<p class='error'><?php echo "La requete1 : '".$requete."' a genere une erreur : ' ".$e['message']."'"; ?></p>
				<?php
				
				include("view/footer.php");
				exit();
			}	
		}		
	}
	public static function createFromJSON_mod($JSONString)
	{
		$object = json_decode($JSONString);
		$templateTemp = new Template($object->id_template,$object->libelle,$object->template,$object->id_type,$object->id_sous_type,$object->id_verbe,$object->id_code_langue);		
		return $templateTemp;
	}
	
	public static function recupFromJSON_add($JSONString)
	{
		$object = json_decode($JSONString);

		$templateTemp = new Template(0,$object->libelle,$object->template,$object->id_type,$object->id_sous_type,$object->id_verbe,$object->id_code_langue);
		return $templateTemp;
	}
	
	public static function createFromJSON($JSONString)
	{
		$object = json_decode($JSONString);
		$templateTemp = new Template($object->id_template);		
		return $templateTemp;
	}
	
	public function ToJSON()
	{	
		$JSONString = "{";
		$compte = 0;
		foreach(get_object_vars($this) as $key=>$value)
		{			
			if($compte > 0)
			{
				$JSONString.= ",";
			}
			
			//on échappe les caractères posant problème à JSON.parse coté javascript.
			$JSONString.= "\"".$key."\" : \"".str_replace("\"","\\\"",str_replace("\t","    ",str_replace("\r","<br>",str_replace("\n","<br>",str_replace("\r\n","<br>",str_replace("\\","\\\\",$value))))))."\"";
			
			$compte++;					
		}
		$JSONString.= "}";
		return $JSONString;
	}
	
	public static function getAllTemplate($DBM)
	{
		$liste_template = array();
		
		$requete_all_template="SELECT id_template, RTRIM(libelle) AS libelle, template, id_type, id_sous_type, id_verbe, id_code_langue
								FROM ssc_templates 
								ORDER BY id_type , id_sous_type, id_verbe";
								
		
		$connexionActive = oci_parse($DBM, $requete_all_template);
			
			if (oci_execute($connexionActive))
			{
				$nbrows = oci_fetch_all($connexionActive, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

				foreach($res as $record){
				
					$liste_template[]= new Template($record["ID_TEMPLATE"],$record["LIBELLE"],$record["TEMPLATE"],$record["ID_TYPE"],$record["ID_SOUS_TYPE"],$record["ID_VERBE"],$record["ID_CODE_LANGUE"],$DBM);					
				
				}
				return $liste_template;
			}
			else
			{
				$e = oci_error($connexionActive);					
					?>
					<p class='error'><?php echo "La requete2 : '".$requete_all_template."' a genere une erreur : ' ".$e['message']."'"; ?></p>
				<?php
				
				include("view/footer.php");
				exit();
			}			
		
	}
	
	public  function addTemplate($DBM)
	{
		$requetegetId = "select MAX(ID_TEMPLATE) as NEWID from ssc_templates";
		$connexionActive = oci_parse($DBM, $requetegetId);
		$nextID = 0;
		if (oci_execute($connexionActive))
		{
			$row = oci_fetch_array($connexionActive);
			$nextID = $row["NEWID"]+1;
		}
		else
		{
			$e = oci_error($connexionActive);					
			?>
			<p class='error'><?php echo "La requete : '".$requtete_add_template."' a genere une erreur : ' ".$e['message']."'"; ?></p>
			<?php
		
			include("view/footer.php");
			exit();
		}
		
		$requtete_add_template=
								"INSERT INTO ssc_templates 
									(id_template, libelle, template, id_type, id_sous_type, id_verbe, id_code_langue)
								values (
									'".DatabaseManager::cleanSQLStr($nextID)."',
									:libelle,
									:template,
									".DatabaseManager::cleanSQLStr($this->id_type).",
									".DatabaseManager::cleanSQLStr($this->id_sous_type).",
									".DatabaseManager::cleanSQLStr($this->id_verbe).",
									".DatabaseManager::cleanSQLStr($this->id_code_langue)."
								)";
		
		echo "<br>".$requtete_add_template."<br>";
		
		$connexionActive = oci_parse($DBM, $requtete_add_template);
		$template = DatabaseManager::cleanSQLStr($this->template);
		$libelle = DatabaseManager::cleanSQLStr($this->libelle);

		oci_bind_by_name($connexionActive, ":template", $template, -1, SQLT_CHR);
		oci_bind_by_name($connexionActive, ":libelle", $libelle, -1, SQLT_CHR);
			
		if (oci_execute($connexionActive))
		{
		
		}
		else
		{
			$e = oci_error($connexionActive);					
			?>
			<p class='error'><?php echo "La requete : '".$requtete_add_template."' a genere une erreur : ' ".$e['message']."'"; ?></p>
			<?php
		
			include("view/footer.php");
			exit();
		}
	}
	public  function suppTemplate($DBM)
	{
		$requtete_supp_template="DELETE FROM ssc_templates
								 WHERE id_template = ".DatabaseManager::cleanSQLStr($this->id_template); 
		
		$connexionActive = oci_parse($DBM, $requtete_supp_template);
			
		if (oci_execute($connexionActive))
		{
			
		}
		else
		{
			$e = oci_error($connexionActive);					
			?>
			<p class='error'><?php echo "La requete : '".$requtete_supp_template."' a genere une erreur : ' ".$e['message']."'"; ?></p>
			<?php
		
			include("view/footer.php");
			exit();
		}
	}
	
	public function modTemplate($DBM,$id_template,$libelle,$template,$id_type,$id_sous_type,$id_verbe,$id_code_langue)
	{
		$requete_mod_temmplate = "UPDATE ssc_templates 
								  set libelle=:libelle , 
								  template= :template , 
								  id_type=".DatabaseManager::cleanSQLStr($id_type)." , 
								  id_sous_type=".DatabaseManager::cleanSQLStr($id_sous_type)." , 
								  id_verbe = ".DatabaseManager::cleanSQLStr($id_verbe).", 
								  id_code_langue = ".DatabaseManager::cleanSQLStr($id_code_langue)." 
								  where id_template=".$id_template;
								  
		$connexionActive = oci_parse($DBM, $requete_mod_temmplate);

		$template = DatabaseManager::cleanSQLStr($template);
		$libelle = DatabaseManager::cleanSQLStr($libelle);

		oci_bind_by_name($connexionActive, ":template", $template, -1, SQLT_CHR);
		oci_bind_by_name($connexionActive, ":libelle", $libelle, -1, SQLT_CHR);

			if (oci_execute($connexionActive))
			{
				
			}
			else
			{
				$e = oci_error($connexionActive);					
				?>
				<p class='error'><?php echo "La requete : '".$requete_mod_temmplate."' a genere une erreur : ' ".$e['message']."'"; ?></p>
				<?php
			
				include("view/footer.php");
				exit();
			}
	}
	
	public static function Lister($DBM,$ta,$sta,$v,$libelle,$id_code_langue)
	{		
		$liste = array();
		$requete_liste= "SELECT id_template, RTRIM(libelle) AS libelle, template, id_type, id_sous_type, id_verbe, id_code_langue
								FROM ssc_templates";
		
		if($ta == null && $sta == null && $v == null && $libelle == null && $id_code_langue == null)
		{
			//rien à faire
		}
		else
		{
			$requete_liste .= " WHERE ";
			$compte = 0;
			if($ta != null)
			{
				$requete_liste .= " id_type = ".DatabaseManager::cleanSQLStr($ta)." ";
				$compte ++;
			}
			
			if($sta != null)
			{
				if($compte > 0){$requete_liste .= " AND ";}
				$requete_liste .= " id_sous_type = ".DatabaseManager::cleanSQLStr($sta)." ";
				$compte ++;
			}
			
			if($v != null)
			{
				if($compte > 0){$requete_liste .= " AND ";}
				$requete_liste .= " id_verbe = ".DatabaseManager::cleanSQLStr($v)." ";
				$compte ++;
			}

			if($id_code_langue != null)
			{
				if($compte > 0){$requete_liste .= " AND ";}
				$requete_liste .= " id_code_langue = ".DatabaseManager::cleanSQLStr($id_code_langue)." ";
				$compte ++;
			}
			
			if($libelle != null)
			{
				if($compte > 0){$requete_liste .= " AND ";}
				$requete_liste .= " libelle like '%".DatabaseManager::cleanSQLStr($libelle)."%' ";
				$compte ++;
			}
		}								
								
		$requete_liste .= "ORDER BY id_type , id_sous_type, id_verbe";
								
								
		$connexionActive = oci_parse($DBM,$requete_liste);
			
		if (oci_execute($connexionActive))
		{
			$nbrows = oci_fetch_all($connexionActive, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

				foreach($res as $record){

				
					$liste[]= new Template($record["ID_TEMPLATE"],$record["LIBELLE"],$record["TEMPLATE"],$record["ID_TYPE"],$record["ID_SOUS_TYPE"],$record["ID_VERBE"],$record["ID_CODE_LANGUE"],$DBM);
					
				}
			return $liste;
		}
		else
		{
			$e = oci_error($connexionActive);					
			?>
			<p class='error'><?php echo "La requete 4: '".$requete_liste."' a genere une erreur : ' ".$e['message']."'"; ?></p>
			<?php
		
			include("view/footer.php");
			exit();
		}
		
	}	
	
	public function __get($var)
	{
		if(isset($this->$var))
		{
			return $this->$var;
		}
		else
		{
			
		}
	}	
	
	public function __toString()
	{
		$string =  "<pre>";
		$string.= print_r($this,true);
		$string.= "</pre>";
		return $string;
	}
}

?>