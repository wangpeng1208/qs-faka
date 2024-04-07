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

namespace app\shop\controller;

use app\common\model\{Goods as GoodsModel, User as UserModel, GoodsCoupon};
use app\service\sms\SmsService;

class Index extends Base
{
    /**
     * todo 购卡协议
     *
     * @return void
     */
    public function getProtocol()
    {
        $user_id = input("userid/s");
        $shop    = UserModel::find($user_id);
        if ($shop->shop_gouka_protocol_pop) {
            $buy_protocol = conf("buy_protocol");
            if (!empty($buy_protocol)) {
                $this->success(htmlspecialchars_decode($buy_protocol));
            }
        }
    }

    public function index()
    {
        $this->init();
        $fee_play = $this->shop->fee_payer ?: conf("fee_payer");
        $this->success('success', [
            "token"          => $this->token,
            "shop"           => $this->shop,
            "qrcode"         => $this->relation->link,
            "categorys"      => $this->goods_category,
            "pcTemplate"     => $this->pcTemplate,
            "mobileTemplate" => $this->mobileTemplate,
            "userChannels"   => $this->channel($this->shop->user_id),
            "goods"          => $this->goods,
            "fee_play"       => $fee_play,
        ]);
    }


    public function getGoodsListJson()
    {
        $cate_id = input("cate_id/d", 0);
        if (empty($cate_id)) {
            $cate_id = $this->goods_category[0]['id'];
        }

        $goods = GoodsModel::where(["cate_id" => $cate_id, "status" => 1])->visible($this->goods_visible)->order("sort DESC")->select()->each(function ($item) {
            $item->sms_price         = (new SmsService())->getSmsPrice('order_to_buyer');
            $item->stockStr          = $item->is_cross ? "库存一般" : $this->stock_display($item);
            $item->user              = null;
            $item->cards_stock_count = $item->cards_stock_count ?: 0;
            if (count($item->addtion_give) > 0) {
                // 向$item->addtion_give的每个项目里添加商品名
                foreach ($item->addtion_give as $key => $value) {
                    $temp                     = $item->addtion_give;
                    $temp[$key]['goods_name'] = GoodsModel::where('id', $value['good_id'])->value('name');
                    $item->addtion_give = $temp;
                }
            }
        });
        return json([
            'code' => 1,
            'data' => $goods
        ]);
    }

    public function getCouponInfo()
    {
        $coupon_code = input("coupon_code");
        $cate_id     = input("cate_id/d", 0);
        $coupon      = GoodsCoupon::where(["code" => $coupon_code, 'cate_id' => $cate_id])->find();
        if (empty($coupon)) {
            return json([
                'code' => 0,
                'msg'  => '优惠券不存在！'
            ]);
        }
        if ($coupon->status === 0) {
            return json([
                'code' => 0,
                'msg'  => '优惠券已被其他订单占用！'
            ]);
        }
        if ($coupon->status == 2) {
            return json([
                'code' => 0,
                'msg'  => '优惠券已被使用！'
            ]);
        }
        if ($coupon->expire_at < time()) {
            return json([
                'code' => 0,
                'msg'  => '优惠券已过期！'
            ]);
        }
        return json([
            'code' => 1,
            'data' => $coupon
        ]);
    }
}
