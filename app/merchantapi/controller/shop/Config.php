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

namespace app\merchantapi\controller\shop;

use app\common\model\ShopVerify;
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

    /**
     * 店铺提交审核
     * @auth false
     */
    public function submitAudit()
    {
        $data = [
            'user_id'       => $this->user->id, // 用户id
            // 身份证姓名
            'id_name'       => inputs('id_name/s', ''),
            // 身份证号码
            'id_card'       => inputs('id_card/s', ''),
            // 证件类型 1:身份证 2:营业执照
            'id_type'       => inputs('id_type/d', 1),
            // 身份证正面
            'id_card_front' => inputs('id_card_front/s', ''),
            // 身份证反面
            'id_card_back'  => inputs('id_card_back/s', ''),
            // 产品名称
            'product_name'  => inputs('product_name/s', ''),
            // 产品类型
            'product_type'  => inputs('product_type/s', ''),
            // 产品描述
            'product_desc'  => inputs('product_desc/s', ''),
            // 产品官网
            'product_link'  => inputs('product_link/s', ''),
            // 产品截图
            'product_img'   => inputs('product_img/s', ''),
            // 预估月销售额
            'month_sales'   => inputs('month_sales/s', ''),
            // 不参与一下内容 色情 赌博 外挂 诈骗 盗版 传销 侵权 套现
            'no_content'    => inputs('no_content/s', ''),
            // 勾选协议
            'agree'         => inputs('agree/d', 0),
            'create_at'     => time(),
        ];
        // 数据验证
        $validate = new \app\merchantapi\validate\user\ShopValidate();
        $validate->scene('submitAudit')->failException(true)->check($data);


        $result = ShopVerify::create($data);

        if ($result !== false) {

            $this->user->shop()->save([
                'shop_verify' => -1,
                'create_at'   => time(),
            ]);

            $this->success("提交成功！");
        } else {
            $this->error("提交失败，请重试！");
        }
    }

}