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

namespace app\service\common;

use support\Container;
use app\common\model\OrderMaster;
use app\common\model\ChannelAccount;

class PayService
{

    // 实例化支付渠道
    public function invoke($code)
    {
        $class = "\\app\\home\\collection\\" . $code;
        return Container::get($class);
    }

    // 加载订单
    public function loadOrder($trade_no)
    {
        if (empty($trade_no)) {
            throw new \Exception("订单号不能为空");
        }
        $order_master = OrderMaster::where("trade_no", $trade_no)->find();
        if (!$order_master) {
            record_file_log("pay_error", $trade_no . "不存在该订单号！");
            throw new \Exception("不存在该订单号！");
        }
        $order = $order_master->loadModel;
        if (!$order) {
            record_file_log("pay_error", $trade_no . "不存在该订单！");
            throw new \Exception("不存在该订单！");
        }
        $channel = $order->channel;
        if (!$channel) {
            record_file_log("pay_error", $trade_no . "不存在该支付渠道！");
            throw new \Exception("不存在该支付渠道！");
        }
        $account = $order->channelAccount;
        if (!$account) {
            record_file_log("pay_error", $trade_no . "不存在支付渠道：" . $channel->title . "的账号！");
            throw new \Exception("不存在支付渠道：" . $channel->title . "的账号！");
        }
        return $order;
    }

    // 订单标题
    public function orderTitle($order)
    {
        switch (conf("order_title_type")) {
            case 1:
                return $order->trade_no;
            case 2:
                return conf("order_title_profix") . $order->trade_no;
            case 3:
                return conf("order_title_str");
            default:
                return $order->goods_name;
        }
    }

    // 支付
    public function pay($order, $trade_no, $total_price)
    {
        $title   = $this->orderTitle($order);
        $channel = $this->invoke($order->channel->code);
        // 对应的支付渠道的支付方法
        return $channel->pay($order->trade_no, $title, $total_price);
    }

    // 退款
    public function refund($order)
    {
        $channel = $this->invoke($order->channel->code);
        // 对应的支付渠道的支付方法
        return $channel->refund($order);
    }

    // 回调
    public function notify($request, $account_id)
    {
        try {
            if (isset($request['out_trade_no'])) {
                $order   = $this->loadOrder($request['out_trade_no']);
                $channel = $this->invoke($order->channel->code);
            } else if (!empty($account_id)) {
                // 通过渠道查找 通道码
                $account = ChannelAccount::where('status', 1)->findOrFail($account_id);
                $channel = $this->invoke($account->channel->code);
            } else {
                throw new \Exception("缺少参数");
            }
            // 对应的支付渠道的支付方法
            return $channel->notify($request, $account_id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
