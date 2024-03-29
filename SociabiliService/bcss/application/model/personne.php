<?php

class Personne
{
	private $nom;
	private $prenom;
	private $rn;
	private $sexe;
	private $date_naissance;
	private $adresse;
	
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
		$this->$key = $data;
	}
	public function setArray($array)
	{
		foreach($array as $key=>$data) {
			$this->set($key, $data);
		}
	}
	
	public function getNomComplet()
	{
		return $this->nom . " " . $this->prenom;
	}
}