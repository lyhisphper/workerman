<?php
$address = "127.0.0.1:8333";
if(!isset($argv[1])){
    exit("use php client.php \$file_path\n");
}
//argv命令行文件路径
$file_to_transfer = trim($argv[1]);
if(!is_file($file_to_transfer)){
    exit("$file_to_transfer not exist \n");
}

//程序无阻塞
stream_set_blocking($client,1);

//无拓展文件名
$file_name = basename($file_to_transfer);

$name_len = strlen($file_name);

//获取内容
$file_data = file_get_contents($file_to_transfer);

$PACKAGE_HEAD_LEN = 5;

$package = pack('NC',$PACKAGE_HEAD_LEN + strlen($file_name) + strlen($file_data),$name_len).$file_name.$file_data;

fwrite($client,$package);

echo fread($client,8192),"\n";