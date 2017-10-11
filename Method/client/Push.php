<?php
/**
 * 后端推送消息
 */
$client = stream_socket_client('tcp://127.0.0.1:5678',$error,$errmsg,1);
$data = [
    'uid'=>'uid1',
    'percent' => '88%'
];
fwrite($client,json_encode($data)."\n");
echo fread($client,8192);