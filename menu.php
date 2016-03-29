<?php
/************************************************
 * menu.php
 * Created by Liyang on 2016-03-28
 * Copyright © 2016年 Liyang. All rights reserved
 ************************************************/

include 'WechatCallbackApi.class.php';

$postEntity = '{
     "button":[
     {	
          "type":"view",
          "name":"博客",
          "url":"http://www.libenkuo.com/blog/public"
      }]
 }';

$wechatCallbackApiObj = new WechatCallbackApi();
$wechatCallbackApiObj->createMenu($postEntity);
?>
