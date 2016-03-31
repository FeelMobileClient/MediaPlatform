<?php
include '../constants.config.php';
require_once "../class/WechatJSSDK.class.php";

$wechatJSSDK = new WechatJSSDK(APPID, APPSECRET);
$signPackage = $wechatJSSDK->getSignPackage();
?>

<!DOCTYPE html>
<html>
<head>
	<title>微信JSSDK接入</title>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >
</head>

<body>

</body>
<!-- 引入 JS 文件 -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
/*
 * 通过 config 接口注入权限验证配置
 */
wx.config({
	debug: true,
	appId: '<?php echo $signPackage["appId"]; ?>',
	timestamp: <?php echo $signPackage["timestamp"]; ?>,
	nonceStr: '<?php echo $signPackage["nonceStr"]?>',
	signature: '<?php echo $signPackage["signature"]?>',
	jsApiList: [

	]
});

/*
 * 通过 ready 接口处理成功验证
 */
wx.ready(function() {
	
});

/*
 * 通过 error 接口处理失败验证
 */
wx.error(function(res) {
	
});
</script>

</html>
