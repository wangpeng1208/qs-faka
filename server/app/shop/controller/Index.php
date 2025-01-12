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

namespace app\shop\controller;

use app\common\model\{Goods as GoodsModel, GoodsCoupon};
use app\service\sms\SmsService;

class Index extends Base
{

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
        $cate_id = inputs("cate_id/d", 0);
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
        $coupon_code = inputs("coupon_code");
        $cate_id     = inputs("cate_id/d", 0);
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
