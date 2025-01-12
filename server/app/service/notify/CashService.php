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

class CashService
{
    public function notify($user, $money, $fee, $realmoney, $reason = false)
    {
        if (empty($reason)) {
            $title   = "结算成功";
            $content = "提现金额：{$money}元,扣手续费{$fee}元,到账金额{$realmoney}元,感谢你的使用";

            MessageService::send(0, $user->id, $title, $content);

            if (conf('cash_emailnotify_open') == 1) {
                try {
                    EmailMessageService::send($user->email, '【' . conf('site_name') . '】' . $title, $content);
                } catch (\Exception $e) {
                    Log::channel('email')->info("提现提醒邮件发送失败：" . $e->getMessage() . '。 ' . $user->email . '【' . conf('site_name') . '】' . $title . ' | ' . $content);
                }
            }
        } else {
            MessageService::send(0, $user->id, "申请提现未通过", $reason);
        }

    }
}
