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

use app\service\pay\PayService;
use app\service\home\OrderService;

class Pay extends Base
{
    // 订单生成
    public function order(OrderService $orderService)
    {
        // 需要校验的数据
        $post['goods_id']      = input('goods_id/s', '');
        $post['contact']       = input('contact/s', '');
        $post["quantity"]      = input("quantity/d", 0);
        $post['coupon_code']   = input("coupon_code/s", '');
        $post['card_password'] = input("pwdforsearch/s", "");
        $post['pid']           = input("pid/s", "");
        $validate              = new \app\home\validate\OrderValidate;
        $validate->scene('create')->failException(true)->check($post);
        $data = $orderService->createOrder($post);
        // v4版本 是否同步创建 支付
        // v4 pid 查询是否是二维码返回 如果是 需要 是否返回二维码；免去跳转支付页面
        $this->success("订单创建成功！", $data);
    }

    // 发起支付
    public function pay(PayService $payService)
    {
        $trade_no = input("trade_no/s", "");
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
                'msg' => "订单已退款，还付个鬼！",
            ]);
        }


        $total_price = round($order->total_price, 2);

        return $payService->pay($order, $trade_no, $total_price);
    }

    /**
     * 支付回调方法
     * @param PayService $payService
     * @return void
     */
    public function notify(PayService $payService)
    {
        $request = request()->all();
        return $payService->notify($request);
    }
}
