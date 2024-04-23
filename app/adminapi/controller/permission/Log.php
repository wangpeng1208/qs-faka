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

namespace app\adminapi\controller\permission;

use app\common\model\AdminLog;
use app\adminapi\controller\Base;

class Log extends Base
{
    /**
     * 管理员日志列表
     * @auth false
     */
    public function list()
    {
        $where = $this->request->params([
            ['username', ''],
            ['ip', ''],
            ['date_range', ''],
            ['action', ''],
        ]);
        $res       = AdminLog::withSearch($where[0], $where[1])
            ->order("id desc")
            ->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 批量删除日志
     * @auth true
     */
    public function delBatch()
    {
        $ids = inputs("ids/a", []);
        if (empty($ids)) {
            $this->error("请选择要删除的日志！");
        }
        $res = AdminLog::destroy($ids);
        return $res ? $this->success("删除成功！") : $this->error("删除失败，请重试！");
    }
}