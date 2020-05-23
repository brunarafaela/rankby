<?php

Class Curl {

	public function download($url) {

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if(curl_errno($ch)){
			echo 'Curl error: ' . curl_error($ch);
		}

		$site = curl_exec($ch);
        curl_close($ch);

        return $site;

	}

}
