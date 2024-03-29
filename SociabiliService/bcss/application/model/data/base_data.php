<?php

class BaseData
{
	protected $path;
	
	public function __construct($path)
	{
		$this->path = $path;
	}
	public function __destruct()
	{
		unset($this->path);
	}
}