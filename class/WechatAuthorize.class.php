<?php
/************************************************
 * WechatAuthorize
 * Created by Liyang on 2016-03-29
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'HttpTools.class.php';

class WechatAuthorize {
	
	private $httpTool;

	function __construct() {
		$this->httpTool = new HttpTools();
	}

	// 用户同意授权，获取 CODE
	public function getCodeUrl($redirectUrl, $scope) {

		$codeUrl = WECHAT_OPEN.'connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.urlencode($redirectUrl).'&response_type=code&scope='.$scope.'&state=LIBENKUO#wechat_redirect';
		return $codeUrl;
	}

	// 通过 CODE 换取网页授权 access_token
	public function getJsonObwithToken($code) {
		$accessTokenUrl = WECHAT_API.'sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		//return $accessTokenUrl;
		$res = json_decode($this->httpTool->get($accessTokenUrl));
		return $res;
	}

	// 拉取用户信息
	public function getUserInfo($accessToken, $openId) {
		$userInfoUrl = WECHAT_API.'sns/userinfo?access_token='.$accessToken.'&openid='.$openId.'&lang=zh_CN';
		$res = json_decode($this->httpTool->get($userInfoUrl));
		return $res;
	}
}
?>
