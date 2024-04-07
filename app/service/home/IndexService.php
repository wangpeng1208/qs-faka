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

namespace app\service\home;

use app\common\model\{User as UserModel, Order as OrderModel, GoodsCard as GoodsCardModel};
use think\facade\Cache;

class IndexService
{
    public function indexCount()
    {
        // 虚拟数据系数
        if (!Cache::get('orderCount')) {
            Cache::set('orderCount', OrderModel::where('status', 1)->count(), 3600);
            Cache::set('CardsSum', GoodsCardModel::where('status', 2)->count(), 3600);
            Cache::set('userCount', UserModel::where('status', 1)->count(), 3600);
        } else {
            Cache::inc('orderCount', rand(1, 5));
            Cache::inc('CardsSum', rand(1, 30));
            Cache::inc('userCount', rand(1, 3));
        }
        return [
            'orderCount' => Cache::get('orderCount', OrderModel::where('status', 1)->count()),
            'CardsSum'   => Cache::get('CardsSum', GoodsCardModel::where('status', 2)->count()),
            'userCount'  => Cache::get('userCount', UserModel::where('status', 1)->count()),
        ];
    }

    public function siteConfig()
    {
        return [
            'pc_template'            => 'default',
            'mobile_template'        => 'default',
            'site_name'              => conf('site_name'),
            'site_logo'              => conf('site_logo'),
            'site_status'            => conf('site_status'),
            'site_domain'            => conf('site_domain'),
            'site_info_qq'           => conf('site_info_qq'),
            'site_info_email'        => conf('site_info_email'),
            'site_info_qq_desc'      => conf('site_info_qq_desc'),
            'site_info_copyright'    => conf('site_info_copyright'),
            'site_shop_copyright'    => conf('site_shop_copyright'),
            'site_info_icp'          => conf('site_info_icp'),
            //隐私政策
            'privacy_policy_id'      => conf('privacy_policy_id'),
            // 注册协议
            'register_agreement_id'  => conf('register_agreement_id'),
            // 商品发布条例
            'goods_release_id'       => conf('goods_release_id'),
            // 禁售目录
            'prohibited_catalog_id'  => conf('prohibited_catalog_id'),
            // 侵权举报
            'infringement_report_id' => conf('infringement_report_id'),
            'merchant_logo'          => conf('merchant_logo'),
            'merchant_logo_sm'       => conf('merchant_logo_sm'),
        ];
    }
}