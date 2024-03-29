<?php

class BaseDb
{
	protected $db;
	
	public function __construct($dsn, $username, $password, $options)
	{
		$this->db = new PDO($dsn, $username, $password, $options);

		if (strpos($dsn, "oci") !== false)
			$this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
			
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}