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

class ComplaintService
{
    public function notify($user, $orderid)
    {
        $title   = "投诉单号：{$orderid}";
        $content = "请登录会员中心处理您的投诉，如24小时内不处理，我们将判为买家胜诉";
        //站内信
        MessageService::send(0, $user['id'], "收到订单投诉", "订单：" . $orderid . "已被买家投诉，请及时处理！");
        // 邮件通知
        if (!empty($user['email'])) {
            try {
                EmailMessageService::send($user['email'], '【' . conf('site_name') . '】' . $title, $content);
            } catch (\Exception $e) {
                Log::channel('email')->info("投诉提醒邮件发送失败：" . $e->getMessage() . '。 ' . $user['email'] . '【' . conf('site_name') . '】' . $title . ' | ' . $content);
            }
        }
    }
}
