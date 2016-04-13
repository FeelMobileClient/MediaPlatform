<?php
/************************************************
 * WechatCallbackApi
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'AutoResponder.class.php';
include 'IChing.class.php';

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
		return $resultObj->access_token;
	}

	public function responseMsg() {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if(empty($postStr)) {
			
			echo "POST entity is empty!";
			exit;

		} else {
			/** libxml_disable_entity_loader
			 * is to prevent XML external Entity Injection,
			 * the best way is
			 * to check the validity of xml by yourself
			 */
			libxml_disable_entity_loader(true);

			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUserName = $postObj->FromUserName;
			$toUserName = $postObj->ToUserName;
			$msgType = $postObj->MsgType;

			switch($msgType) {
				case 'text':
					$content = trim($postObj->Content);
					$this->textHandle($toUserName, $fromUserName, $content);
					break;
				case 'image':
					break;
				case 'voice':
					break;
				case 'video':
					break;
				case 'shortvideo':
					break;
				case 'location':
					break;
				case 'link':
					break;
				case 'event':
					$this->eventHandle($toUserName, $fromUserName, $postObj->Event);
					break;
				default:
					echo "Input something...";
			}
		}
	}
	
	public function templateSend($postTemplateEntity) {

		$accessToken = $this->getToken();
		$urlTemplateSend = WECHAT_CGI_BIN.'message/template/send?access_token='.$accessToken;

		$cURLTemplateSend = curl_init($urlTemplateSend);

		curl_setopt($cURLTemplateSend, CURLOPT_POST, true);
		curl_setopt($cURLTemplateSend, CURLOPT_POSTFIELDS, $postTemplateEntity);

		curl_exec($cURLTemplateSend);

		curl_close($cURLTemplateSend);
	}

	public function createMenu($postMenuEntity) {
		$accessToken = $this->getToken();
		$urlCreateMenu = WECHAT_CGI_BIN.'menu/create?access_token='.$accessToken;

		$cURLCreateMenu = curl_init($urlCreateMenu);

		curl_setopt($cURLCreateMenu, CURLOPT_POST, true);
		curl_setopt($cURLCreateMenu, CURLOPT_POSTFIELDS, $postMenuEntity);

		curl_exec($cURLCreateMenu);

		curl_close($cURLCreateMenu);
	}

	public function makeMsg($fromUserName, $toUserName, $msgType, $message) {
		$time = time();
		$textTemplate = "<xml>
				<ToUserName>%s</ToUserName>
				<FromUserName>%s</FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType>%s</MsgType>
				<Content>%s</Content>
				<FuncFlag>0</FuncFlag>
				</xml>
				";
		$resultStr = sprintf($textTemplate, $toUserName, $fromUserName, $time, $msgType, $message);
		return $resultStr;
	}

	public function textHandle($toUserName, $fromUserName, $content) {
		
		$randNo = rand(0, 1);

		$message = null;
		switch($randNo) {
			case 0:
				$autoResponder = new AutoResponder();
				$message = $autoResponder->getResponse();
				break;
			case 1:
				$iChing = new IChing();
				$message = $iChing->getHexagram();
				break;
			default:
				
		}

		echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
	}

	public function eventHandle($toUserName, $fromUserName, $event) {

		$message = null;		

		switch($event) {
			case 'subscribe':
				$message = '相遇即是有缘，在众多公众号里，你选中了我，我吸引了你。';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
				break;
			case 'unsubscribe':
				$message = '可不可以，你也会想起我！';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
				break;
			default:
				$message = '呃， 我不知道你对我做了什么！';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);

		}		
	}
	
}
?>
