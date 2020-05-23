<?php

include_once('conf/db.php');

class ModelCountry extends db{

	function __construct(){
		parent::__construct();
	}

	public function getList() {
	    return db::query('SELECT * from pais');
	}
	
}