<?php

// +----------------------------------------------------------------------
// | 骑士发卡 [ 平顶山若拉网络科技有限公司，并保留所有权利 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.qqss.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed 骑士软件 并不是自由软件，商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
// +----------------------------------------------------------------------
// | Author: QQSS <admin@qqss.net>
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
