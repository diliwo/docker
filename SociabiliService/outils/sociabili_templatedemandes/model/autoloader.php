<?php 
	
	function my_autoloader($class) //charge les class au fur et a mesure qu elle sont appelée 
	{
		if($class == "adLDAP")
		{
			include 'asset/adLDAP/src/' . $class . '.php';
		}
		else
		{
			include 'model/' . $class . '.php';
		}
		
	}

	spl_autoload_register('my_autoloader');

?>