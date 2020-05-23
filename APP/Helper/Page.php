<?php 

Class Page {

	public function infos($url) {

		if (! strstr($url, 'http')) {
			$url = 'http://'.$url;
		}

		if (filter_var($url, FILTER_VALIDATE_URL, true)) {

			$site = call('Helper/Curl')->download($url);
			$title_area = explode('</title>', $site);

			// obtém título da página
			preg_match('/<title>(\n)?[\w\W]+/', $title_area[0], $title);
			
			$title = strip_tags(@$title[0]);
			$title = trim($title);
			$title = str_replace($this->useless_title, '', $title);
			$title = substr($title, 0, 120);
			
	        // Verifica pela presença de og:image
			if (strstr($site, 'og:image')) {
				preg_match_all('/og:image\"( id="[\/A-z\.0-9\-=\:\~\-&áéíóúâêîôûãõÁÉÍÓÚÂÊÎÔÛÃÕ?]+")? content=\"[\/A-z\.0-9\-=\{\}\:\~\-&áéíóúâêîôûãõÁÉÍÓÚÂÊÎÔÛÃÕ?]+"/', $site, $og_image);

				$og_image =	explode('content="', $og_image[0][0]);
				$og_image = $og_image[1];
				$og_image = str_replace("\"", "", $og_image);
			} else {
				$og_image = false;
			}

			return ['title' => $title, 'url' => $og_image];
		} else {
			return false;
		}
	}

}