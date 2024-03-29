<?php 
	
	require_once(dirname(__FILE__)."/../config/db.php");
	
	class DatabaseManager
	{
		private $connexionDB;
		
		public function __construct()
		{
			if(!$this->connexionDB = oci_connect(DB_USER, PASSWORD, TNS, CHARSET))
			{
				?>
					<p style='error'>Erreur lors de la connexion à la DB.</p>
				<?php
				include("view/footer.php");
				exit;
			}
			
			// Parametrages des variables ORACLE
			$cursor = oci_new_cursor($this->connexionDB);
			$sql = "ALTER SESSION SET NLS_NUMERIC_CHARACTERS = ',.'";
			$stid = oci_parse($this->connexionDB, $sql);
			oci_free_statement($cursor);
		}
		
		public function __get($var)
		{
			return $this->$var;
		}
		
		public static function cleanSQLStr($string)
		{
			//return str_replace("'","''",$string);
			return str_replace("'","'",$string);
		}
	}
	
		
	
?>