<?php
$address = "127.0.0.1:8333";
if(!isset($argv[1])){
    exit("use php client.php \$file_path\n");
}
$file_to_transfer = trim($argv[1]);
if(!is_file($file_to_transfer)){
    exit("$file_to_transfer not exist \n");
}

stream_set_blocking($client,1);