<?php 

Class Hash {
	
	private $salt = 'kibeit264hti1dtrgyrq23456';

	function encode($string = false) {

		if ($string) {
			return hash('sha512', $string . $this->salt);
		} else {
			return false;
		}
	}
}