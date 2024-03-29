<?php

class MysqlManager
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
			try 
			{
				$db->db_connection = new PDO('mysql:dbname='.MYSQL_DB.';host='.MYSQL_SERVER.';charset=UTF8',
                                                MYSQL_LOGIN,
                                                MYSQL_PASSWORD);
			} 
			catch (PDOException $e)
			{
				exit( 'Connexion échouée : ' . $e->getMessage());
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
