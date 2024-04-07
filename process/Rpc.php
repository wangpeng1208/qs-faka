<?php
namespace process;
use Workerman\Connection\TcpConnection;
class Rpc
{
    /**
     * 注意: 控制器不在这里, 而是前端传的Class指定的, 测试是在service/User
     */
    public function onMessage(TcpConnection $connection, $data)
    {
        static $instances = [];
        $data = json_decode($data, true);
        $class = 'service\\'.$data['class'];
        $method = $data['method'];
        $args = $data['args'];
        if (!isset($instances[$class])) {
            $instances[$class] = new $class; // 缓存类实例，避免重复初始化
        }
        $connection->send(call_user_func_array([$instances[$class], $method], $args));
    }
}