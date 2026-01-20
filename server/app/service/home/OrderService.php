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

namespace app\service\home;

use app\common\model\GoodsCard;
use app\common\model\Order;
use app\common\model\Goods;
use app\common\model\AutoUnfreeze;
use app\service\goods\GoodsService;
use app\common\exception\HttpResponseException;
use app\common\model\Channel;
use app\common\model\GoodsCoupon;
use app\common\model\OrderMaster;
use app\service\sms\SmsService;

class OrderService
{

    /**
     * 查询订单是否需要查询密码
     * @param Order $order 订单模型
     */
    public function orderQueryNeedPwd($order)
    {
        return $order->take_card_password ? true : false;
    }

    /**
     * 查询密码是否正常
     * @param Order $order 订单模型
     * @param $pwd 查询密码
     */
    public function orderQueryPwdIsNormal($order, $pwd)
    {
        if ($order->take_card_password != $pwd) {
            throw new \Exception("查询密码错误");
        }
    }

    /**
     * 判断卡密是否包含卡前缀
     * @param $card_id 卡密id
     */
    public function orderCardPrefix($card_id)
    {
        $card = GoodsCard::find($card_id);
        return $card->is_pre ? true : false;
    }

    /**
     * 订单查询
     */
    public function orderQuery()
    {
        $trade_no  = inputs("orderid/s", "");
        $pwd       = inputs("pwd/s", "");
        $orderList = Order::where("contact", $trade_no)
            ->whereOr('trade_no', $trade_no)
            ->order("id desc")->paginate(30);
        if ($orderList->total() == 0) {
            throw new \exception("没有查询到订单信息");
        } else if ($orderList->total() == 1) {
            $pageType = 'detail';
            $order    = $orderList->first();
            if ($this->orderQueryNeedPwd($order)) {
                if (empty($pwd)) {
                    throw new HttpResponseException(200, [
                        'code' => 1001,
                        'msg'  => '请输入查询密码',
                    ]);
                }
            }
            $this->orderQueryPwdIsNormal($order, $pwd);
            // 卡密打印
            (new GoodsService())->sendOut($trade_no);

            if ($order && $order->first_query == 0) {
                $order->first_query = 1;
                $order->save();
            }

            // 卡密数据
            $outCards = $this->orderCardFormat($order);
            $data     = [
                'pageType'     => $pageType,
                'order'        => $order->visible(['trade_no', 'create_at', 'total_price', 'quantity', 'status']),
                'goods'        => $order->goods->visible(['content', 'remark', 'name']),
                'user'         => $order->user->visible(['id', 'username']),
                'shop'         => $order->user->shop->visible(['shop_contact']),
                'paytype'      => get_paytype($order->paytype)?->name,
                'canComplaint' => $this->orderIsComplain($order),
                'outCards'     => $outCards,
            ];
        } else {
            // 前台未支持多个订单查询 可自己扩展后打开此项
            throw new \exception("未支持联系方式查询");
            $pageType = 'list';
            $data     = [
                'pageType' => $pageType,
                'list'     => $orderList->items(),
                'count'    => $orderList->total(),
            ];
        }

        return $data;
    }

    /**
     * 订单是否冻结
     * @param Order $order
     */
    public function orderIsFreeze($order)
    {
        return $order->is_freeze == 1 ? true : false;
    }

    /**
     * 订单是否可投诉
     * @param Order $order
     */
    public function orderIsComplain($order)
    {
        $auto_unfreeze = AutoUnfreeze::where("trade_no", $order->trade_no)->find();
        return ($order->status == 1 && $auto_unfreeze) ? true : false;
    }

    /**
     * 卡密格式化
     * @param Order $order
     */
    public function orderCardFormat($order)
    {
        $data  = [];
        $cards = $order->cards;
        foreach ($cards as $card) {
            if ($card->secret) {
                if ($this->orderCardPrefix($card->card_id)) {
                    $data[] = '卡号：' . $card->number . '    ' . '卡密：' . $card->secret;
                } else {
                    // 用4个tab键连接
                    $data[] = $card->number . '    ' . $card->secret;
                }
            } else {
                if ($this->orderCardPrefix($card->card_id)) {
                    $data[] = '卡号卡密：' . $card->number;
                } else {
                    $data[] = $card->number;
                }
            }
        }
        return implode(PHP_EOL, $data);
    }


