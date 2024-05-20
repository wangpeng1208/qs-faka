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

namespace app\home\controller;

use support\Cache;
use app\service\pay\PayService;
use app\service\home\OrderService;

class Order extends Base
{
    public function orderStatus(PayService $payService)
    {
        $trade_no = inputs("trade_no/s", "");
        Cache::set("order_" . $trade_no, true, 60 * 15);

        if (empty($trade_no) || empty(Cache::get("order_" . $trade_no))) {
            $this->error("订单不存在", 'error');
        }
        // 通过订单号 查找订单模型
        $order = $payService->loadOrder($trade_no);
        
        $status = $order->status;
        if ($status == 1) {
            // 生成前端最终path跳转地址
            $this->success("订单已支付", [
                'path'   => (new OrderService())->orderQueryUrlName(),
                'status' => $status,
            ]);
        } else if ($status == 2) {
            // 生成前端最终path跳转地址
            $this->error("订单超时已关闭", [
                'path'   => 'home',
                'status' => $status,
            ]);
        } else {
        }
    }

    /**
     * 订单查询页面 查询订单
     * @param OrderService $orderService
     * @return void
     */
    public function query(OrderService $orderService)
    {
        return $this->success('获取成功', $orderService->orderQuery());
    }

}
