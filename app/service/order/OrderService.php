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

namespace app\service\order;

use think\facade\Db;
use app\service\sms\SmsService;
use app\common\model\Order;
use app\common\model\AutoUnfreeze;
use app\common\model\GoodsCoupon;
use app\service\goods\GoodsService;
use app\service\notify\GoodsSellOutService;
use app\service\pay\PayService;
use app\service\analysis\AnalysisService;

class OrderService
{
    /**
     * 完成订单
     * @param Order $order
     * @return array
     */
    public function complete(&$order)
    {
        if (empty($order)) {
            throw new \Exception("订单不存在");
        }
        if ($order->status == 1) {
            throw new \Exception("订单已支付");
        }
        $user = $order->user()->lock(true)->find();
        if (!$user) {
            throw new \Exception("订单商户不存在");
        }

        $time = time();
        // 可解冻时间 今日结束时间或者24小时
        $settlement_frezze_endtime = conf('settlement_frezze_endtime');
        if ($settlement_frezze_endtime === 2) {
            $unfreeze_time = time() + 86400;
        } else {
            $unfreeze_time = strtotime(date("Y-m-d", $time)) + 86400;
        }

        DB::startTrans();
        try {
            // 自己商品的订单
            $total_product_price = $order->total_product_price;
            // 成本 自有商品成本为0
            $order_total_cost_price = 0;


            // 记录用户资金变动
            $user->money = round($user->money + $total_product_price, 3);
            $user->save();
            record_user_money_log("goods_sold", $user->id, $total_product_price, $user->money, "成功售出商品" . $order->goods_name . "(" . $order->quantity . "张)");


            // 如果交易手续费是卖家承担，且交易手续费大于0 则扣除交易费
            if ($order->fee_payer == 1 && $order->fee > 0) {
                $user->money = round($user->money - $order->fee, 3);
                $user->save();
                record_user_money_log("goods_sold", $user->id, -1 * $order->fee, $user->money, "扣除交易手续费，订单：" . $order->trade_no);
            }

            // 推广佣金 - 【平台承担手续费里的推广返佣比例】
            $this->proxy_fee($order, $user);
            // 扣除短信费后的总金额
            $sms_fee = $this->sms_fee($order, $user);
            // 选号费 +
            $select_number_fee = $this->select_number_fee($order, $user);
            // 更新订单  finally_money 商户订单最终收入（已扣除短信费，手续费）
            if ($order->fee_payer == 2) {
                $finally_money = $total_product_price - $sms_fee + $select_number_fee;
            } else {
                $finally_money = $total_product_price - $order->fee - $sms_fee + $select_number_fee;
            }

            $this->updateOrderStatus($order, $user, $finally_money, $order_total_cost_price);

            $this->finally_money($order, $user, $finally_money);


            AnalysisService::analysis($user->id, $order->total_price, $order->finally_money, $order->finally_money - $order_total_cost_price, 1, $time);

            Db::commit();


        } catch (\Exception $e) {
            Db::rollback();
            record_file_log("complete_error", $order->trade_no . $e->getMessage());
            record_file_log("complete_error", $e->getTraceAsString());
            throw new \Exception($e->getMessage());
        }

        // 自动发货
        if ($order->goods->card_order == 3) {
            (new GoodsService())->sendOut($order->trade_no);
        }
        // 发起通知
        (new GoodsSellOutService())->notify($order);
        return A(1, "订单设置支付成功");
    }

    /**
     * 推广佣金
     *
     * @param [type] $order
     * @param [type] $user
     */
    public function proxy_fee($order, $user)
    {
        if ($user->parent_id) {
            $rate = conf('spread_rebate_rate');
            if ($rate === null || $rate < 0 || $rate > 100) {
                return 0;
            }
            // 返佣比例
            $get_spread_rebate_rate = round($rate / 100, 4);
            $parent                 = $user->parentUser()->lock(true)->find();
            // 佣金
            $fee = round($order->fee * $get_spread_rebate_rate, 3);
            if ($fee > 0) {
                $parent->money = round($parent->money + $fee, 3);
                // 统计佣金 ， 不参与结算
                $parent->rebate = round($parent->rebate + $fee, 3);
                $parent->save();
            }
            record_user_money_log("sub_sold_rebate", $parent->id, $fee, $parent->money, "下级[" . $user->username . "]售出商品，返佣" . $fee . "元");
        }
    }

