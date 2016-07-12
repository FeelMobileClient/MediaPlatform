<?php
/************************************************
 * WechatCallbackApi
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'AutoResponder.class.php';
include 'IChing.class.php';
include 'HttpTools.class.php';

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

	// 用户同意授权，获取 CODE
	public function getCodeUrl($redirectUrl, $scope) {

		$codeUrl = WECHAT_OPEN.'connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.urlencode($redirectUrl).'&response_type=code&scope='.$scope.'&state=LIBENKUO#wechat_redirect';
		return $codeUrl;
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
					$this->eventHandle($toUserName, $fromUserName, $postObj);
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
		
		$message = null;
		switch($content) {
			case '来碗鸡汤':
				$autoResponder = new AutoResponder();
				$message = $autoResponder->getResponse();
				break;
			case '问卦':
				$iChing = new IChing();
				$message = $iChing->getHexagram();
				break;
			default:
				
		}
		if($message != null) {
			echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
		}
	}

	public function eventHandle($toUserName, $fromUserName, $postObj) {

		$message = null;		

		switch($postObj->Event) {
			case 'subscribe':
				$message = '嗨！是你呀！';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
				break;
			case 'unsubscribe':
				$message = '可不可以，你也会想起我！';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);
				break;
			case 'SCAN':
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $postObj->EventKey);
				break;
			case 'CLICK':
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $postObj->EventKey);
				break;
			default:
				$message = '呃， 我不知道你对我做了什么！';
				echo $this->makeMsg($toUserName, $fromUserName, 'text', $message);

		}		
	}

	// 生成带参数的二维码
	public function qrcodeCreate($codeType, $sceneId, $sceneStr) {

		$createUrl = WECHAT_CGI_BIN.'qrcode/create?access_token='.$this->getToken();
		$httpTool = new HttpTools();

		switch($codeType) {
			case 'TEMP':
				$postData = '{
						"expire_seconds":604800,
						"action_name":"QR_SCENE",
						"action_info":{
							"scene":{
								"scene_id":"123"
							}
						}
					}';
				 return $httpTool->post($createUrl, $postData);
				break;
			case 'QR_LIMIT':
				break;
			default:
		}
	}

	// 通过ticket换取二维码
	public function qrcodeShow($ticket) {

	}
}
?>
