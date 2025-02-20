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

use app\service\common\PayService;
use app\service\home\OrderService;
use support\Request;
class Pay extends Base
{
    // 订单生成
    public function order(OrderService $orderService)
    {
        $this->success("订单创建成功！", $orderService->createOrder());
    }

    // 发起支付
    public function pay(PayService $payService)
    {
        $trade_no = inputs("trade_no/s", "");
        try {
            $order = $payService->loadOrder($trade_no);
        } catch (\Exception $e) {
            return view("pay/pay", [
                'msg' => $e->getMessage(),
            ]);
        }

        if ($order->status == 1) {
            return view("pay/pay", [
                'msg' => "订单已支付，请勿重复支付！",
            ]);
        }
        if ($order->status == 2) {
            return view("pay/pay", [
                'msg' => "订单已超时关闭，请重新下单！",
            ]);
        }
        if ($order->status == 3) {
            return view("pay/pay", [
                'msg' => "订单已退款！",
            ]);
        }

        $total_price = round($order->total_price, 2);

        return $payService->pay($order, $trade_no, $total_price);
    }

    /**
     * 支付回调方法
     * @return void
     */
    public function notify(Request $request, $id = '')
    {
        $payService = new PayService();
        $request    = $request->all();
        return $payService->notify($request, $id);
    }
}
