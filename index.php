<?php
/************************************************
 * index.php
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/
include 'WechatCallbackApi.class.php';

$wechatCallbackApiObj = new WechatCallbackApi();

// 服务器认证，认证后关闭
// $wechatCallbackApiObj->valid();

// 测试 获取 access_token
// echo $wechatCallbackApiObj->getToken();

$wechatCallbackApiObj->responseMsg();

?>
