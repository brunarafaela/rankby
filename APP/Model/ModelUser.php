<?php

include_once('conf/db.php');

class ModelUser extends db{

	function __construct(){
		parent::__construct();
	}

	public function create($data) {
		db::insert('usuario', $data);
		$last = db::lastRow('usuario', 'idUsuario');
		return $last;
	}

	public function edit_user($data, $where) {
		return db::update('usuario', $data, $where);
	}

	public function get_by($data, $limit = 1) {
		return db::select('usuario', '*', $data, $limit);
	}

	public function get_by_id($id) {
		return db::select('usuario', '*', ['idUsuario' => $id], 1);
	}

	public function userExists($data = false) {
		return (db::select('usuario', '*', $data));
	}

	public function get_list($data) {
		return db::select('usuario', '*', $data, 10, 'idUsuario DESC');
	}

	public function get_count($data) {
		return db::count('usuario', $data);
	}

}