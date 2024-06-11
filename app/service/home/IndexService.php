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

use app\common\model\{User as UserModel, Order as OrderModel, GoodsCard as GoodsCardModel};

class IndexService
{
    public function indexCount()
    {
        return [
            'orderCount' => OrderModel::where('status', 1)->count(),
            'CardsSum'   => GoodsCardModel::where('status', 2)->count(),
            'userCount'  => UserModel::where('status', 1)->count(),
            'startTime'  => strtotime(conf('site_start_time')),
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