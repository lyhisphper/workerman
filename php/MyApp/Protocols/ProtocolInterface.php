<?php
/**
 * User: lyh
 * Date: 2017/9/28 0028
 * Time: 下午 4:41
 */
namespace Workerman\Protocols;

use Workerman\Connection\ConnectionInterface;

require_once __DIR__.'/../../../workerman/autoloader.php';

interface ProtocolInterface
{
    /**
     * 用于在接收到的recv_buffer中分包
     *
     * 如果可以在$recv_buffer中得到请求包的长度则返回整个包的长度
     * 否则返回0，表示需要更多的数据才能得到当前请求包的长度
     * 如果返回false或者负数，则代表错误的请求，则连接会断开
     *
     * @param ConnectionInterface $connection
     * @param string $recv_buffer
     * @return int|false
     */
    public static function input($recv_buffer,ConnectionInterface $connection);

    /**
     * 用于请求解包
     *
     * input返回值大于0，并且WorkerMan收到了足够的数据，则自动调用decode
     * 然后触发onMessage回调，并将decode解码后的数据传递给onMessage回调的第二个参数
     * 也就是说当收到完整的客户端请求时，会自动调用decode解码，无需业务代码中手动调用
     * @param ConnectionInterface $connection
     * @param string $recv_buffer
     */
    public static function decode($recv_buffer,ConnectionInterface $connection);

    /**
     * 用于请求打包
     *
     * 当需要向客户端发送数据即调用$connection->send($data);时
     * 会自动把$data用encode打包一次，变成符合协议的数据格式，然后再发送给客户端
     * 也就是说发送给客户端的数据会自动encode打包，无需业务代码中手动调用
     * @param ConnectionInterface $connection
     * @param mixed $data
     */
    public static function encode($data,ConnectionInterface $connection);
}