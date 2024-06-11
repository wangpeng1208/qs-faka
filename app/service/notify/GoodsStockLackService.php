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
