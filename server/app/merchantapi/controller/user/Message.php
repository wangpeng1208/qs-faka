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
