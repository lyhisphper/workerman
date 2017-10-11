<?php
use Workerman\Worker;
require_once '../workerman/Autoloader.php';

$worker = new Worker('text://0.0.0.0:2015');

$worker->count = 4;

$worker->onWorkerStart = function($worker){
    $inner_worker = new Worker('http://0.0.0.0:2016');
    //设置端口复用 >=client 7.0 监听相同端口
    $inner_worker->reusePort = true;
    $inner_worker->onMessage = 'on_message';
    $inner_worker->listen();
};
$worker->onMessage = 'on_message';

function on_message($connection,$data)
{
    $connection->send("hello \n");
}

Worker::runAll();