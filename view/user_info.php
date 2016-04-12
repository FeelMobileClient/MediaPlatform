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

// echo 'CODE  : '.$code.'<br>';
// echo 'STATE : '.$state.'<br>';

$jsonOb = $wechatAuthorizeObj->getJsonObwithToken($code);

$userInfo = $wechatAuthorizeObj->getUserInfo($jsonOb->access_token, $jsonOb->openid);

// echo $userInfo->errcode.'<br>';
// echo $userInfo->errmsg.'<br>';
echo $userInfo->openid.'<br>';
echo $userInfo->nickname.'<br>';
echo $userInfo->sex.'<br>';

?>
