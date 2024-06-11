<?php

// +----------------------------------------------------------------------
// | 骑士虚拟产品寄售商城系统开源版 
// +----------------------------------------------------------------------
// | Copyright (c) 2023-2025 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed MIT 本系统开源仅仅是为了新手学习开发商城为目的，使用时请遵循当地法律法规
// +----------------------------------------------------------------------
// | Author: QQSS <990504246@qq.com>
// +----------------------------------------------------------------------

namespace app\service\message;

use app\common\model\MerchantMessage;

/**
 * 站内系统消息
 * 无需消息必达，只需消息推送
 */
class MessageService
{
    public static function send($from_id, $to_id, $title, $content)
    {
        $data   = [
            'from_id'   => $from_id,
            'to_id'     => $to_id,
            'title'     => $title,
            'content'   => strip_tags($content),
            'status'    => 0,
            'create_at' => time(),
        ];
        $result = MerchantMessage::create($data);
        return $result;
    }
}
