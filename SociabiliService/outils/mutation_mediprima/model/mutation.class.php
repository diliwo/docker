<?php 

class Mutation
{
    public $donnees;
    
    public function __construct($row = null)
    {
        $donnees = array();
        
        if(is_array($row))
        {
            foreach($row as $key=>$value)
            {
                $this->donnees[$key] = $value;
            }
        }
        else if(is_int((int)$row) && ((int)$row) != 0 && ((int)$row) != "")
        {
            $this->get_date_form_oracle_by_id($row);
        }
    }
    
    public static function arrayToXML($array = array())
    {
        $string = "";
        foreach($array as $key=>$value)
        {
            $string .= "<".$key.">";
            if(is_array($value))
            {
                $string .= Mutation::arrayToXML($value);
            }
            else
            {
                $string .= $value;
            }
            $string .= "</".$key.">";
        }
        return $string;
    }
    
    public function stopCarmed()
	{
        $debug = "";

		if(!defined("WSDL"))
        {define("WSDL", "wsdl/eCarmedPSWC.wsdl");}
    
        if(!defined("USER"))
        {define("USER", "E0212358536");}
    
        if(!defined("PASSWORD"))
        {define("PASSWORD", "p4350415330B4474DD5238F01EBE4");}
    
        if(!defined("CBENUMBER"))
        {define("CBENUMBER", "0212358536");}
    
        if(!defined("LEGALCONTEXT"))
        {define("LEGALCONTEXT", "manage eCarmed");}

		$soapClient = new SoapClient(WSDL, array('login' =>USER, 'password' => PASSWORD, 'trace' => true, 'connection_timeout'=>10));
		$request = array();

        $num_carte= "";
        $nbr_lettre = strlen($this->donnees["NUM_CARTE"]);
        $a_ajouter = 12- $nbr_lettre;
        for($a_ajouter; $a_ajouter>0; $a_ajouter--)
        {
            $num_carte .= "0";
        }
        $num_carte .= $this->donnees["NUM_CARTE"];
        
        /**recup carte**/
        try
		{
            $request =
				array (
					"informationCustomer" =>
						array (
							"customerIdentification" =>
								array (
									"cbeNumber" => CBENUMBER
								)
						),
					"legalContext" => LEGALCONTEXT,
					"selectionCriteria" =>
						array(
							"eCarmedNumber" => $num_carte
						)
				);
            $soapClient->consultCarmedHistory($request);
            
            $debug = $soapClient->__getLastResponse();
		}
		catch (Exception $e)
		{
			$succes = 0;
			$message=$e->getMessage();
            exit($message);
        }

        $requestXML = Mutation::arrayToXML($request);
        
		$retour = $soapClient->__getLastResponse();
        
        $dom = new DomDocument();
		$dom->loadXML($retour);
                
        $date_debut_ambul = null;
        $date_debut_hospi = null;
		$date_debut_medecin = null;
        
        $ambulatoryHospitalization = $dom->getElementsByTagName("ambulatoryHospitalization")->item(0);
        if($ambulatoryHospitalization != null)
        {
            $validityPeriod = $ambulatoryHospitalization->getElementsByTagName("validityPeriod")->item(0);
            $date_debut_ambul = $validityPeriod->getElementsByTagName("startDate")->item(0)->nodeValue;
        }
        
        $hospitalisation = $dom->getElementsByTagName("hospitalization")->item(0);
        if($hospitalisation != null)
        {
            $validityPeriod = $hospitalisation->getElementsByTagName("validityPeriod")->item(0);
            $date_debut_hospi = $validityPeriod->getElementsByTagName("startDate")->item(0)->nodeValue;
        }  

		$doctor = $dom->getElementsByTagName("doctor")->item(0);
        if($doctor != null)
        {
            $validityPeriod = $doctor->getElementsByTagName("validityPeriod")->item(0);
            $date_debut_medecin = $validityPeriod->getElementsByTagName("startDate")->item(0)->nodeValue;
        }
        
        $date_arret = substr($this->donnees["DATE_MUTATION"],6,4)."-".substr($this->donnees["DATE_MUTATION"],3,2)."-".substr($this->donnees["DATE_MUTATION"],0,2);
        
        $datetime = new DateTime($date_arret);
        $datetime->modify('-1 day');
        $date_arret = $datetime->format('Y-m-d');
        
        if(isset($_POST))
        {
            if(isset($_POST['rn']))
            {
                $this->donnees["RN"] = $_POST['rn'];
                //echo "<br>utiliser : ".$_POST['rn'];
            }
        }

		try
		{
			$request =
			array(
                "informationCustomer" =>
                array(
                        "customerIdentification" =>
                        array(
                                "cbeNumber" => CBENUMBER
                        )
                ),
                "legalContext" => LEGALCONTEXT,
                "ssin" => $this->donnees["RN"],
                "eCarmedNumber" => $num_carte,
                "endDate" => $date_arret
			);
            
            if($date_debut_ambul != null)
            {
                $request["medicalCoverValidityPeriod"]["ambulatoryHospitalisation"] =  array(
                        "startDate" => $date_debut_ambul,
                        "endDate" => $date_arret
                    ) ; 
            }
            
            if($date_debut_hospi != null)
            {
                $request["medicalCoverValidityPeriod"]["hospitalisation"] =  array(
                        "startDate" => $date_debut_hospi,
                        "endDate" => $date_arret
                    ) ; 
            }
			if($date_debut_medecin != null)
            {
                $request["medicalCoverValidityPeriod"]["doctor"] =  array(
                        "startDate" => $date_debut_medecin,
                        "endDate" => $date_arret
                    ) ; 
            }
            $requestXML = Mutation::arrayToXML($request);
			$soapClient->stopCarmed($request);
            
		}
		catch (Exception $e)
		{
			/*
            ?>
                <h1>Une erreur est survenue, la carte n'a pu être stoppée.</h1>
            <?php
            */
            $succes = 0;
           
			$message=$e->getMessage();
            
            if(isset($e->detail->information[3]->fieldValue))
            {
                $message.="<br />".$e->detail->information[3]->fieldValue;
                
            }
            $xml="";
            //erreur
            //$message = $dom->getElementsByTagName('communication')->item(0)->nodeValue;
            return array("resultat"=>0,"message"=>$message,"xmlEnvoye"=>$requestXML,"xmlRecu"=>$retour,"debug"=>$debug);
        }
        
        $requestXML = $soapClient->__getLastRequest();
		$retour = $soapClient->__getLastResponse();
        
        $dom = new DomDocument();
		$dom->loadXML($retour);
        
        $resultat = $dom->getElementsByTagName('value')->item(0)->nodeValue;
        
        if($resultat == "NO_RESULT")
        {
            //erreur
            $message = $dom->getElementsByTagName('communication')->item(0)->nodeValue;
            return array("resultat"=>0,"message"=>$message,"xmlEnvoye"=>$requestXML,"xmlRecu"=>$retour,"debug"=>$debug);
        }
        else
        {
            return array("resultat"=>1,"message"=>"Succès","xmlEnvoye"=>$requestXML,"xmlRecu"=>$retour);
        }
    }
    
