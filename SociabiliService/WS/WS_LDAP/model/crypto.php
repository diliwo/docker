<?php

class Crypto{
	
	private $dimensioncle;
	private $cle;
	private $chaine;
	//private $tableConversionCle = array(54,66,67,21,91,34,97,62,22,58,50,113,7,33,96,41,55,83,42,93,126,53,37,60,102,75,26,35,116,13,73,79,95,39,110,103,46,1,85,76,43,82,12,28,72,114,89,31,15,124,36,51,92,45,94,4,101,47,118,52,74,25,99,2,106,44,122,81,68,88,24,120,48,127,0,61,112,65,69,3,32,125,104,57,5,78,121,107,6,11,23,49,87,115,8,63,80,123,9,17,84,71,100,105,19,64,117,86,10,90,111,27,40,98,14,16,18,20,119,109,29,38,108,77,70,59,56,30);
	//private $tableInversionCle = array(74,37,63,79,55,84,88,12,94,98,108,89,42,29,114,48,115,99,116,104,117,3,8,90,70,61,26,111,43,120,127,47,80,13,5,27,50,22,11,33,112,15,18,40,65,53,36,57,72,91,10,51,59,21,0,16,126,83,9,125,23,75,7,95,105,77,1,2,68,78,124,101,44,30,60,25,39,123,85,31,96,67,41,17,100,38,107,92,69,46,109,4,52,19,54,32,14,6,113,62,102,56,24,35,82,103,64,87,122,119,34,110,76,11,45,93,28,106,58,118,71,86,66,97,49,81,20,73);
	
	
	private $tableConversionCle= array("",55,67,68,22,92,35,98,63,23,59,
                                        51,114,8,34,97,42,56,84,43,94,
                                        127,54,38,61,103,76,27,36,117,14,
                                        74,80,96,40,111,104,47,2,86,77,
                                        44,83,13,29,73,115,90,32,16,125,
                                        37,52,93,46,95,5,102,48,119,53,
                                        75,26,100,3,107,45,123,82,69,89,
                                        25,121,49,128,1,62,113,66,70,4,
                                        33,126,105,58,6,79,122,108,7,12,
                                        24,50,88,116,9,64,81,124,10,18,
                                        85,72,101,106,20,65,118,87,11,91,
                                        112,28,41,99,15,17,19,21,120,110,
                                        30,39,109,78,71,60,57,31,139,156,
                                        164,154,151,159,157,155,152,149,130,129,
                                        136,132,131,133,134,148,135,141,146,162,
                                        137,138,140,147,142,143,144,145,150,153,
                                        158,160,161,163,165);
                                        
       private $tableInversionCle = array("",75,38,64,80,56,85,89,13,95,99,
                                        109,90,43,30,115,49,116,100,117,
                                        105,118,4,9,91,71,62,27,112,44,
                                        121,128,48,81,14,6,28,51,23,12,
                                        34,113,16,19,41,66,54,37,58,73,
                                        92,11,52,60,22,1,17,127,84,10,126,
                                        24,76,8,96,106,78,2,3,69,79,125,
                                        102,45,31,61,26,40,124,86,32,97,
                                        68,42,18,101,39,108,93,70,47,110,
                                        5,53,20,55,33,15,7,114,63,103,
                                        57,25,36,83,104,65,88,123,120,
                                        35,111,77,12,46,94,29,107,59,119,
                                        72,87,67,98,50,82,21,74,140,139,
                                        143,142,144,145,147,141,151,152,129,153,
                                        148,155,156,157,158,149,154,146,138,159,
                                        133,137,160,132,136,130,135,161,134,162,
                                        163,150,164,131,165);   

	
	public function __construct($cle){
		
		$this->dimensioncle = strlen($cle);
		
		if($this->dimensioncle<16){
			echo  'La clé doit faire plus de 15 Caractères.';	
		}else{
			$this->cle = $cle;
			
			//conversion de la clé
			$tabCle = str_split($this->cle);
			for($i=0;$i<strlen($this->cle);$i++)
				$tabCle[$i] = $this->tableConversionCle[ord($tabCle[$i])];
			
			$this->cle = $tabCle;
		}

	}
	
	public function encryptage($chaine){
		
		$this->chaine = $chaine;
		$tabChaine = str_split ($this->chaine);
		
		//transforme la chaine en ajoutant toutes les 5 lettres un caract aléatoire et utilise la table de conversion
		for($i=0;$i<count($tabChaine);$i++){
			if((($i+1)%5) == 0 && $i!=0){
				$fin = array_slice($tabChaine,$i);
				$tabChaine = array_splice($tabChaine,0,$i);
				array_push($tabChaine,rand(0,164));
				$tabChaine = array_merge($tabChaine,$fin);
			}else{
				//echo ord($tab[$i]);
				$tabChaine[$i] = $this->tableConversionCle[ord($tabChaine[$i])];
			}
			
		}
		
		
		//ajout un aléatoire en dernier
		array_push($tabChaine,rand(0,164));
		
		while(count($this->cle) < count($tabChaine)){
				$this->cle = array_merge($this->cle,$this->cle);
		}
		
		
		//additionne la chaine et la clé case à case.
		for($i=0;$i<count($tabChaine);$i++)
			$tabChiffree[] = ($tabChaine[$i]+$this->cle[$i])%165;
			
			
		
			
		$retour = "";
		for($i=0;$i<count($tabChiffree);$i++)
			$retour .= chr($tabChiffree[$i]);
		
		return $retour;
	}
	
	
	
	
	public function decryptage($chaine){
		
		//vire le dernier elem
		$tabChaine = str_split($chaine);
		$tabChaine = array_slice($tabChaine,0,count($tabChaine)-1);
		
		//récup le numero ascii
		for($i=0;$i<count($tabChaine);$i++){
			$tabChaine[$i] = ord($tabChaine[$i]);
		}
		
		
		//Soustrait la clé
		for($i=0;$i<count($tabChaine);$i++){
			if($tabChaine[$i] < $this->cle[$i] ){
				$tabChaine[$i] = 165+($tabChaine[$i] - $this->cle[$i]);
			}else{
				$tabChaine[$i] = ($tabChaine[$i] - $this->cle[$i]);
			}

		}
		
		
		//transforme suivant la table de retour
		$retour = "";
		for($i=0;$i<count($tabChaine);$i++){
			if((($i+1)%5) != 0 || $i ==0){
				$tabChaine[$i] = chr($this->tableInversionCle[$tabChaine[$i]]);
				$retour.= $tabChaine[$i];
			}
		}
		
		return $retour;
		
	}
	
	
	
}


$crypto = new Crypto("CpH9RBGFDJML486221A2JOfd54F");

echo 'A crypter : ProutttProutttProutttProuttt<br />';

$chiffree = $crypto->encryptage(("tést"));

echo "Chiffrement : ".($chiffree).'<br />';
echo "Déchiffrement : ".($crypto->decryptage($chiffree))."<br />";
echo (ord(utf8_decode("é")));
?>