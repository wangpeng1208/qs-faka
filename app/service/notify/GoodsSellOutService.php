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

use app\service\message\EmailMessageService;

class GoodsSellOutService
{
    public function notify($order)
    {
        // 售出通知
        $domain = conf('site_shop_domain') . '/orderquery?orderid=' . $order->trade_no;
        // 通知卖家
        if ($order->sold_notify == 1) {
            EmailMessageService::send(
                $order->user->email,
                '【' . conf('site_name') . "】尊敬的用户，您托管销售的[{$order->goods_name}]商品成功出售！",
                "订单号：{$order->trade_no}<a href=\"{$domain}\" target=\"_blank\">[查看详细]</a><br>数量：{$order->quantity}<br>总价：{$order->total_price}<br>联系方式：{$order->contact}"
            );
        }
        // 通知买家客户
        if ($order->email_notify == 1) {
            // 邮件通知
            if (preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $order->email)) {
                EmailMessageService::send($order->email, '【' . conf('site_name') . '】您的订单已支付成功', "您的订单已支付成功，订单号：{$order->trade_no}<a href=\"{$domain}\" target=\"_blank\">[查看详细]</a><br>，若您付款成功后没有领取虚拟卡信息，请您及时通过订单查询提取。");
            }
        }

    }
}
