<?php

class DatabaseManager
{
	private static $instance;
	private $db_connection;

	public static function getInstance()
	{
		if (self::$instance == null) {
			$className = __CLASS__;			
			self::$instance = new $className();			
		}
		return self::$instance;
	}

	public static function initializeConnection()
	{
		$db = self::getInstance();
		
		if($db->db_connection == null)
		{
            $conn;
            $conn =  oci_connect(ORACLE_LOGIN, ORACLE_PASSWORD, ORACLE_SERVER);
            if (!$conn) 
            {
                $e = oci_error();
                var_dump($e);
                exit ("Erreur connexion DB !");
                
            }
            else
            {
                $db->db_connection = $conn;
            }				
		}		
	}

	public static function getDb()
	{
		$db = self::getInstance();
		$db->initializeConnection();
		return $db->db_connection;
	}

	public static function CastForIn($string)
	{
		return utf8_decode($string);
	}

	public static function CastForOut($string)
	{
		return utf8_encode($string);
	}
}
