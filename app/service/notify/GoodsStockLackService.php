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

namespace app\service\notify;

use support\Log;
use app\service\message\EmailMessageService;
use app\service\message\MessageService;

class GoodsStockLackService
{

    public function notify($user, $goods)
    {
        //站内信，邮件通知
        $title   = "库存不足";
        $content = "商品：{$goods->name}，库存不足{$goods->inventory_notify}张，请及时添加";
        if ($goods->inventory_notify_type == 1) {
            // 发送站内信
            MessageService::send(0, $goods->user->id, $title, $content);
        } else {
            // 发送邮件
            try {
                EmailMessageService::send($user['email'], '【' . conf('site_name') . '】' . $title, $content);
            } catch (\Exception $e) {
                Log::channel('email')->info("库存不足提醒邮件发送失败：" . $e->getMessage() . '。 ' . $user['email'] . '【' . conf('site_name') . '】' . $title . ' | ' . $content);
            }
        }
    }
}
