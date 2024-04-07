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

class ComplaintService
{
    public function notify($user, $orderid)
    {
        $title   = "投诉单号:{$orderid}";
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
