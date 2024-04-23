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

use app\merchantapi\controller\Base;

class Message extends Base
{
    public function list()
    {
        $status = inputs("status", '');
        $list   = $this->user->messagesByTo()->when(
            $status !== '',
            function ($query) use ($status) {
                $query->where("status", $status);
            }
        )->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->content = strip_tags($item->content);
        });
        $this->success("获取成功", [
            "list"  => $list->items(),
            "count" => $list->total()
        ]);
    }
    // 未读消息数量
    public function unReadCount()
    {
        $count = $this->user->messagesByTo()->where("status", 0)->count();
        $this->success("获取成功", $count);
    }

    // 标记已读
    public function read()
    {
        $id      = inputs("id");
        $message = $this->user->messagesByTo()->find($id);

        $message->status = 1;
        $message->save();
        $this->success("操作成功");
    }

    // 标记全部已读
    public function readAll()
    {
        $this->user->messagesByTo()->update(["status" => 1]);
        $this->success("操作成功");
    }

    // 删除消息
    public function del()
    {
        $id      = inputs("id");
        $message = $this->user->messagesByTo()->find($id);
        $message->delete();
        $this->success("操作成功");
    }
}
