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

namespace app\home\controller;

use support\Cache;
use app\service\common\PayService;
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
