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

namespace app\merchantapi\controller\finance;

use app\merchantapi\controller\Base;

class Money extends Base
{

    /**
     * @notes 资金日志列表
     * @auth false
     */
    public function log()
    {
        $time = strtotime("-30 day");
        $res  = $this->user->userMoneyLog()->whereTime('create_at', '>=', $time)->order("id desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

}