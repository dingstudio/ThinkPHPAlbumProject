## 简介

PHPAlbum-一款基于ThinkPHP V3开发的个人相册系统

## 支持功能

* [x] 相册相片管理
* [x] 多用户管理/异步登录注册（AJAX）
* [x] 媒体数据云端存储支持（目前测试兼容本地/又拍云/FTP存储）
* [x] 相册基础布局在线自定义
* [x] 多用户管理/Ajax登录注册
* [ ] 相册留言功能
* [ ] 相册留言管理
* [x] AJAX后端API接口
* [x] JSONP跨域支持
* [x] APIToken鉴权
* [x] 支持整合统一身份认证（目前仅支持DingStudio Single Sign On协议）
* [ ] 前台用户密码重置


## 部署方法

*   导入config目录下的myalbum.sql到mysql数据库服务器，并修正config.php中的数据库配置信息。
*   启动Web服务器即可使用，后台管理地址：admin.php 首次访问请先点击登录页面下侧的注册按钮导入首个用户信息或使用统一身份认证平台免密登录

## 重要提示

*   本系统首次安装后由于相册数据表默认为空，可能会导致前台页面提示ajax数据拉取失败。请直接忽视并使用初始用户名密码登录后台，上传你的第一张相片，即可解决此问题！
*   统一身份认证（Single Sign On）协议需要OpenSSL支持，请确保在PHP.INI中开启OpenSSL支持扩展。

## 运行环境
*   Web服务器：IIS/Apache/Nginx 已测试可用
*   PHP后端建议版本：5.5及以上，经测试兼容最新PHP7.2
*   MySQL建议版本：5.5及以上，经测试兼容最新MySQL5.7
*   RestAPI支持：通过UrlRewrite实现
*   PHP所需扩展：bcmath,bz2,ctype,curl,dom,gd,hash,iconv,json,mbstring,mysqli,openssl,pdo,pdo_mysql,session,xml,zip

## 友好的开源协议

PHPAlbum遵循MIT开源协议发布。
