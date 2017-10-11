<?php

use Workerman\Worker;
require_once __DIR__."/workerman/Autoloader.client";

$worker = new Worker();

$worker->count = 4;

$worker->onWorkerStart = function($worker){
    $inner_worker = new Worker('http://0.0.0.0:2016');
    $inner_worker->onMessage = 'on_message';
    //<=client 7.0  4个进程报错
    $inner_worker->listen();
};

$worker->onMessage = 'on_message';

function on_message($connection,$data)
{
    $connection->send("hello\n");
}

Worker::runAll();