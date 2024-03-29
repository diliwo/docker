<?php
	class ConnexionLDAP
	{
		private $serv_customers;
		private $login;
		private $password;
		private $connexionValide;
		
		public function __construct($login, $password)
		{
			$options	= array(
				'compression'=>true,
				'exceptions'=>false,
				'trace'=>true
			);
			
			$this->login = $login;
			$this->password = $password;
			
			$this->serv_customers = new SoapClient('http://WebSvcProd\WS_LDAP/wsdl/ldapConnex.wsdl', $options);
			$retourLDAP = $this->serv_customers->connexion($login, $password);
						
			if($retourLDAP == 2)
			{
				//utilisateur inconnu				
				$this->connexionValide = false;
			}
			else
			{
				$this->connexionValide = true;
			}			
		}
		
		public function EstValide()
		{
			return $this->connexionValide;
		}
		
		public function __destruct()
		{
			
		}
		
		public function AppartientAuGroupe($nomGroupe)
		{
			if($this->connexionValide)
			{
				$retourLDAP = $this->serv_customers->connexion($this->login, $this->password);
				if(strpos($retourLDAP,"CN=".$nomGroupe) !== false)
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
				return false;
			}
		}		
	}
	
?>