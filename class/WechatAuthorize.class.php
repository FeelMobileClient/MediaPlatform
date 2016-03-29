<?php
/************************************************
 * WechatAuthorize
 * Created by Liyang on 2016-03-29
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

class WechatAuthorize {
	
	function __construct() {

	}

	public function getCodeUrl($redirectUrl, $scope) {

		$codeUrl = WECHAT_AUTHORIZE_URL.'authorize?appid='.APPID.'&redirect_uri='.urlencode($redirectUrl).'&response_type=code&scope='.$scope.'&state=LIBENKUO#wechat_redirect';

		return $codeUrl;
	}

	public function getAccessToken($code) {
		$accessTokenUrl = WECHAT_AUTHORIZE_URL.'access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		return $accessTokenUrl;
		$cURLGetToken = curl_init($accessTokenUrl);
		curl_exec($cURLGetToken);
	}
}
?>
