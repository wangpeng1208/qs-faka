<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

return [
    'default' => [
        'host'     => '127.0.0.1',
        'password' => null,
        'port'     => 6379,
        'database' => 2,
        'prefix'   => 'qsky-',
        'pool'     => [ // 连接池配置
            'max_connections'    => 10,     // 连接池最大连接数
            'min_connections'    => 1,      // 连接池最小连接数
            'wait_timeout'       => 3,         // 从连接池获取连接最大等待时间
            'idle_timeout'       => 50,        // 连接池中连接空闲超时时间，超过该时间会被关闭，直到连接数为min_connections
            'heartbeat_interval' => 50,  // 心跳检测间隔，不要小于60秒
        ],
    ],
];