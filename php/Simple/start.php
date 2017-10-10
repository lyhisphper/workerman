<?php
/**
 * User: lyh
 * Date: 2017/9/28 0028
 * Time: 下午 4:12
 */
use workerman\Worker;

require_once __DIR__.'/../../workerman/autoloader.php';

$global_uid = 0;

//当客户端连上来时分配 uid ,并保存连接，并通知客户端
function handle_connection($connection)
{
    global $text_worker,$global_uid;

    //为连接分配uid
    $connection->uid = ++$global_uid;
}

//客户端发送消息，广播给所有人
function handle_message($connection,$data)
{
    global $text_worker;
    foreach($text_worker->connections as $conn){
        $conn->send("use[{$connection}] said: $data");
    }
}

//客户端断开，广播给所有客户端
function handle_close($connection)
{
    global $text_worker;
    foreach($text_worker->connection as $conn){
        $conn->send("user[{$connection->uid}] logout");
    }
}

$text_worker = new Worker("text://0.0.0.0:2347");

$text_worker->count = 1;

$text_worker->onConnect = "handle_connection";
$text_worker->onMessage = "handle_message";
$text_worker->onClose = "handle_close";

Worker::runAll();

/*Text协议可以用telnet命令测试

telnet 127.0.0.1 2347*/