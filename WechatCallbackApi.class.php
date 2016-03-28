<?php
/************************************************
 * WechatCallbackApi
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

define('TOKEN', 'test');

class WechatCallbackApi {

	function __construct() {

	}

	public function valid() {

		$echoStr = $_GET['echostr'];
		
		if($this->checkSignature()) {
			echo $echoStr;
			exit;
		}
	}
	
	public function checkSignature() {

		if(!defined("TOKEN")) {
			throw new Exception("TOKEN is not defined!");
		}

		$signature = $_GET['signature'];
		$timestamp = $_GET['timestamp'];
		$nonce = $_GET['nonce'];

		$token = TOKEN;

		$tmpArray = array($token, $timestamp, $nonce);
		
		sort($tmpArray, SORT_STRING);
		$tmpString = implode($tmpArray);
		$tmpString = sha1($tmpString);

		if($tmpString == $signature) {
			return true;
		} else {
			return false;
		}
	}
}
?>
