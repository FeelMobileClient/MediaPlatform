# 微信公众号服务器开发

## 开始开发

### 接入

### 获取接口调用凭据

> 注意：`GET` 方式获取 `access_token` 时，&secret=APPSECRECT 

## 消息管理

### 接收与发送

> 注意：
>
> 1. 接收消息时的 `FromUserName` 作为发送消息时的 `ToUserName`
>
> 2. 添加 `![CDATA[]]` 在发送消息体中，用户接收不到信息，所以暂时没有加上
#### 随机回复模块
用户发送信息后，从预留的短语中随机选择一条发送给用户
> `TODO`:出现了消息重复的情况，待解决


## 自定义菜单

### 创建

```php
curl_setopt($cURLCreateMenu, CURLOPT_POST, true);
curl_setopt($cURLCreateMenu, CURLOPT_POSTFIELDS, $postMenuEntity);
```
