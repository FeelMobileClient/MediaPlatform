
<?php
/************************************************
 * qrcode.php
 * Created by Liyang on 2016-04-18
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include '../constants.config.php';
include '../class/WechatCallbackApi.class.php';

$wechatCallbackApiObj = new WechatCallbackApi();
$resultArr = json_decode($wechatCallbackApiObj->qrcodeCreate("TEMP", "", ""));

echo "ticket : ".$resultArr->ticket."<br>";
echo "expire_seconds : ".$resultArr->expire_seconds."<br>";
echo "url : ".$resultArr->url."<br>";
echo "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$resultArr->ticket;
// $wechatCallbackApiObj->qrcodeShow($resultArr->ticket);
?>