    public function get_date_form_oracle_by_id($id)
    {
        $db = DatabaseManager::getDb();
        
        $requete = "select * from med_mutation where id_mutation = ".$id;

        $stid = oci_parse($db, $requete);
        if (!oci_execute($stid))
        {
           exit("La requete : <b>".$requete."</b> a généré une erreur."); 
        }
        
        $row = oci_fetch_array($stid);
        foreach($row as $key=>$value)
        {
            $this->donnees[$key] = $value;
        }
    }
    
    public static function get_all_refundcode()
    {
        $db = DatabaseManager::getDb();
        $refundcodes = array();
        $requete = "select * from med_refundcode";

        $stid = oci_parse($db, $requete);
        if (!oci_execute($stid))
        {
           exit("La requete : <b>".$requete."</b> a généré une erreur."); 
        }
        
        while($row = oci_fetch_array($stid))
        {
            $refundcodes[$row["ID"]] = utf8_encode($row["INFO"]);
        }
        
        return $refundcodes;
    }
    
    public static function get_data_from_file($dirname,$fileName)
    {
		if(is_file($dirname."/".$fileName))
        {
            $mutation = new Mutation();
            
            $mutation->donnees["NOM_FICHIER"] = $fileName;
            $xmlFile = fopen($dirname."/".$fileName,'r');

            $xml = "";
            
            if($xmlFile)
            {
                while (($buffer = fgets($xmlFile, 4096)) !== false) 
                {
                    $xml .= $buffer;
                }
            }
            
            fclose($xmlFile);  
            
            $dom = new DomDocument();
            $dom->loadXML(utf8_encode($xml));

            $mutation->donnees["Identification"] =              $mutation->getValueOfElement($dom, 'Identification');
            $mutation->donnees["ssin"] =                        $mutation->getValueOfElement($dom, 'ssin');
            $mutation->donnees["lastName"] =                    $mutation->getValueOfElement($dom, 'lastName');
            $mutation->donnees["firstName"] =                   $mutation->getValueOfElement($dom, 'firstName');
            $mutation->donnees["birthDate"] =                   $mutation->getValueOfElement($dom, 'birthDate');
            $mutation->donnees["eCarmedNumber"] =               $mutation->getValueOfElement($dom, 'eCarmedNumber');
            $mutation->donnees["versionNbr"] =                  $mutation->getValueOfElement($dom, 'versionNbr');
            $mutation->donnees["cardStatus"] =                  $mutation->getValueOfElement($dom, 'cardStatus');
            $mutation->donnees["newRefundCode"] =               $mutation->getValueOfElement($dom, 'newRefundCode');
            
            $refund_podmi_sppis = $dom->getElementsByTagName("refund_podmi_sppis")->item(0);
            $mutation->donnees["oldRefundCode"] = $refund_podmi_sppis->getElementsByTagName("refundCode")->item(0)->nodeValue;
            
            $suspenstion = $dom->getElementsByTagName("suspension")->item(0);
            $detailSuspenstion = $suspenstion->getElementsByTagName("detail")->item(0);
            $mutation->donnees["reason"] = $detailSuspenstion->getElementsByTagName("reason")->item(0)->nodeValue;
            $mutation->donnees["date_mutation"] = $detailSuspenstion->getElementsByTagName("date")->item(0)->nodeValue;
            
            $authorizedActions = $dom->getElementsByTagName("authorizedActions");
            $mutation->donnees["authorizedActions"] = array();
            $compteAction = $authorizedActions->length ;
            for($a=0;$a<$compteAction;$a++) 
            {            
                $mutation->donnees["authorizedActions"][] = $authorizedActions->item($a)->nodeValue;
            }
            
            $mutation->donnees["changePodmi_sppisPartInd"] =    $mutation->getValueOfElement($dom, 'changePodmi_sppisPartInd');
            $mutation->donnees["changeMedicalUrgencyInd"] =     $mutation->getValueOfElement($dom, 'changeMedicalUrgencyInd');
            $mutation->donnees["changeAffiliedMutualityInd"] =  $mutation->getValueOfElement($dom, 'changeAffiliedMutualityInd');
            $mutation->donnees["mutationNumber"] =              $mutation->getValueOfElement($dom, 'mutationNumber');
            
            return $mutation;
        }
        else
        {
            return -1;
        }
    }
    
