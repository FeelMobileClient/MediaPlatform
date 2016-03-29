<?php
/************************************************
 * user_info.php
 * Created by Liyang on 2016-03-29
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include '../constants.config.php';
include '../class/WechatAuthorize.class.php';


$wechatAuthorizeObj = new WechatAuthorize();

$code = $_GET['code'];
$state = $_GET['state'];

echo $wechatAuthorizeObj->getAccessToken($code);
?>
