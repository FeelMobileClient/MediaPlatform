<?php
/************************************************
 * template.php
 * Created by Liyang on 2016-03-29
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'WechatCallbackApi.class.php';

define('USER_OPENID', 'oAPgewVo18O5I-uKBg8hsJvxVmkU');
define('TEMPLATE_ID', 'fxMcfzU6bDMvieuSJZ50Jfd6CQ11AQPM459W4Ur5Wfg');

$postEntity = '{
	"touser":"'.USER_OPENID.'",
	"template_id":"'.TEMPLATE_ID.'",
	"url":"http://www.libenkuo.com/blog/public",
	"topcolor":"#ff9800",
	"data":""
 }';

$wechatCallbackApiObj = new WechatCallbackApi();
$wechatCallbackApiObj->templateSend($postEntity);
?>
