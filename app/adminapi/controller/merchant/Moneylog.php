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

namespace app\adminapi\controller\merchant;

use app\common\model\UserMoneyLog;
use app\adminapi\controller\Base;

class MoneyLog extends Base
{

    /**
     * @notes 用户资金变动记录
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['user_id', ''],
            ['username', ''],
            ['business_type', ''],
            ['date_range', '']
        ]);
        $res   = UserMoneyLog::withSearch($where[0], $where[1])->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->username      = $item->user->username;
            $item->hander        = $item->from_user_id == 0 ? '管理员' : '未知';
            $item->business_type = business_types()[$item->business_type];
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);

    }

    /**
     * @notes 资金变动类型
     * @auth false
     */
    public function businessTypes()
    {
        $business_types = business_types();
        $this->success('获取成功', $business_types);
    }
}