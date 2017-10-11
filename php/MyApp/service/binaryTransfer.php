<?php
use Workerman\Worker;
require_once '../../../workerman/Autoloader.php';

$worker = new Worker('BinaryTransfer://0.0.0.0:8333');

$worker->onMessage = function($connection,$data){
    $save_path = '/tmp/'.$data['file_name'];
    file_put_contents($save_path,$data['file_data']);
    $connection->send("upload success.save path $save_path");
};

Worker::runAll();