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

### 发送模版消息
添加简单的模版消息模块，测试通过

## 自定义菜单

### 创建

```php
curl_setopt($cURLCreateMenu, CURLOPT_POST, true);
curl_setopt($cURLCreateMenu, CURLOPT_POSTFIELDS, $postMenuEntity);
```
## 用户管理

### 获取用户基本信息

> 在测试帐号环境下，获取access_token失败
>
> 1. 用户同意授权获取`CODE`时，URL 为 `https://open.weixin.qq.com`；获取`access_token`时，URL为`https://api.weixin.qq.com`
>
> 2. 拉取用户信息时，需要`scope`为`snsapi_userinfo`，注意菜单的更新。
