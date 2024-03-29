<?php

class Integration
{
	private $date_debut;
	private $date_fin;
	private $numero_organisation;
	private $code_qualite;
	private $type;
	
	public function __construct($data=null)
	{
		if (is_array($data)) {
			foreach ($data as $key=>$value) {
				$key = str_replace('-', '_', $key);
				$this->$key = $value;
			}
		} elseif (is_object($data)) {
			foreach (get_object_vars($data) as $key=>$value) {
				$key = str_replace('-', '_', $key);
				$this->$key = $value;
			}
		}
	}
	
	public function get($key)
	{
		if (isset($this->$key)) {
			return $this->$key;
		}
		
		return null;
	}
	public function getArray($array)
	{
		$tab = array();
		foreach ($array as $key) {
			$tab[$key] = $this->get($key);
		}
		
		return $tab;
	}
	
	public function set($key, $data)
	{
		if (isset($this->$key)) {
			$this->$key = $data;
		}
	}
	public function setArray($array)
	{
		foreach($array as $key=>$data) {
			$this->set($key, $data);
		}
	}
	
	public static function compareCroissant($a, $b)
	{
		$tmp = explode("/", $a->get("date_debut"));
		$dateDebutA = $tmp[2] . $tmp[1] . $tmp[0];
		$tmp = explode("/", $b->get("date_debut"));
		$dateDebutB = $tmp[2] . $tmp[1] . $tmp[0];
	
		if ($dateDebutA == $dateDebutB)
			return 0;
	
		return ($dateDebutA > $dateDebutB) ? +1 : -1;
	}
	public static function compareDecroissant($a, $b)
	{
		$tmp = explode("/", $a->get("date_debut"));
		$dateDebutA = $tmp[2] . $tmp[1] . $tmp[0];
		$tmp = explode("/", $b->get("date_debut"));
		$dateDebutB = $tmp[2] . $tmp[1] . $tmp[0];
	
		if ($dateDebutA == $dateDebutB)
			return 0;
	
		return ($dateDebutA > $dateDebutB) ? -1 : +1;
	}
}