    /**
     * 短信费用
     * @param [type] $order
     * @param [type] $user
     */
    public function sms_fee($order, $user)
    {
        // 如果商户承担短信费用，且订单需要发送短信，则扣除短信费用
        if ($order->sms_notify == 1) {
            // 发送短信
            (new SmsService())->sendSms('order_to_buyer', $order->contact, [
                'trade_no' => $order->trade_no,
            ]);

            if ($order->sms_payer == 1) {
                $sms_price   = (new SmsService())->getSmsPrice('order_to_buyer');
                $user->money = round($user->money - $sms_price, 3);
                if ($user->money < 0) {
                    throw new \Exception("商户余额不足，扣除短信费失败！");
                }
                $user->save();
                $order->sms_price = $sms_price;
                $order->save();
                record_user_money_log("goods_sold", $user->id, -1 * $sms_price, $user->money, "扣除短信费，订单：" . $order->trade_no);

                return $sms_price;
            }
        }

        return 0;
    }

    /**
     * 选号费用
     * @param [type] $order
     * @param [type] $user
     */
    public function select_number_fee($order, $user)
    {
        // 未对这里收取交易手续费
        // 代理商品不允许选号
        if ($order->selectcard_fee_merchant > 0) {
            // 选号费用由买家承担，卖家收益加上选号费用
            $user->money = round($user->money + $order->selectcard_fee_merchant, 3);
            $user->save();
            record_user_money_log("goods_sold", $user->id, $order->selectcard_fee_merchant, $user->money, "收益选号费" . $order->selectcard_fee_merchant . "元");
            return $order->selectcard_fee_merchant;
        }
        return 0;
    }

    /**
     * 最终结算
     * @param [type] $order
     * @param [type] $user
     * @param [type] $total_product_price
     */
    public function finally_money($order, $user, $finally_money)
    {
        $time          = time();
        $unfreeze_time = strtotime(date("Y-m-d", $time)) + 86400;
        // T+1 结算
        if ($order->settlement_type == 1) {
            $auto_unfreeze                = new AutoUnfreeze();
            $auto_unfreeze->trade_no      = $order->trade_no;
            $auto_unfreeze->user_id       = $user->id;
            $auto_unfreeze->money         = $finally_money;
            $auto_unfreeze->unfreeze_time = $unfreeze_time;
            $auto_unfreeze->created_at    = $time;
            $auto_unfreeze->save();

            $freeze_money = round($user->freeze_money + $finally_money, 3);
            record_user_money_log("freeze", $user->id, -1 * $finally_money, round($user->money - $finally_money, 3), "冻结订单：" . $order->trade_no . ", 冻结金额: " . $finally_money . "元");
            $user->money        = round($user->money - $finally_money, 3);
            $user->freeze_money = $freeze_money;
            $user->save();
        } elseif ($order->settlement_type == 0) {
            record_user_money_log("freeze", $user->id, 0, $user->money, "冻结订单：" . $order->trade_no . ", 冻结金额: 0元(T0 计算)");
            $auto_unfreeze                = new AutoUnfreeze();
            $auto_unfreeze->trade_no      = $order->trade_no;
            $auto_unfreeze->user_id       = $user->id;
            $auto_unfreeze->money         = 0;
            $auto_unfreeze->unfreeze_time = $unfreeze_time;
            $auto_unfreeze->created_at    = $time;
            $auto_unfreeze->save();
        }
    }

    /**
     * 更新订单状态
     * @param [type] $order 订单实例
     * @param [type] $finally_money 最终结算金额
     * @param [type] $proxy_finally_money 代理最终结算金额
     */
    public function updateOrderStatus($order, $user, $finally_money, $proxy_finally_money)
    {
        $order->finally_money       = $finally_money;
        $order->proxy_finally_money = $proxy_finally_money;
        $order->status              = 1;
        $order->success_at          = time();
        $order->save();
    }

    /**
     * 查找
     */
    public function findOrder($trade_no)
    {
        $order = Order::where(['trade_no' => $trade_no])->find();
        if (!$order) {
            throw new \Exception("订单不存在");
        }
        return $order;
    }


}
