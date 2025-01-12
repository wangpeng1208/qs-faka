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

namespace app\home\collection\interfaces;

interface CollectionInterface
{

    /**
     * 订单支付
     * @param $trade_no 结算订单
     * @param $subject  商品名称
     * @param $totalAmount 金额
     * @return mixed
     */
    public function pay($trade_no, $subject, $totalAmount);

    /**
     * 订单退款
     * @param $order 订单
     * @return mixed
     */
    public function refund($order);

    /**
     * 支付异步回调通知
     * @param $request 请求参数
     * @param $account_id 支付账号通道ID
     * @return mixed
     */
    public function notify($request, $account_id);
}