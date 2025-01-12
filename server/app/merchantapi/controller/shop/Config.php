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

namespace app\merchantapi\controller\shop;

use app\merchantapi\controller\Base;

class Config extends Base
{
    /**
     * 获取店铺设置
     * @auth false
     */
    public function index()
    {
        $this->success('获取成功', $this->user->shop);
    }

    /**
     * @notes 设置店铺设置
     * @auth false
     */
    public function saveConfig()
    {
        $shop_name = inputs("shop_name/s", "");
        $res       = check_wordfilter($shop_name);
        if ($res) {
            $this->error("店铺名称包含敏感词汇“" . $res . "”！");
        }
        $shop_notice = inputs("shop_notice/s", "");
        $res         = check_wordfilter($shop_notice);
        if ($res) {
            $this->error("店铺公告包含敏感词汇“" . $res . "”！");
        }

        $shop                       = $this->user->shop;
        $shop->shop_close           = inputs("shop_close/d", 0);
        $shop->show_contact         = inputs("show_contact/d", 0);
        $shop->shop_contact         = inputs("shop_contact/s", "");
        $shop->shop_name            = inputs("shop_name/s", "");
        $shop->shop_notice          = inputs("shop_notice/s", "");
        $shop->shop_notice_show     = inputs("shop_notice_show/d", 0);
        $shop->stock_display        = inputs("stock_display/d", 2);
        $shop->fee_payer            = inputs("fee_payer/d", 0);
        $shop->shop_close_notice    = inputs("shop_close_notice/s", "");
        $shop->user_notice_auto_pop = inputs("user_notice_auto_pop/d", 0);
        $shop->shop_logo            = inputs("shop_logo/s", "");
        $result                     = $shop->save();
        return $result ? $this->success("保存成功") : $this->error("保存失败");
    }

}