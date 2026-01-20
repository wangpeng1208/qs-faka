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

namespace app\merchantapi\controller\user;

use app\merchantapi\controller\Base;
use app\common\model\Channel;

class Payment extends Base
{
    /**
     * @notes 商户收款通道列表
     * @auth false
     */
    public function list()
    {
        $user_id  = $this->user->id;
        $res = Channel::where(["status" => 1, "type" => 1])->field(['id', 'title', 'is_available', 'paytype', 'lowrate', 'show_name', 'status'])->order("sort desc")->select()->each(
            function ($item) use ($user_id) {
                $item->user_id      = $user_id;
                $item->channel_id   = $item->id;
                $item->rate         = get_user_rate($user_id, $item->id);
                $item->product_name = get_paytype($item->paytype)?->name;
                $item->setAttr('type_text', $item->type_text);
                $item->ico = get_paytype($item->paytype)?->ico;
                unset ($item->id);
            }
        );
        $this->success('获取成功', $res);
    }
}