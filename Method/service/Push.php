<?php
use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('websocker://0.0.0.0:1234');

$worker->count = 1;

$worker->onWorkerStart = function($worker){
    $inner_text_worker = new Worker('text://0.0.0.0:5678');
    $inner_text_worker->onMessage = function($connection,$buffer){
        $data = json_decode($buffer,true);
        $uid = $data['uid'];
        $ret = sendMessageByUid($uid,$buffer);
        $connection->send($ret ? 'ok' : 'fail');
    };
    $inner_text_worker->listen();
};

$worker->onMessage = function($connection,$data){
    global $worker;
    if(!isset($connection->uid)){
        $connection->uid = $data;
        $worker->uidConnections[$connection->uid] = $connection;
        return ;
    }
};

$worker->onClose = function($connection){
    global $worker;
    if(isset($connection->uid)){
        unset($worker->uidConnections[$connection->uid]);
    }
};

function broadcast($message)
{
    global $worker;
    foreach($worker->uidConnection as $connection){
        $connection = $worker->uidConnections[$message];

    }
}

function sendMessageByuid($uid, $message){
    global $worker;
    if(isset($worker->uidConnections[$uid])){
       $connection = $worker->uidConnections[$uid];
        $connection->send($message);
        return true;
    }
    return false;
}

Worker::runAll();