
<?php
/************************************************
 * WechatJSSDK
 * Created by Liyang on 2016-03-31
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'FileTools.class.php';
include 'HttpTools.class.php';

class WechatJSSDK {
	
	private $appId;
	private $appSecret;

	function __construct($appId, $appSecret) {
		$this->appId = $appId;
		$this->appSecret =$appSecret;
	}

	public function getSignPackage() {
		$jsApiTicket = $this->getJsApiTicket();

		// URL 一定要动态获取，不能 hard code 。
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		$signatureString = "jsapi_ticket=$jsApiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		$signature = sha1($signatureString);

		$signPackage = array(
			"appId"		=> $this->appId,
			"nonceStr"	=> $nonceStr,
			"timestamp"	=> $timestamp,
			"url"		=> $url,
			"signature"	=> $signature,
			"rawString"	=> $signatureString
		);

		return $signPackage;
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789";
		$str = "";

		for ($index = 0; $index < $length; $index++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}

		return $str;
	}

	private function getJsApiTicket() {
		
		$fileTools = new FileTools();
		$httpTools = new HttpTools();

		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode($fileTools->getPhpFile("jsapi_ticket.php"));

		if($data->expire_time < time()) {
			$accessToken = $this->getAccessToken();

			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
			$res = json_decode($httpTools->get($url));
			
			$ticket = $res->ticket;

			if($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				$fileTools->setPhpFile("jsapi_ticket.php", json_encode($data));
			}
		} else {
			$ticket = $data->jsapi_ticket;
		}

		return $ticket;
	}

	private function getAccessToken() {

		$fileTools = new FileTools();
		$httpTools = new HttpTools();

		$data = json_decode($fileTools->getPhpFile("access_token.php"));

		if ($data->expire_time < time()) {

			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode($httpTools->get($url));
			$access_token = $res->access_token;

			if ($access_token) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				$fileTools->setPhpFile("access_token.php", json_encode($data));
			}
		} else {
			$access_token = $data->access_token;
		}

		return $access_token;
	}
}
?>
