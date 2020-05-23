<?php

include_once('conf/db.php');

class ModelFollowing extends db{

	function __construct(){
		parent::__construct();
	}

	public function follow($data) {
		return db::insert('seguindo', $data);
	}

	public function is_following($data) {
		return (db::select('seguindo', '*', $data));
	}
	
	public function unfollow($data) {
		return db::delete('seguindo', $data);
	}
	
	public function getFollowing($user_id) {
	    return db::query("SELECT * FROM seguindo as s join canal as c on s.idCanal = c.idCanal WHERE s.idUsuario = :user_id", [":user_id" => $user_id]);
	}
	
// 	public function get_following_count($data) {
// 		return db::query("select count (*) FROM seguindo WHERE idUsuario = :user_id", [":user_id" => Session()->get('user_id')]);
// 	}

    
}