<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose 
 */
use \GatewayWorker\Lib\Gateway;

class Events
{
   
   /**
    * 有消息时
    * @param int $client_id
    * @param mixed $message
    */
   public static function onMessage($client_id, $message)
   {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:".json_encode($_SESSION)." onMessage:".$message."\n";
        
        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if(!$message_data)
        {
            return ;
        }
        
        // 根据类型执行不同的业务
        switch($message_data['type'])
        {
            // 客户端回应服务端的心跳
            case 'pong':
                return;
            // 客户端登录 message格式: {type:login, uid:xx, room_id:1} ，添加到客户端，广播给所有客户端xx进入聊天室
            case 'join_room':
                // 判断是否有房间号
                if(!isset($message_data['room_id']))
                {
                    throw new \Exception("\$message_data['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']} \$message:$message");
                }
                
                // 把房间号昵称放到session中
                $room_id = $message_data['room_id'];
                $uid = htmlspecialchars($message_data['uid']);
                //加入房间
                Gateway::joinGroup($client_id, $room_id);
                //将房间号存入seesion
                $_SESSION['room_id'] = $room_id;
                $_SESSION['uid'] = $uid;
                
                //给当前客户端返回加入成功信息
                $new_message = ['code'=>0,'msg'=>'加入房间成功',];
                Gateway::sendToCurrentClient(json_encode($new_message));
                return;
                
            // 客户端发言 message: {type:say, uid:xx, content:xx}
            case 'say':
                //可以在这里做是否禁言等操作
                // 非法请求
                if(!isset($_SESSION['room_id']))
                {
                    throw new \Exception("\$_SESSION['room_id'] not set. client_ip:{$_SERVER['REMOTE_ADDR']}");
                }
                $room_id = $_SESSION['room_id'];
                $uid = $_SESSION['uid'];
                //将消息发给房间里的每个用户
                $new_message = array(
                    
                    'uid' =>$uid,
                    'content'=>nl2br(htmlspecialchars($message_data['content'])),
                    'time'=>date('Y-m-d H:i:s'),
                );
                return Gateway::sendToGroup($room_id ,json_encode($new_message));
        }
   }
   
   /**
    * 当客户端断开连接时
    * @param integer $client_id 客户端id
    */
   public static function onClose($client_id)
   {
       // debug
       echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
   }
  
}
