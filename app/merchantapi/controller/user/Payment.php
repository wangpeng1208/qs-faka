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

namespace app\merchantapi\controller\user;

use app\common\model\ChannelAccount;
use app\merchantapi\controller\Base;
use app\common\model\Channel;
use app\common\model\UserChannel;

class Payment extends Base
{
    /**
     * @notes 商户收款通道列表
     * @auth false
     */
    public function list()
    {
        $user_id  = $this->user->id;
        $res = Channel::where(["status" => 1, "is_custom" => 0, "type" => 1])->field(['id', 'title', 'is_available', 'paytype', 'is_custom', 'lowrate', 'show_name', 'status'])->order("sort desc")->select()->each(
            function ($item) use ($user_id) {
                $item->user_id      = $user_id;
                $item->channel_id   = $item->id;
                $item->rate         = get_user_rate($user_id, $item->id);
                $item->product_name = get_paytype($item->paytype)->name; // 支付类型名
                $item->type_text = $item->type_text;
                $item->ico = get_paytype($item->paytype)->ico;
                // 状态需要判断
                if (UserChannel::where(['user_id' => $user_id, 'channel_id' => $item->id, 'status' => 0])->find()) {
                    $item->status = 0;
                }
                unset ($item->id);
            }
        );
        $this->success('获取成功', $res);
    }
}