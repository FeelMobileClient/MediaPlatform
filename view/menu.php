<?php
/************************************************
 * menu.php
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include '../constants.config.php';
include '../class/WechatCallbackApi.class.php';
include '../class/WechatAuthorize.class.php';

$wechatAuthorizeObj = new WechatAuthorize();

$postEntity = '{
	"button":[
	{
		"type":"view",
		"name":"博客",
		"url":"http://www.libenkuo.com/blog/public"
	},
	{
		"type":"view",
		"name":"我的信息",
		"url":"'.$wechatAuthorizeObj->getCodeUrl('http://www.libenkuo.com/WeixinMpPHP/view/user_info.php','snsapi_base').'"
	}]
 }';

$wechatCallbackApiObj = new WechatCallbackApi();
$wechatCallbackApiObj->createMenu($postEntity);
?>