    public function get_data_from_xml($xml)
    {
        $dom = new DomDocument();
        if(@$dom->loadXML(utf8_encode($xml)) !== false )
        {
            $this->donnees["Identification"] =              $this->getValueOfElement($dom, 'Identification');
            $this->donnees["ssin"] =                        $this->getValueOfElement($dom, 'ssin');
            $this->donnees["lastName"] =                    $this->getValueOfElement($dom, 'lastName');
            $this->donnees["firstName"] =                   $this->getValueOfElement($dom, 'firstName');
            $this->donnees["birthDate"] =                   $this->getValueOfElement($dom, 'birthDate');
            $this->donnees["eCarmedNumber"] =               $this->getValueOfElement($dom, 'eCarmedNumber');
            $this->donnees["versionNbr"] =                  $this->getValueOfElement($dom, 'versionNbr');
            $this->donnees["cardStatus"] =                  $this->getValueOfElement($dom, 'cardStatus');
            
            $refund_podmi_sppis = $dom->getElementsByTagName("refund_podmi_sppis")->item(0);
            $this->donnees["oldRefundCode"] = $refund_podmi_sppis->getElementsByTagName("refundCode")->item(0)->nodeValue;
			if ($this->donnees["oldRefundCode"] == "")
				$this->donnees["oldRefundCode"] = 0;
            
            $suspenstion = $dom->getElementsByTagName("suspension")->item(0);

            if($suspenstion != null)
            {
                $detailSuspenstion = $suspenstion->getElementsByTagName("detail")->item(0);
                $this->donnees["reason"] = $detailSuspenstion->getElementsByTagName("reason")->item(0)->nodeValue;
                $this->donnees["date_mutation"] = $detailSuspenstion->getElementsByTagName("date")->item(0)->nodeValue;
                $this->donnees["newRefundCode"] =                  $this->getValueOfElement($dom, 'newRefundCode');
				if ($this->donnees["newRefundCode"] == "")
					$this->donnees["newRefundCode"] = 0;
                $this->donnees["changePodmi_sppisPartInd"] =    $this->getValueOfElement($dom, 'changePodmi_sppisPartInd');
                $this->donnees["changeMedicalUrgencyInd"] =     $this->getValueOfElement($dom, 'changeMedicalUrgencyInd');
                $this->donnees["changeAffiliedMutualityInd"] =  $this->getValueOfElement($dom, 'changeAffiliedMutualityInd');
            }
            else
            {
                //changement de RN ?
                $changementRN = $dom->getElementsByTagName("newSsin")->item(0);
                $newFirstName = $dom->getElementsByTagName("newFirstName")->item(0);
                if($changementRN != null)
                {
                    $this->donnees["newSsin"] = $this->getValueOfElement($dom, 'newSsin');
                    $this->donnees["reason"] = "Changement de RN";
                    $this->donnees["date_mutation"] = $this->getValueOfElement($dom, 'FormCreationDate');
                    $this->donnees["newRefundCode"] = $this->donnees["oldRefundCode"];
					if ($this->donnees["newRefundCode"] == "")
						$this->donnees["newRefundCode"] = 0;
                    $this->donnees["changePodmi_sppisPartInd"] =    0;
                    $this->donnees["changeMedicalUrgencyInd"] =     0;
                    $this->donnees["changeAffiliedMutualityInd"] =  0;
                }
                else if($newFirstName != null)
                {
                    $this->donnees["newFirstName"] = $this->getValueOfElement($dom, 'newFirstName');
                    $this->donnees["reason"] = "Changement de prénom/NOM, nouveau : ".$this->getValueOfElement($dom, 'newLastName')." ".strtoupper($this->getValueOfElement($dom, 'newFirstName'));
                    $this->donnees["date_mutation"] = $this->getValueOfElement($dom, 'FormCreationDate');
                    $this->donnees["newRefundCode"] = $this->donnees["oldRefundCode"];
					if ($this->donnees["newRefundCode"] == "")
						$this->donnees["newRefundCode"] = 0;
                    $this->donnees["changePodmi_sppisPartInd"] =    0;
                    $this->donnees["changeMedicalUrgencyInd"] =     0;
                    $this->donnees["changeAffiliedMutualityInd"] =  0;
                }
            }
            
            $authorizedActions = $dom->getElementsByTagName("authorizedActions");
            $this->donnees["authorizedActions"] = array();
            $compteAction = $authorizedActions->length;
            for($a=0;$a<$compteAction;$a++)
            {            
                $this->donnees["authorizedActions"][] = $authorizedActions->item($a)->nodeValue;
            }
            
            $this->donnees["mutationNumber"] = $this->getValueOfElement($dom, 'mutationNumber');
        }
    }
    
