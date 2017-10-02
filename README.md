workerman-chat
=======
基于workerman的GatewayWorker框架开发的一款高性能支持分布式部署的弹幕服务端小dome。

GatewayWorker框架文档：http://www.workerman.net/gatewaydoc/

Workerman框架文档: http://doc.workerman.net/315110

 特性
======
 * 使用websocket协议
 * 多浏览器支持（浏览器支持html5或者flash任意一种即可）
 * 多房间支持
 * 私聊支持
 * 掉线自动重连
 * 支持多服务器部署
 * 业务逻辑全部在一个文件中，快速入门可以参考这个文件[Applications/Chat/Event.php]
  
下载安装与启动(Linux系统)
=====

以debug方式启动  
```php start.php start  ```

以daemon方式启动  
```php start.php start -d ```



WebSocket 在线测试
=======
http://www.blue-zero.com/WebSocket/

ws://127.0.0.1:7272


