<?php

include_once('conf/db.php');

class ModelCategory extends db{

	function __construct(){
		parent::__construct();
	}

	public function createOrReturn($data) {
	    
	    $already = db::select('categoria', 'categoriaId', ['categoriaNome' => $data], 1);
	    
	    if(! $already) {
	        db::insert('categoria', ['categoriaNome' => $data]);
		    $last = db::lastRow('categoria', 'categoriaId');
		    
		    return $last->categoriaId;
	    }
	    
	    return $already->categoriaId;
	    
	}
	
	public function getCategories() {
	    return db::query('SELECT * from categoria');
	}
	
	public function addChannelCategory($data) {
		return db::insert('canal_categoria', $data);
	}
	
	public function getChannelCategories($channelID) {
	    return db::query('SELECT * from canal_categoria as c join categoria as ca on c.categoriaId = ca.categoriaId WHERE c.idCanal = :idCanal', 
	    [":idCanal" => $channelID]);
	}
	
	public function get_count() {
		return db::queryOne('select count(*) as total from categoria');
	}
	
}