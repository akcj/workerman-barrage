workerman-barrage
=======
基于workerman的GatewayWorker框架的弹幕小dome

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
 * 业务逻辑全部在一个文件中，快速入门可以参考这个文件[Applications/Chat/Event.php](https://github.com/walkor/workerman-chat-for-win/blob/master/Applications/Chat/Event.php)   

安装与启动（windows环境）
=====

下载 或者 clone 代码到本地

要求 php>=5.3.3 并且配置好了php环境变量

windows系统php环境配置参考 http://www.workerman.net/windows
  
启动

双击start_for_win.bat

停止

ctrl+c 停止

注意：  
=======
windows系统下无法使用 stop reload status 等命令  

WebSocket 在线测试
=======
http://www.blue-zero.com/WebSocket/

ws://127.0.0.1:7272

