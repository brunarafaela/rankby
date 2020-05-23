<?php 

Class acesso {

	private $db = array(
		'production' 	=> array(
			'host' => 'localhost',
			'user' => 'brunaraf_tcc',
			'password' => 't5-726E9@!IN',
			'database' => 'brunaraf_tcc'
		),
		'testing' 		=> array(
			'host' => 'localhost',
			'user' => 'brunaraf_tcc',
			'password' => 't5-726E9@!IN',
			'database' => 'brunaraf_tcc'
		),
		'development' 	=> array(
			'host' => 'localhost',
			'user' => 'brunaraf_tcc',
			'password' => 't5-726E9@!IN',
			'database' => 'brunaraf_tcc'
		),
	);

	public function getdb($ambient = 'development'){
		return $this->db[$ambient];
	}

}