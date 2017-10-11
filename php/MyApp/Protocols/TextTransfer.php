<?php
namespace MyApp\Protocol;
class TextTransfer
{
    public static function input($recv_buffer)
    {
        $recv_len = strlen($recv_buffer);
        if($recv_buffer[$recv_len-1] != "\n" ){
            return 0;
        }
        return strlen($recv_buffer);
    }

    public static function decode($recv_buffer)
    {
        $package_data = json_decode(trim($recv_buffer),true);

        $file_name = $package_data['file_name'];
        $file_data = $package_data['file_data'];
        $file_data = base64_decode($file_data);

        return [
            'file_name' => $file_name,
            'file_data' => $file_data
        ];
    }

    public static function encode($data)
    {
        return $data;
    }
}
