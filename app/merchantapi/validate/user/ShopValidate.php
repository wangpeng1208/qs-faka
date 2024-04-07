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

namespace app\merchantapi\validate\user;

use taoser\Validate;

class ShopValidate extends Validate
{
    protected $rule = [
        'id_name' => 'require',
        'id_card' => 'require',
        'id_card_front' => 'require',
        'id_card_back' => 'require',
        'product_type' => 'require',
        'product_desc' => 'require',
        'product_link' => 'require',
        'product_img' => 'require',
        'month_sales' => 'require',
        'no_content' => 'require|checkNoContent',
        'agree' => 'require|accepted',
    ];

    protected $message = [
        'id_name.require' => '身份证姓名不能为空',
        'id_card.require' => '身份证号码不能为空',
        'id_card_front.require' => '身份证正面不能为空',
        'id_card_back.require' => '身份证反面不能为空',
        'product_type.require' => '产品类型不能为空',
        'product_desc.require' => '产品描述不能为空',
        'product_link.require' => '产品官网不能为空',
        'product_img.require' => '产品截图不能为空',
        'month_sales.require' => '预估月销售额不能为空',
        'no_content.require' => '不参与内容不能为空',
        'no_content.checkNoContent' => '不参内容必须全部勾选',
        'agree.require' => '请勾选协议',
        'agree.accepted' => '请勾选协议',
    ];
    
    protected function checkNoContent($value, $rule, $data = [])
    {
        $requiredContents = ["色情", "赌博", "外挂", "诈骗", "盗版", "传销", "侵权", "套现"];
        return empty(array_diff($requiredContents, $value));
    }

    public function sceneSubmitAudit()
    {
        return $this->only([
            'id_name',
            'id_card',
            'id_card_front',
            'id_card_back',
            'product_type',
            'product_desc',
            'product_link',
            'product_img',
            'month_sales',
            'no_content',
            'agree',
        ]);
    }
}