<?php
/************************************************
 * HttpTools
 * Created by Liyang on 2016-03-31
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

class HttpTools {
	
	function __construct() {

	}

	public function get($url) {

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_URL, $url);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	}
}
?>
