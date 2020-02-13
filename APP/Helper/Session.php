<?php
class Session {

	public function set($name, $value){ $_SESSION[$name] = $value; }

	public function get($name, $or = false){ return (isset($_SESSION[$name])) ? $_SESSION[$name] : $or; }

	public function getAll(){ return $_SESSION; }

	public function remove($name){ unset($_SESSION[$name]); }

	public function removeAll(){ session_destroy(); }

	public function getUserInfo() {
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 

		if (preg_match('/linux/i', $u_agent)) {
		    $platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		    $platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
		    $platform = 'windows';
		} else {
			$platform = '';
		}
	   
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
	        return $platform.'_iexplore'; 
	    } elseif(preg_match('/Firefox/i',$u_agent)) { 
	        return $platform.'_firefox'; 
	    } elseif(preg_match('/Chrome/i',$u_agent)) { 
	        return $platform.'_chrome'; 
	    } elseif(preg_match('/Safari/i',$u_agent)) { 
	        return $platform.'_safari'; 
	    } elseif(preg_match('/Opera/i',$u_agent)) { 
	        return $platform.'_opera'; 
	    } elseif(preg_match('/Netscape/i',$u_agent)) { 
	        return $platform.'_netscape'; 
	    } else {
	    	return $platform.'_';
	    }
	}

	// TODO: efetua troca dos dados de acesso
	public function checkForPersistence() {

		if ((isset($_COOKIE['uh'])) && (isset($_COOKIE['ui'])) && (is_numeric($_COOKIE['ui']))) {
		
			$hash = $_COOKIE['uh'];

			if (base64_decode($hash, true) === false) {
			    return false;
			}

			// obtém o cookie
			$data = array(
				'p.user_id' => $_COOKIE['ui'],
				'login_hash' => $hash,
				'login_ambient' => $this->getUserInfo()
			);

			// verifica na base de dados
			$user = call('Model/ModelUser')->getPersistentLoginUser($data);

			if ($user) {
				session_regenerate_id(true);

				// aplica session do user
				Session()->set('id', $user[0]->user_id);
				Session()->set('name', $user[0]->user_name);
				Session()->set('sobrenome', $user[0]->sobrenomeUsuario);
				Session()->set('email', $user[0]->emailUsuario);
				Session()->set('type', $user[0]->user_type);
				

				if ($user[0]->user_photo == "") {
					Session()->set('flag', 'update_photo');
				}

				// adiciona ao log
				call('Model/ModelLog')->new_login(array('user_id' => $user[0]->user_id, 'login_client' => 1, 'login_method' => 100));

				return true;
			} 
		} 
		
		return false;
	}

	public function checkForBan($method, $user_id) {
		$user_status = call('Model/ModelUser')->getUserStatus($user_id);
		if ($user_status->user_type == 0) {
			$this->removeAll();
			$this->checkReturn($method, 'user');
		}
	}

	public function checkLogged($method = 'json', $checkForBan = false) {
		$uid = $this->get('id');
		// Se não está logado e não recuperou sessão ativa
		if (! is_numeric($uid)) {
			if (! $this->checkForPersistence()) {
				if ($method) {
					$this->checkReturn($method);	
				}
			} else {
				if ($checkForBan) {
					$this->checkForBan($method, $uid);
				}
			}	
		}
	}

	private function checkReturn($method, $error = 'login') {
		if ($method == 'json') {
			echo json_encode(array('success' => 'false', 'error' => $error)); die;
		} else {
			redirect($method);
		} 
	}

}