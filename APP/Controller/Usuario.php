<?php
Class usuario{
	
	private $actions = [
		'error' 		=> ['error', 'Erro ao alterar senha, preencha os campos'],
		'equal' 		=> ['error', 'A nova senha deve ser diferente da atual'],
		'wrong' 		=> ['error', 'Senha digitada inválida.'],
		'pass_changed' 	=> ['success', 'Senha alterada com sucesso!'],
		'data_changed' 	=> ['success', 'Dados alterados com sucesso!'],
	];
	
	public function login($error = false) {
		$return['result'] = $error;
		includePage('TelaLogin', 'Usuario', $return);	
	}	

	public function logout() {
		Session()->removeAll();
		$this->login();
	}
	
	public function erro($error = true) {
		$return['result'] = $error;
		includePage('erro', 'Usuario', $return);	
	}
	
	public function cadastrar(){
		includePage('TelaCadastrarUsuario', false);
	}

	public function preferencias($action) {

		if ($action) {
			$data['result'][$this->actions[$action][0]] = $this->actions[$action][1];
		}

		includePage('TelaPerfilUsuario', 'Usuario', $data);
	}
	
	public function alterar_senha($action) {

		if ($action) {
			$data['result'][$this->actions[$action][0]] = $this->actions[$action][1];
		}

		includePage('TelaAtualizaSenha', 'Usuario', $data);
	}
	
	public function cadastro_submit(){
		
		$data = params(['req' => ['nomeRegister|nomeUsuario', 
			'sobrenomeRegister|sobrenomeUsuario',
			'passRegister|senhaUsuario',
			'emailRegister|emailUsuario'], false, false], false);
		
       // Recebeu os parametros
		if (isset($data['senhaUsuario'])) {
			
            // Consulta usuário e senha na base de dados
			$user = call('Model/ModelUser')->get_by(["emailUsuario" => $data["emailUsuario"]]);
			
			if($user) {
				return $this->erro(['error' => 'Email já cadastrado']);
			}
			
			$data['senhaUsuario'] 	  = call('Helper/Hash')->encode($data['senhaUsuario']);
			
              // Cadastra usuário na base de dados
			if ($data) {
				$user = call('Model/ModelUser')->create($data);
                    redirect('/usuario/login'); // Redireciona para a página de login 
                } 
            } else {
            	$this->erro(['error' => 'Email já cadastrado']);
            	
            }
        }
        
        
        public function alterarsenha() {
        	
        	$data = params(['req' => [
        		'passRegister|senhaUsuario',
        	]], false, [
        		'idUsuario' => Session()->get('aid')  
        	]);
        	
        	if ($data) {
        		
        		$data['senhaUsuario'] = call('Helper/Hash')->encode($data['senhaUsuario']);
        		
        		call('Model/ModelUser')->edit_user($data, ['idUsuario' => $data['idUsuario']]);
        		return $this->alterar_senha('pass_changed');
        		
        	}
        }
        

        public function loginsubmit(){
        	$user = params(array('req' => array('emailLogar|emailUsuario', 'passLogar|senhaUsuario')));
        	$redirect = postData('redirect', false);

		// Recebeu os parametros
        	if ($user) {

            // Efetua hash da senha do usuário
        		$user['senhaUsuario'] = call('Helper/Hash')->encode($user['senhaUsuario']);
        		
        		
			// Consulta usuário e senha na base de dados
        		$user = call('Model/ModelUser')->get_by($user);

        		if ($user) {
			   	// Encontrou: Cria session para autenticação do usuário
        			Session()->set('aid', $user->idUsuario);
        			Session()->set('nome', $user->nomeUsuario);
        			Session()->set('sobrenome', $user->sobrenomeUsuario);
        			Session()->set('email', $user->emailUsuario);
				// Retorno	
        			redirect('/Dashboard/index/');		
        			
        		} else {
				// Redirect
        			$this->login(['error' => 'Usuário ou senha incorretos.']);
        		}

        	} else {
        		$this->login(['error' => 'Preencha os campos usuário e senha.']);
        	}
        }
        
        public function editar_perfil() {
        	
        	$data = params(['req' => [
        		'nomeUpdate|nomeUsuario',
        		'sobrenomeUpdate|sobrenomeUsuario',
        		'emailUpdate|emailUsuario',
        	]], false, [
        		'idUsuario' => Session()->get('aid')  
        	]);
        	
        	if ($data) {
        		
        		call('Model/ModelUser')->edit_user($data, ['idUsuario' => $data['idUsuario']]);
        		return $this->preferencias('data_changed');
        	}
        	
        }
    }
