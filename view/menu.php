<?php
/************************************************
 * menu.php
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include '../constants.config.php';
include '../class/WechatCallbackApi.class.php';


// click
// view
// scancode_push
// scancode_waitmsg
// pic_sysphoto
// pic_photo_or_album
// pic_weixin
// location_select
// media_id
// view_limited

$wechatCallbackApiObj = new WechatCallbackApi();

$postEntity = '{
	"button":[
	{
		"type":"view",
		"name":"博客",
		"url":"http://www.libenkuo.com/blog/public"
	},
	{
		"name":"发图",
		"sub_button":[
		{
			"type":"pic_sysphoto",
			"name":"系统拍照发图",
			"key":"reselfmenu_1_0",
			"sub_button":[]
		},
		{
			"type":"pic_photo_or_album",
			"name":"拍照或相册发图",
			"key":"reselfmenu_1_1",
			"sub_button":[]
		},
		{
			"type":"pic_weixin",
			"name":"微信相册发图",
			"key":"reselfmenu_1_2",
			"sub_button":[]
		}
		]
	},
	{
		"name":"菜单事件",
		"sub_button":[
		{
			"type":"scancode_push",
			"name":"扫码推事件",
			"key":"reselfmenu_0_0",
			"sub_button":[]
		},
		{
			"type":"scancode_waitmsg",
			"name":"扫码带提示",
			"key":"reselfmenu_0_0",
			"sub_button":[]
		},
		{
			"type":"click",
			"name":"赞",
			"key":"PRAISE"
		},
		{
			"type":"view",
			"name":"我的信息",
			"url":"'.$wechatCallbackApiObj->getCodeUrl('http://www.libenkuo.com/WeixinMpPHP/view/user_info.php','snsapi_userinfo').'"
		}
		]
	}
	]
 }';

$wechatCallbackApiObj = new WechatCallbackApi();
$wechatCallbackApiObj->createMenu($postEntity);
?>
