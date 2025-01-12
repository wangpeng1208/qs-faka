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