<?php
	

	class LiaisonMySql
	{
		private $host;
		private $databasename;
		private $user;
		private $password;
		
		private $activeDbLink;
		
		private $lastRequest = "";
		
		function __construct($host, $databasename)
		{
			$this->host = $host;
			$this->databasename = $databasename;
			
			switch($host)
			{
				case 'srvcpas003' :
					$this->user = "root";
					$this->password = "biscuit";
				break;
				
				case 'srvcpas004' :
					$this->user = "root";
					$this->password = "smiles";
				break;
					
				case 'localhost' :
					$this->user = "root";
					$this->password = "";
				break;
			}			
			
			try 
			{
				$activeDbLink = new PDO("mysql:host=".$this->host.";dbname=".$this->databasename.",".$this->user.",".$this->password."");
			} 
			catch (PDOException $e) 
			{
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		
		function envoyer_requete($requete, $params = array())
		{
			$this->lastRequest = $requete;
			$this->activeDbLink->prepare($this->lastRequest);
			$this->activeDbLink->execute($array);			
		}		
	}
?>