    public static function get_data_from_mysql($ligne)
    {		
        $mutation = new Mutation();
        
        $mutation->donnees["NOM_FICHIER"] = $ligne["filename"];
        
        $xml = utf8_decode($ligne["content"]);
        $mutation->get_data_from_xml($xml);
        
        return $mutation;
    }
    
    public static function get_data_from_mysql_by_filename($filename)
    {		
        $mutation = new Mutation();
        
        $db = MysqlManager::getDb();
        $requete = "select * from fichier_mutation where FILENAME = '".$filename."'";
        
        $stmt = $db->prepare($requete);
        $stmt->execute();
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);        
        
        $mutation->donnees["NOM_FICHIER"] = $ligne["filename"];
        
        $xml = utf8_decode(utf8_decode($ligne["content"]));
        
        $mutation->get_data_from_xml($xml);
        
        return $mutation;
    }
    
    public function ajouter()
    {
        $resultat = array();
        
        $actionsPossibles = "";
        
        $compte = 0;
        foreach($this->donnees["authorizedActions"] as $action)
        {
            if($compte> 0)
            {
                $actionsPossibles .= " - ";
            }
            
            $actionsPossibles .= trim($action);
            
            $compte++;
        }
        
        $db = DatabaseManager::getDb();
        $mysql = MysqlManager::getDb();
        
        //Liaison SSC
        $requete = "select ID_INDIVIDUS from ssc_individus where REGISTRE_NATIONAL LIKE '".$this->donnees["ssin"]."' and softdelete = 0";
        $stid = oci_parse($db, $requete);
        if (!oci_execute($stid))
        {
           exit("La requete : <b>".$requete."</b> a généré une erreur."); 
        }
        
        $compte = 0;
        $id_individu = 0;
        $resultat["ssc"] = 0;
        while($row = oci_fetch_array($stid))
		{            
            $resultat["ssc"] = 1;
            $id_individu = $row["ID_INDIVIDUS"];
            $compte++;
        }
        
        if($compte > 1)
        {
            $id_individu = -1;
            $resultat["ssc"] = -1;
        }
        
        $this->donnees["id_individu"] = $id_individu;
        if(!isset($this->donnees["newSsin"]))
        {
            $this->donnees["newSsin"] = "";
        }
        
        $requete = "Insert INTO MED_MUTATION 
        (
            NOM_FICHIER,
            IDENTIFICATION,
            RN,
            NOM,
            PRENOM,
            DATE_NAISSANCE,
            NUM_CARTE,
            NUM_VERSION,
            STATUT_CARTE,
            RAISON,
            DATE_MUTATION,
            ACTION_POSSIBLE,
            CHANGE_PART_SPP,
            CHANGE_URG_MED,
            CHANGE_MUT,
            MUTATION_NUMBER,
            ID_INDIVIDU_SSC,
            OLD_REFUNDCODE,
            NEW_REFUNDCODE,
            NEWSSIN
        ) 
        VALUES 
        (
            '".$this->donnees["NOM_FICHIER"]."',
            '".$this->donnees["Identification"]."',
            '".$this->donnees["ssin"]."',
            '".str_replace("'", "''", $this->donnees["lastName"])."',
            '".str_replace("'", "''", $this->donnees["firstName"])."',
           '".$this->donnees["birthDate"]."',
            ".$this->donnees["eCarmedNumber"].",
            ".$this->donnees["versionNbr"].",
            '".$this->donnees["cardStatus"]."',
            '".str_replace("'", "''", $this->donnees["reason"])."',
            TO_DATE('".$this->donnees["date_mutation"]."','YYYY-MM-DD'),
            '".$actionsPossibles."',
            '".$this->donnees["changePodmi_sppisPartInd"]."',
            '".$this->donnees["changeMedicalUrgencyInd"]."',
            '".$this->donnees["changeAffiliedMutualityInd"]."',
            ".$this->donnees["mutationNumber"].",
            ".$id_individu.",
            ".$this->donnees["oldRefundCode"].",
            ".$this->donnees["newRefundCode"].",
            '".$this->donnees["newSsin"]."'
        )";
        
        $stid = oci_parse($db, $requete);
        $oci_error = 0;
        
        if (!@oci_execute($stid))
        {
            $oci_error = oci_error($stid);
           
            if($oci_error["code"] === 1)
            {
                //contraine de cle unique, il faut quand même déplacer le fichier
                $resultat["insert"] = 0;
            }
            else
            {
                $resultat["insert"] = -1;
                $resultat["insert_error"] = $oci_error;
                $resultat["insert_requete"] = $requete;
                
                echo "<pre>";
                print_r($oci_error);
                echo "</pre>";
                
                return -1;
            }
        }
        else
        {
            $resultat["insert"] = 1;
        }
          
        //signalé comme uploade
        $requete = "update fichier_mutation set uploade = 1 where FILENAME = '".$this->donnees["NOM_FICHIER"]."'";
                
        $stmt = $mysql->prepare($requete);
        
        if($stmt->execute())
        {
            $resultat["move"] = 1;
        }
        else
        {
            $resultat["move"] = 0;
        }
        
        return $resultat;
    }
    
    public static function listerMutationsNonTraitees($ordre = "date_mutation desc", $filtre = '')
    {
        $db = DatabaseManager::getDb();
        $requete = "select * from med_mutation where TRAITE = 0";
        if($filtre != "")
        {
            $requete .= "and (UPPER(NOM) LIKE '".strtoupper($filtre)."%' OR UPPER(PRENOM) LIKE '".strtoupper($filtre)."%' OR RN LIKE '".($filtre)."%')";
        }
        $requete .= " order by ".$ordre;
        $stid = oci_parse($db, $requete);
        if (!oci_execute($stid))
        {
           exit("La requete : <b>".$requete."</b> a généré une erreur."); 
        }
        
        $liste = array();
        while($row = oci_fetch_array($stid))
		{            
            $mutation = new Mutation($row);
            $liste[] = $mutation;
        }
        
        return $liste;
    }
    
    public static function listerMutations($ordre = "date_mutation desc", $filtre = '')
    {
        $db = DatabaseManager::getDb();
        $requete = "select * from med_mutation ";
        if($filtre != "")
        {
            $requete .= "where (UPPER(NOM) LIKE '".strtoupper($filtre)."%' OR UPPER(PRENOM) LIKE '".strtoupper($filtre)."%' OR RN LIKE '".($filtre)."%')";
        }
        $requete .= " order by ".$ordre;
        
        $stid = oci_parse($db, $requete);
        if (!oci_execute($stid))
        {
           exit("La requete : <b>".$requete."</b> a généré une erreur."); 
        }
        
        $liste = array();
        while($row = oci_fetch_array($stid))
		{            
            $mutation = new Mutation($row);
            $liste[] = $mutation;
        }
        
        return $liste;
    }
    
    public static function listMutationFiles()
    {
        $fileList = scandir(__DIR__."/../flux");
        $files = array();
        
        foreach($fileList as $file)
        {
            if(strpos($file, "FO") === 0)
            {
                $temp = array();
                $temp = Mutation::get_data_from_file("flux",$file);
                $files[] = $temp;
            }
        }
        
        return $files;
    }
    
    public static function listMutationMysql()
    {
        $db = MysqlManager::getDb();
        $requete = "SELECT * FROM fichier_mutation WHERE uploade = 0";  
        
        $stmt = $db->prepare($requete);
        $stmt->execute();
        $files=array();
        
        while($ligne = $stmt->fetch(PDO::FETCH_ASSOC))            
        {
            $temp = array();
            $temp = Mutation::get_data_from_mysql($ligne);
            if($temp !== false)
            {
                $files[] = $temp;              
            }
        }
        
        return $files;
    }
    
    public function getValueOfElement($dom, $name)
    {
		$val =  $dom->getElementsByTagName($name);
		if ($val->length > 0) {
			if($val != null || $val !== false)
			{
				$val = $val->item(0);
			}
			if($val != null || $val !==false)
			{
				$val = $val->nodeValue;
			}
			
		} else {
			$val = "";
			
		}
        return $val;
    }
    
    public function info()
    {
        echo "<pre>";
        print_r($this);
        echo "</pre>";
    }
}
?>