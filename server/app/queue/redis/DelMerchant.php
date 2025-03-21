<?php

// namespace app\queue\redis;

// use Webman\RedisQueue\Consumer;
// use app\common\model\UserRoleRelation;

// class DelMerchant implements Consumer
// {
//     // 要消费的队列名
//     public $queue = 'del-merchant';

//     // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
//     public $connection = 'default';

//     // 消费
//     public function consume($data)
//     {
//         // 无需反序列化
//         // var_export($data);
//         $user_id = $data['user_id'];
//         UserRoleRelation::where('user_id', $user_id)->delete();
//         // 继续用来扩展更多 比如 删除商户下的商品等等
        
//     }
            
// }
