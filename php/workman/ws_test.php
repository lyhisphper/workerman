<?php
/**
 * 使用WebSocket协议对外服务
 * User: lyh
 * Date: 2017/9/28 0028
 * Time: 下午 2:51
 */

use workerman\Worker;

require_once __DIR__.'/../../workerman/autoloader.php';

//使用websocket 协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

//启动4个进程
$ws_worker->count = 4;

$ws_worker->onMessage = function($connection,$data){
    $connection->send('hello'.$data);
};
Worker::runAll();

/*测试

打开chrome浏览器，按F12打开调试控制台，在Console一栏输入(或者把下面代码放入到html页面用js运行)

// 假设服务端ip为127.0.0.1
ws = new WebSocket("ws://127.0.0.1:2000");
ws.onopen = function() {
    alert("连接成功");
    ws.send('tom');
    alert("给服务端发送一个字符串：tom");
};
ws.onmessage = function(e) {
    alert("收到服务端的消息：" + e.data);
};*/