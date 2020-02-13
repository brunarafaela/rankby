<?php
Class Canal{
    public function cadastrar(){
			includePage('TelaCadastrarCanal', false);
	}
	
    public function seguindo(){
        //Exibe lista de canais seguidos de acordo com o id do usuário pego pela variável de sessão
        $data = call('Model/ModelFollowing')->getFollowing(Session()->get('aid'));
		includePage('TelaCanaisSeguidos', false, $data);
	}
	
	
	 public function ranking(){
	     //Exibe ranking de canais
	     $ranking = getData("ordem") ?: "seguidores";
	     $pais    = getData("pais");
	     $page    = getData("page", 1);
	     $categoria = getData("categoria");
	        
	     if($ranking == "seguidores") {
	         $data['canais'] = call("Model/ModelChannel")->lista(10, "canalInscritos", $pais, $categoria, $page);     
	     } else {
	         $data['canais'] = call("Model/ModelChannel")->lista(10, "canalMediaVisualizacoes", $pais, $categoria, $page);
	     }
	     
	     $data['count']     = call("Model/ModelChannel")->count_lista($pais, $categoria);
	     $data['paginator'] = call('Helper/Paginator')->go($page, $data['count']->total, "/canal/ranking/pais/".$pais."/categoria/".$categoria."/page/", 10);
	     
	     $data['paises'] = call("Model/ModelCountry")->getList();
	     $data['categorias'] = call("Model/ModelCategory")->getCategories();
	     
	     $data['form_pais'] = $pais;
	     $data['form_categoria'] = $categoria;
	    
		includePage('TelaRankingCanais', false, $data);
	}
	
	public function pesquisar(){
	    //Barra de pesquisa de acordo com o campo digitado (percorre toda a tabela até achar)
	    $busca = getData("busca");
	    
	    if ($busca) {
	        
	        $data = call("Model/ModelChannel")->search($busca);
	        
			includePage('TelaPesquisarCanal', false, $data);
	        
	    } else {
	        
	        includePage('404', 'Shared', $data);
	        
	    }
	    
	}
	
	public function follow() {
	    
	    $data = params(['req' => ['idCanal']], false, ['idUsuario' => Session()->get('aid')]);
	    
	    if ($data) {
	        
	        
	        if(! call('Model/ModelFollowing')->is_following($data)) {
	            call('Model/ModelFollowing')->follow($data);
	            echo json_encode(["success" => true]);
	        } else {
	            echo json_encode(["success" => false, "error" => "Já está seguindo."]);
	        }
	        
	    } else {
	        echo json_encode(["success" => false, "error" => "Dados inválidos."]);
	    }
	    
	}
	
	public function unfollow() {
	    //Deixa de seguir um canal
	    $data = params(['req' => ['idCanal']], false, ['idUsuario' => Session()->get('aid')]);
	    
	    if ($data) {
	        
	        //Verifica se está seguindo
	        if(call('Model/ModelFollowing')->is_following($data)) {
	            call('Model/ModelFollowing')->unfollow($data);
	            echo json_encode(["success" => true]);
	        } else {
	            echo json_encode(["success" => false, "error" => "Não está seguindo."]);
	        }
	        
	    } else {
	        echo json_encode(["success" => false, "error" => "Dados inválidos."]);
	    }
	    
	}
	
	public function ver() {
	    //Exibe um canal
	    $youtuber = str_replace("_", "-", getData('ver'));
	    
	    if ($youtuber) {
	        
	        $data = call('Model/ModelChannel')->get_by(['canalUsername' => $youtuber]);
	        
	        if (! $data) {
	           return includePage('404', 'Shared', $data);
	        }
	        
	        $data->following = call('Model/ModelFollowing')->is_following(["idCanal" => $data->idCanal, "idUsuario" => Session()->get('aid')]);
	        
	        $categories = call('Model/ModelCategory')->getChannelCategories($data->idCanal);
	        
	        // ranking global do youtuber
	        $data->ranking_global = call('Model/ModelChannel')->get_global_ranking($data->canalInscritos)->ranking;
	        
	        // ranking local do youtuber
	        $data->ranking_local  = call('Model/ModelChannel')->get_country_ranking($data->canalInscritos, $data->paisId)->ranking;
	        
	        foreach($categories as $category) {
	            $data->categories[] = $category->categoriaNome;
	        }
	        
	       // pr($data);die;
	   
	        includePage('TelaExibirCanal', false, $data);
	        // mostra perfil
	        
	    } else {
	       includePage('404', 'Shared', $data);
	    }
	    
	}

    //Cadastra canais		
    public function cadastro_submit($data, $categories){
        if ($data) {
            $chanel = call('Model/ModelChannel')->create($data);
            $data = (object) $data;
            $data->idCanal = $chanel->idCanal;
            
            //Cadastra informando que o usuário ainda não segue o canal
            $data->following = false;
            
            //Inserir ou pegar categorias e atribuir ao canal
            foreach($categories as $category) {
                
                //Cadastra categorias
                $category_id = call('Model/ModelCategory')->createOrReturn($category);
                call('Model/ModelCategory')->addChannelCategory(['categoriaId' => $category_id, 'idCanal' => $data->idCanal]);
                
            }
            
            //Passa categorias
            $data->categories = $categories;
            
            //Exibe canal
            
            Redirect('http://app.rankby.online/canal/ver/'.$data->canalUsername);
        } 
    }
    	
    public function erro($error = true) {
    	$return['result'] = $error;
    	includePage('TelaCadastrarCanal', 'Canal', $return);	
    }
    
    //Consulta Google API para cadastrar canal//Baixa a página que trará o json
    public function crawl() {
        
        $channel_url 	= postData('urlRegister');
        
        //Url foi enviada por post
        if(! $channel_url) {
            //Valida se tem url informada
            $this->erro(['error' => 'Insira uma url válida']);
	        return;
        }
        
        //Trata a url inserida
        if(strstr($channel_url, "?")) {
            $temp_url = explode("?", $channel_url);
            $channel_url = $temp_url[0];
        }
        
        //Url é uma url válida do youtube
        if((!strstr($channel_url, "https://www.youtube.com/channel/")) &&
          (!strstr($channel_url, "https://www.youtube.com/user/"))) {
            $this->erro(['error' => 'Insira uma url válida']);
	        return;
        }
        
        //Pega id ou username do usuário
        $url = explode("/", $channel_url);
	    $channel = $url[4];
        
        //Verifica se o canal já foi cadastrado
		$chanel_exists = call('Model/ModelChannel')->channelExists(['canalUsername' => $channel]);
	    if ($chanel_exists){
	        $this->erro(['error' => 'Canal já cadastrado, por favor, realize uma pesquisa']);
	        return;
    	}
    	
    		$chanel_exists = call('Model/ModelChannel')->channelExists(['canalId' => $channel]);
	    if ($chanel_exists){
	        $this->erro(['error' => 'Canal já cadastrado, por favor, realize uma pesquisa']);
	        return;
    	}
	    
	    // Busca por username
        $api_url = "https://www.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics%2CtopicDetails%2Cstatus&forUsername=".$channel."&quotaUser=111&key=AIzaSyC7GKXWVuzFEesHfUBYoynOecqIsfVxZp0";
        $api_request = call('Helper/Curl')->download($api_url);
        
        //Não achando, busca pelo channelID
        if(strstr($api_request, "\"totalResults\": 0,")) {
            $api_url = "https://www.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics%2CtopicDetails%2Cstatus&id=".$channel."&quotaUser=111&key=AIzaSyC7GKXWVuzFEesHfUBYoynOecqIsfVxZp0";
            $api_request = call('Helper/Curl')->download($api_url); 
            
            if(strstr($api_request, "\"totalResults\": 0,")){
		    	$this->erro(['error' => 'Canal não existe']);
			    return;
	    	}   
        }
        
        //Extrai o json
        $api_result = json_decode($api_request);
        
        if(! @$api_result->items[0]->snippet->customUrl) {
            $api_result->items[0]->snippet->customUrl = $api_result->items[0]->id;
        }
        
        //Verifica se o canal já está no banco
        $chanel_exists = call('Model/ModelChannel')->channelExists(['canalId' => $api_result->items[0]->snippet->customUrl]);
	    if ($chanel_exists){
	        $this->erro(['error' => 'Canal já cadastrado, por favor, realize uma pesquisa']);
	        return;
    	}
    	
    	//Verifica a quantidade de inscritos
    	if($api_result->items[0]->statistics->subscriberCount == 0 ) {
            $this->erro(['error' => 'O canal não fornece a quantidade de inscritos, por isso não pode ser cadastrado.']);
	        return;
        }
        
        if($api_result->items[0]->statistics->subscriberCount <= 5000) {
            $this->erro(['error' => 'O canal não possui inscritos o suficiente.']);
	        return;
        }
        
        
        //Verifica a quantidade de vídeos
        if($api_result->items[0]->statistics->videoCount == 0) {
            $this->erro(['error' => 'O canal não possui vídeos, por isso não pode ser cadastrado.']);
	        return;
        }
        
         //Verifica a quantidade de visualizações
        if($api_result->items[0]->statistics->viewCount == 0) {
            $this->erro(['error' => 'O canal não possui visualizações, por isso não pode ser cadastrado.']);
	        return;
        }
        
        //Cria um array de categorias
        $categories = [];
        
        //Trata as categorias, ignorando a URL
        foreach($api_result->items[0]->topicDetails->topicCategories as $category) {
            $categories[] = str_replace(["https://en.wikipedia.org/wiki/", "_"], ["", " "], $category);
        }
        
        //Pega dados do json
        $data = [
			'canalInscritos' 	          => $api_result->items[0]->statistics->subscriberCount,
			'canalVisualizacoes'          => $api_result->items[0]->statistics->viewCount,
			'canalVideos'		          => $api_result->items[0]->statistics->videoCount,
			'canalAvatar'		          => $api_result->items[0]->snippet->thumbnails->medium->url,
			'canalNome'	     	          => $api_result->items[0]->snippet->title,
			'canalURL'	    	          => "https://www.youtube.com/channel/" . $api_result->items[0]->id,
			'canalUsername'               => $api_result->items[0]->snippet->customUrl,
			'canalCriacao'                => $api_result->items[0]->snippet->publishedAt,
	    	'paisId'                       => @$api_result->items[0]->snippet->country ?: "SP",
			'canalDescricao'                 => $api_result->items[0]->snippet->description,
			'canalPlaylistEnvios'           => $api_result->items[0]->contentDetails->relatedPlaylists->uploads,
			'canalId'                       => $api_result->items[0]->id,
			'canalMediaVisualizacoes'       => ceil($api_result->items[0]->statistics->viewCount / $api_result->items[0]->statistics->videoCount),
		];
		
		//Passa o canal e categorias para o cadastro
		$this->cadastro_submit($data, $categories);
    }

}
