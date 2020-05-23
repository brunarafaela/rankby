<?php 
include('acesso.php');

class db extends acesso {

	private $debug;
	private $db;
	private $pdo_con;
	
	public function __construct () {

		$this->db = $this->getdb(AMBIENT);

		try {
			$this->pdo_con = new PDO('mysql:host='.$this->db['host'].';dbname='.$this->db['database'], $this->db['user'], $this->db['password']);	
			$this->pdo_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			// TODO: Erro 500;
			// TODO: Call error page
			// TODO: Show error page
			echo $e->getMessage();
		}

		$this->debug = isset($GLOBALS['debug']) ? $GLOBALS['debug'] : false;
	}


	public function raw_query($query = false, $return = false) {
		if($this->debug) echo $query . PHP_EOL . PHP_EOL;
		if ($query) {
			$result = $this->pdo_con->query($query);
			return $result->fetchAll(PDO::FETCH_OBJ);
		}
		return $return;
	}

	public function raw_queryOne($query = false, $return = false) {
		if($this->debug) echo $query . PHP_EOL . PHP_EOL;
		if ($query) {
			$result = $this->pdo_con->query($query);
			return $result->fetchObject();
		}
	}

	public function raw_send($query = false, $params = false) {
		if($this->debug) echo $query . PHP_EOL . PHP_EOL;
		return ($query) ? $this->pdo_con->query($query) : false;
	}



	public function query($sql = false, $params = [], $return = false) {
		$query 		= $this->pdo_con->prepare($sql);
		$this->bindAllParams($query, $params);
		$result 	= $query->execute();	

		if($this->debug) pr($query) . PHP_EOL . '<br />' . PHP_EOL;
		
		return $query->fetchAll(PDO::FETCH_OBJ);
	}

	public function queryOne($sql = false, $params = [], $return = false) {
		$query 		= $this->pdo_con->prepare($sql);
		$this->bindAllParams($query, $params);
		$result 	= $query->execute();	

		if($this->debug) pr($query) . PHP_EOL . '<br />' . PHP_EOL;

		return $query->fetch(PDO::FETCH_OBJ);
	}

	public function update($table = false, $data = false, $where = false) {

		$query_data = [];

		$where 	= $this->parseWhere($where, $query_data);

		foreach ($data as $key => $value) {
			$query_data[':u_'.$key] 	= $value;
			$update_fields[] 			= $key . ' = :u_' . $key;
		}

		$update_fields = implode(',', array_values($update_fields));

		return db::send('UPDATE '.$table.' SET '.$update_fields.' '.$where.' ;', $query_data);
	}


	public function bindAllParams(&$query, &$params) {
		if ($params) {
			foreach ($params as $key => $value) {
				if (is_int($value)) {
					$query->bindValue($key, $value, PDO::PARAM_INT);
				} else {
					$query->bindValue($key, $value);
				}
			}
		}
	}


	public function send($sql = false, $params = []) {
		$query 		= $this->pdo_con->prepare($sql);
		$this->bindAllParams($query, $params);
		if($this->debug) pr($query) . PHP_EOL . '<br /><pre>' . PHP_EOL;
		return $query->execute();
	}

	/* PDO functions */

	private function parseWhere($where = false, &$data = []){

		if (is_array($where)){

			if (isset($where['page'])) unset($where['page']);
			if (isset($where['limit'])) unset($where['limit']);
			if (empty($where)) return '';

			foreach ($where as $key => $item) {
				$data[':w_'.$key] = $item;
				$wheres[] = ''.$key.' = :w_'.$key;
			}

			return 'WHERE ' . implode(' AND ', $wheres);
		} else if ($where) {
			return 'WHERE ' . $where;	
		}

		return '';
	}

	private function parseFrom(&$from){
		if (is_array($from)){
			foreach ($from as $key => $value)
				$return[] = $value;
			return implode('JOIN ', $return);
		} else
		return $from;
	}

	private function parseWhat(&$what = '*'){
		if (is_array($what)){
			foreach ($what as $key => $value)
				$return[] = $value;
			return implode(', ', $return);
		} else
		return $what;
	}

	public function select($table = false, $what = false, $where = false, $limit = false, $order = false){

		if (is_array($where)){
			$page = (isset($where['page'])) ? (($where['page'] - 1) * $limit) : 0;
		} else $page = 0;

		$query_data = [];

		$what 	= db::parseWhat($what);
		$table 	= db::parseFrom($table);
		$where 	= db::parseWhere($where, $query_data);

		if ($order) {
			$where .= ' ORDER BY '. $order;
		}

		if ($limit == 1)
			return db::queryOne('SELECT '.$what.' FROM '.$table.' '.$where.' LIMIT 1;', $query_data);
		else if ($limit > 1)
			return db::query('SELECT '.$what.' FROM '.$table.' '.$where.' LIMIT '.$page.','.$limit.';', $query_data);
		else
			return db::query('SELECT '.$what.' FROM '.$table.' '.$where.';', $query_data);
	}



	public function insert($table = false, $data = false) {
		if ($data && $table) {

			$fields = array_keys($data);

			foreach ($data as $key => $item) {
				$values[':'.$key] = $item;
			}

			$fields = implode(',', array_keys($data));
			$names = implode(',', array_keys($values));

			return db::send('INSERT INTO `'.$table.'` ('.$fields.') VALUES ('.$names.') ', $values);
		}
		return false;
	}


	public function delete($table = false, $where = false, $limit = false){
		if(isset($where['limit'])) $limit = $where['limit'];
		$limit = ($limit) ? 'LIMIT '.$limit : '';
		$query_data = [];
		$wheres = db::parseWhere($where, $query_data);
		return db::send('DELETE FROM `'.$table.'` '.$wheres.' '.$limit.';', $query_data);
	}

	

	public function count($table = false, $where = false){
		$query_data = [];
		$where = db::parseWhere($where, $query_data);
		return db::queryOne('SELECT COUNT(*) as total FROM `'.$table.'` '.$where.';', $query_data)->total;
	}

	

	public function last($table = false){
		return db::queryOne('SELECT MAX(id) as last FROM `'.$table.'`')->last;
	}


	public function lastRow($table = false, $what = "id"){
		return db::queryOne('SELECT * FROM `'.$table.'` ORDER BY `'.$what.'` DESC LIMIT 1 ');
	}


	public function alreadyExists($table = false, $where = false) {

		$table 	= db::parseFrom($table);
		$where 	= db::parseWhere($where);

		$return = db::queryOne('SELECT id FROM `'.$table.'` '.$where.' LIMIT 1;');	
		return ($return) ? true : false;

	}



}