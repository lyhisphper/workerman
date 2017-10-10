<?php
/**
 * User: lyh
 * Date: 2017/9/28 0028
 * Time: 下午 2:56
 */

use workerman\Worker;

require_once __DIR__.'/../../workerman/autoloader.php';

//创建一个worker监听2345端口，使用http协议通讯
$http_worker = new Worker("tcp://0.0.0.0:2347");

//启动4个进程对外提供服务
$http_worker->count = 4;

//接受浏览器发送的数据回复hello，world
$http_worker->onMessage = function($connection,$data){
    $connection->send('hello,world');
};

Worker::runAll();

/*测试：命令行运行
(以下是linux命令行效果，与windows下效果有所不同)
telnet 127.0.0.1 2347
Trying 127.0.0.1...
Connected to 127.0.0.1.
Escape character is '^]'.
tom
hello tom*/