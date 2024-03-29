<?php

class Ldap
{
	const CONNEXION_OBLIGATOIRE = 1;
	const MAUVAIS_LOGIN_PASSWORD = 2;
	const PAS_DE_DROITS = 3;
	const FORMULAIRE_INCOMPLET = 4;
	
	private $soapClient;
	
	public function __construct($wsdl='http://sociabili/ws/ws_ldap/wsdl/ldapConnex.wsdl', $options=array('compression'=>true,'exceptions'=>false,'trace'=>true))
	{
		$this->soapClient = new SoapClient($wsdl, $options);
	}
	
	public function authentification($login, $password, $groupe='')
	{
		try
		{
			$res = $this->soapClient->connexion($login, $password);
			
			if (is_int($res))
			{
				return array('succes'=>false, 'xml'=>$res);
			}
			else
			{
				// Test de sa présence dans l'AD
				if (empty($groupe))
				{
					return array('succes'=>true, 'xml'=>'');
				}
				// Test de sa présence dans un groupe de l'AD
				else
				{
					$parser = new SimpleXMLElement(html_entity_decode($res));
					
					foreach($parser->groupes->donnee as $index=>$grp)
					{
						if ($grp==$groupe)
						{
							return array('succes'=>true, 'xml'=>$res);
						}
					}
				}
			}
			
			return array('succes'=>false, 'xml'=>Ldap::PAS_DE_DROITS);
		}
		catch (Exception $e)
		{
			return array('succes'=>false,'xml'=>$res);
		}
	}
	
	public function __destruct()
	{
		unset($this->ldap);
	}
}
