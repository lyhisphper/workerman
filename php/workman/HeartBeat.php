<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28 0028
 * Time: 上午 10:02
 */
require_once __DIR__.'/workerman/Autoloader.php';
use workerman\worker;
use workerman\Lib\Timer;

//心跳间隔25秒
define('HEARTBEAT_TIME',25);

//协议
$worker = new worker('text://0.0.0.0:1234');

$worker->onMessage = function($conneection,$msg){
    //设置lastMessageTime ，记录上次收到消息时间
    $conneection->lastMessageTime = time();
};

//进程启动后设置每秒运行一次
$worker->onWorkerStart = function($worker){
    Timer::add(1,function()use($worker){
        $time_now  = time();
        foreach($worker->connection as $connection){
            if(empty($connection->lastMessageTime)){
                $connection->lastMessageTime = $time_now;
            }
        }
        //连接时间超过25秒断开
        if($time_now - $connection->lastMessageTime > HEARTBEAT_TIME){
            $connection->close();
        }
    });
};
Worker::runAll();