<?php
/**
 * User: lyh
 * Date: 2017/9/28 0028
 * Time: 下午 4:37
 */

use Workerman\Worker;
require_once __DIR__.'/../../workerman/autoloader.php';
$json_worker = new Worker("JsonNl://0.0.0.0:1234");
$json_worker->onMessage = function($connection,$data){
    // $data就是客户端传来的数据，数据已经经过JsonNL::decode处理过
    echo $data;

    // $connection->send的数据会自动调用JsonNL::encode方法打包，然后发往客户端
    $connection->send(['code'=>0,'msg'=>'ok']);
};

Worker::runAll();