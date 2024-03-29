<?php 
	
	function my_autoloader($class) //charge les class au fur et a mesure qu elle sont appelée 
	{
        $class2 = strtoupper(substr($class,0,1)).strtolower(substr($class,1));
        
		if(is_file(__DIR__."/".$class . '.class.php'))
        {
            include __DIR__."/".$class . '.class.php';		
        }
        else if(is_file(__DIR__."/".$class2. '.class.php'))
        {
            include __DIR__."/".$class2 . '.class.php';		
        }
        else if(is_file(__DIR__."/".$class . '.php'))
        {
            include __DIR__."/".$class . '.php';		
        }
        else if(is_file(__DIR__."/".$class2. '.php'))
        {
            include __DIR__."/".$class2 . '.php';		
        }        
	}

	spl_autoload_register('my_autoloader');

?>