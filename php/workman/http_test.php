<?php
use workerman\Worker;

require_once __DIR__.'/../../workerman/autoloader.php';

//创建一个worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

//启动4个进程对外提供服务
$http_worker->count = 4;

//接受浏览器发送的数据回复hello，world
$http_worker->onMessage = function($connection,$data){
    $connection->send('hello,world');
};

Worker::runAll();

/*测试

假设服务端ip为127.0.0.1

在浏览器中访问url http://127.0.0.1:2345*/