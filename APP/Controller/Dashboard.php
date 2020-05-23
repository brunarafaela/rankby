<?php 

class Dashboard {

	public function __construct() {
		if (! is_numeric(Session()->get('aid'))) {
			redirect('/Index/home/');
		}
	}

	public function index() {
		$this->welcome();
	}

	public function welcome() {
		
		$data['paises']     = call("Model/ModelCountry")->getList();
		$data['categorias_list'] = call("Model/ModelCategory")->getCategories();
		
		$data['canais']     = call("Model/ModelChannel")->get_count();
		$data['count_pais'] = call("Model/ModelChannel")->get_country_count();
		$data['categorias'] = call("Model/ModelCategory")->get_count();
		
		$data['top_canais'] = call("Model/ModelChannel")->lista(5, 'canalInscritos');
        // $data['seguindo_count'] = call ("Model/ModelFollowing")->get_following_count();
       
		includePage('TelaIndex', 'Dashboard', $data);
	}

}