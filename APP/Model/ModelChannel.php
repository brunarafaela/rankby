<?php

include_once('conf/db.php');

class ModelChannel extends db{

	function __construct(){
		parent::__construct();
	}

	public function create($data) {
		db::insert('canal', $data);
		$last = db::lastRow('canal', 'idCanal');
		return $last;
	}

	public function edit_user($data, $where) {
		return db::update('canal', $data, $where);
	}
	
	public function search($query, $order = "canalId") {
	    return db::query("SELECT * FROM canal as c left join pais as p on p.paisCode = c.paisId WHERE canalUsername like :query OR canalNome like :query order by :order DESC", [":query" => "%" . $query . "%", ":order" => $order]);
	}
	
	public function get_global_ranking($inscritos) {
		return db::queryOne("SELECT count(*) + 1 as ranking FROM canal WHERE canalInscritos > :inscritos;", [":inscritos" => $inscritos]);
	}
	
	public function get_country_ranking($inscritos, $pais) {
		return db::queryOne("SELECT count(*) + 1 as ranking FROM canal WHERE paisId = :pais AND canalInscritos > :inscritos;", [":inscritos" => $inscritos, ":pais" => $pais]);
	}
	
	public function lista($limit, $order, $pais = false, $categoria = false, $page = 1){
	    
	    $page = ($page - 1) * $limit;
	   // echo $page;
	    
	    if ($categoria) {
	    
            if($pais) {
    	        return db::query("SELECT * FROM canal as c left join pais as p on p.paisCode = c.paisId 
    	        left join canal_categoria as cc on c.idCanal = cc.idCanal 
    	        WHERE c.paisId = :pais AND cc.categoriaId = :categoria 
    	        order by ".$order." DESC limit :page, :limit", 
    	        [':pais' => $pais, ':categoria' => $categoria, ":limit" => $limit, ':page' => $page]);    
    	    }
        
            return db::query("SELECT * FROM canal as c left 
            join pais as p on p.paisCode = c.paisId 
            left join canal_categoria as cc on c.idCanal = cc.idCanal 
            WHERE cc.categoriaId = :categoria 
            order by ".$order." DESC  limit :page, :limit", 
            [":categoria" => $categoria, ":limit" => $limit, ':page' => $page]);    	        
	 
	    } 

        if($pais) {
	        return db::query("SELECT * FROM canal as c 
	        left join pais as p on p.paisCode = c.paisId 
	        WHERE c.paisId = :pais  order by ".$order." 
	        DESC limit :page, :limit", 
	        [':pais' => $pais, ":limit" => $limit, ':page' => $page]);    
	    }
        
        return db::query("SELECT * FROM canal as c left join pais as p on p.paisCode = c.paisId order by ".$order." DESC limit :page, :limit", [":limit" => $limit, ':page' => $page]);    	        

	}
	
	public function count_lista($pais = false, $categoria = false){
	    
	    if ($categoria) {
	    
            if($pais) {
    	        return db::queryOne("SELECT count(*) as total FROM canal as c left join pais as p on p.paisCode = c.paisId left join canal_categoria as cc on c.idCanal = cc.idCanal WHERE c.paisId = :pais AND cc.categoriaId = :categoria", [':pais' => $pais, ':categoria' => $categoria]);    
    	    }
        
            return db::queryOne("SELECT count(*) as total FROM canal as c left join pais as p on p.paisCode = c.paisId left join canal_categoria as cc on c.idCanal = cc.idCanal WHERE cc.categoriaId = :categoria", [":categoria" => $categoria]);    	        
	 
	    } 

        if($pais) {
	        return db::queryOne("SELECT count(*) as total FROM canal as c left join pais as p on p.paisCode = c.paisId WHERE c.paisId = :pais", [':pais' => $pais]);    
	    }
        
        return db::queryOne("SELECT count(*) as total FROM canal as c left join pais as p on p.paisCode = c.paisId ");    	        

	}

	public function get_by($data, $limit = 1) {
		return db::select('canal', '*', $data, $limit);
	}

	public function get_by_id($id) {
		return db::select('canal', '*', ['idCanal' => $id], 1);
	}

	public function channelExists($data = false) {
		return (db::select('canal', '*', $data));
	}

	public function get_list($data, $limit = 10) {
		return db::select('canal', '*', $data, $limit, 'idCanal DESC');
	}

	public function get_count() {
		return db::queryOne('select count(*) as total from canal');
	}
	
	public function get_country_count() {
		return db::queryOne('select count(distinct paisId) as total from canal');
	}
	

}