    /**
     * 返回前端订单查询地址
     */
    public function orderQueryUrlName()
    {
        return 'order';
    }

    /**
     * 创建订单
     */
    public function createOrder()
    {
        // 需要校验的数据
        $post['goods_id']      = inputs('goods_id/s', '');
        $post['contact']       = inputs('contact/s', '');
        $post["quantity"]      = inputs("quantity/d", 0);
        $post['coupon_code']   = inputs("coupon_code/s", '');
        $post['card_password'] = inputs("pwdforsearch/s", "");
        $post['pid']           = inputs("pid/s", "");
        $validate              = new \app\home\validate\OrderValidate;
        $validate->scene('create')->failException(true)->check($post);

        $goods = Goods::find($post['goods_id']);
        $user  = $goods->user;

        // todo频繁下单

        $post['user_id']          = $user->id;
        $post["create_at"]        = time();
        $post["create_ip"]        = request()->ip();
        $post["goods_id"]         = $goods->id;
        $post["goods_name"]       = $goods->name;
        $post["goods_price"]      = $goods->price;
        $post["goods_cost_price"] = $goods->cost_price;

        // 取卡密码逻辑
        if ($goods->take_card_type == 2) {
            $post["take_card_password"] = $post['card_password'];
            $post["take_card_type"]     = 2;
        }

        // 批发优惠
        $post["goods_price_old"] = $post["goods_price"];
        if ($goods->wholesale_discount_list != null) {
            $post["goods_price"] = $this->discountPrice($goods, $post["quantity"]);
        }

        // 是否可以使用优惠券 且输入了优惠券 且点击了优惠券按钮 且优惠券存在
        if (inputs('is_coupon/d', '') && $post['coupon_code'] && $goods->coupon_type) {
            $coupon = GoodsCoupon::where('code', $post['coupon_code'])->find();
            // 更新优惠券状态
            $coupon->status = 0; // 使用中，不可再次使用；当订单完成后，状态改为2已使用
            $coupon->save();
            // 计算优惠券价格金额
            // 优惠券 折扣
            $post['coupon_price'] = $coupon->type == 100 ? $post["goods_price"] * $post['quantity'] * $coupon->amount / 100 : $coupon->amount;
            $post['coupon_id']    = $coupon->id;
        } else {
            $post['coupon_price'] = 0;
        }
        // 售出通知
        $post["sold_notify"] = (int) $goods->sold_notify;

        // 买家通知
        // 邮件通知
        $post["email_notify"] = inputs("isemail/d", 0);
        $post["email"]        = inputs("email/s", "");
        $post["sms_notify"]   = inputs("is_rev_sms/d", 0);
        // 不包含短信费用的总价
        $post["total_product_price"] = round($post["goods_price"] * $post["quantity"] - $post["coupon_price"], 2);
        // 短信费用
        $post["sms_payer"] = $goods->sms_payer;
        // sms_payer 0:买家承担 1:卖家承担
        $sms_price = (new SmsService())->getSmsPrice('order_to_buyer');
        // 初始短信费用
        $post["sms_price"] = 0;
        // 如果勾选了短信通知
        if ($post["sms_notify"] == 1) {
            // 如果买家承担短信费用
            if ($goods->sms_payer == 0) {
                $post["sms_price"] = $sms_price;
            }
            // 如果卖家承担短信费用
            if ($goods->sms_payer == 1) {
                $post["sms_price"] = 0;
                if ($post["total_product_price"] < $sms_price) {
                    throw new \Exception("商品总价不足以扣除短信费用，请联系商店管理员！");
                }
            }
        }
        // 总价含短信费用
        $post["total_price"] = $post["total_product_price"] + $post["sms_price"];
        // 成本价
        $post["total_cost_price"] = round($post["goods_cost_price"] * $post["quantity"], 2);

        $channel = Channel::where(['id' => inputs("pid/d", 0), "status" => 1])->findOrEmpty();
        if ($channel->isEmpty()) {
            throw new \Exception("支付通道不存在！");
        }

        // 官方支付通道下的所有账号 accounts
        $accounts = $channel->accounts()->where(["user_id" => 0, 'status' => 1])->select();

        if (empty(count($accounts))) {
            throw new \Exception("当前支付通道暂时不可用，请稍后再试【无可用账户】！");
        }


        // 通道账号 随机取一个
        $account                    = $accounts[array_rand($accounts->toArray())];
        $post["paytype"]            = $channel->paytype;
        $post["channel_id"]         = $channel->id;
        $post["channel_account_id"] = $account->id;
        $post["rate"]               = get_user_rate($user->id, $channel->id);
        $post["fee"]                = round($post["rate"] * $post["total_product_price"], 3);
        //   最小手续费
        if ($post["fee"] < conf("transaction_min_fee")) {
            $post["fee"] = conf("transaction_min_fee");
        }
        // fee_payer订单手续费 订单手续费支付方，0：跟随系统，1：商家承担，2买家承担
        $post["fee_payer"] = $user->shop->fee_payer;
        // 如果跟随系统
        if ($post["fee_payer"] == 0) {
            $post["fee_payer"] = conf("fee_payer");
        }
        // 如果买家承担
        if ($post["fee_payer"] == 2) {
            $post["fee_payer"] = 2;
            // 总价加上手续费 精准求和到小数点后4位
            $post["total_price"] = bcadd($post["total_price"], $post["fee"], 4);
        }

        if ($post["total_product_price"] <= 0) {
            throw new \Exception("商家优惠设置有误，总价格不能小于等于0，请联系商家！");
        }
        if ($post["total_product_price"] < round($post["goods_cost_price"] * $post["quantity"], 2)) {
            throw new \Exception("商家优惠设置有误，低于成本价，请联系商家！");
        }

        $post["status"] = 0;
        // 短信费用支付方
        if ($post["sms_payer"] == 1 && $post["total_product_price"] < $post["sms_price"]) {
            if ($user->money < $post["sms_price"]) {
                throw new \Exception("商户余额不足以支付短信费用，请联系商家！");
            }
        }
        // 订单资金结算方式
        $post["settlement_type"] = $user->settlement_type;
        if ($post["settlement_type"] == -1) {
            $post["settlement_type"] = conf("settlement_type");
        }
        // 如果购买赠送
        if ($goods->event_give != null) {
            foreach ($goods->event_give as $k => $v) {
                if ($post["quantity"] >= $v['num']) {
                    // 每买n张赠送m张 ，倍数关系
                    // $ratio = floor($post["quantity"] / $v->num);
                    // $post['quantity'] = $v->give_num * $ratio + $post["quantity"];
                    // 超过n张赠送m张， 一次性赠送
                    $post['quantity'] = $v['give_num'] + $post["quantity"];
                    $data[]           = ['event_give_num' => $v['give_num']];
                }
            }
        }

        $post['trade_no'] = generate_trade_no("T", $user->id);

        // 单号入库数据
        if (empty(Order::create($post))) {
            throw new \Exception("订单创建失败，请稍后再试！");
        }
        // 统一订单库标识
        OrderMaster::create(["trade_no" => $post["trade_no"], "model" => 'Order']);

        return [
            // 订单号
            "trade_no"              => $post["trade_no"],
            // 商品名称
            "goods_name"            => $post["goods_name"],
            // 优惠券价格 存在优惠券价格则使用优惠券
            "coupon_price"          => $post['coupon_price'],
            // 短信费用
            'sms_price'             => $post['sms_price'],
            // 购买数量
            'quantity'              => $post['quantity'],
            // 原始单价
            'goods_price_old'       => $post["goods_price_old"],
            // 最终单价
            'goods_price'           => $post["goods_price"],
            // 不包含短信费用的总价
            'total_product_price'   => $post["total_product_price"],
            // 最总价格
            "total_price"           => $post["total_price"],
            // 支付方式
            "paytype"               => [
                'title' => $channel->show_name
            ],
            "create_time"           => $post["create_at"],
            // 需要承担的手续费
            "fee_player"            => $post["fee_payer"],
            "fee"                   => $post["fee"],
            // 订单10分钟倒计时
            "order_auto_close_time" => 10 * 60,
            // 购卡协议链接
            "purchase_agreement"    => conf("purchase_agreement"),
        ];
    }

    // 批发优惠后单价
    private function discountPrice($goods, $quantity)
    {
        $price = $goods->price;
        $list  = $goods->wholesale_discount_list;
        $sort  = array_column($list, 'num');
        array_multisort($sort, SORT_DESC, $list);
        foreach ($list as $v) {
            if ($quantity >= $v['num']) {
                $price = $v['price'];
                break;
            }
        }
        return $price;
    }
}