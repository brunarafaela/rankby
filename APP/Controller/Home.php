<?php 

class Home {
	public function __construct() {
		if (! is_numeric(Session()->get('aid'))) {
			redirect('/Index/home/');
		}
	}

	public function notFound() {
		return $this->index();
	}

	public function index() {		
		includePage('home', 'Dashboard');
	}

}

