<?php
/************************************************
 * WechatCallbackApi
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

define('TOKEN', 'test');
define('WECHAT_CGI_BIN', 'https://api.weixin.qq.com/cgi-bin/');
define('APPID', 'wxc5a8924b13639848');
define('APPSECRET', 'b8f5468fa01c680feb030a13bc46efa1');

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

	public function getToken() {
		$urlGetToken = WECHAT_CGI_BIN.'token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;
		$resultStr = file_get_contents($urlGetToken);
		$resultObj = json_decode($resultStr);
		echo $resultObj->access_token;
		exit;
	}
}
?>
