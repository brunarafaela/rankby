<?php

Class Index {

	public function home(){
		$this->inicio();
	}
    	public function inicio(){
			includePage('TelaInicial', false);
	}
	
	public function notFound() {
		
	}
}