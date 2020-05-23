<?php

include_once('conf/db.php');

class ModelDashboard extends db{

	private $visible = [];

	function __construct(){
		parent::__construct();
	}

}
