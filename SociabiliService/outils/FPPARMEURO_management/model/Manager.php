<?php
	
	Abstract class Manager{
	
		protected $_db;
		
		public function __construct($_db = null){
			$this->setDb($_db);
		}
		public function setDb(){
			$this->_db = Factory::ConnectionDB();
		}
	
	}

?>