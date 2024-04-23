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

use app\adminapi\controller\Base;
use app\common\model\ChatMessage;
use app\common\model\User;

class Message extends Base
{
    public function userList()
    {
        // 用户列及类型
        $user_columu = ChatMessage::where('to_id', $this->user->id)
            ->group('from_id')
            ->order('id', 'desc')
            ->column('from_id,from_type');
        $data        = [];
        foreach ($user_columu as $key => $item) {
            $messagesList = ChatMessage::where('to_id', $this->user->id)
                ->where('from_id', $item['from_id'])
                ->order('id', 'desc')
                ->find();
            if ($item['from_type'] == 'merchant') {
                $data[$key]              = User::where('id', $item['from_id'])->field('id,username')->find();
                $data[$key]['content']   = $messagesList->content;
                $data[$key]['create_at'] = $messagesList->create_at;
                // 未读消息条数
                $data[$key]['unread'] = ChatMessage::where('to_id', $this->user->id)->where('from_id', $item['from_id'])->where('status', 0)->count();
            }
        }
        $this->success('获取成功', $data);
    }

    /**
     * 指定用户站内信数据
     */
    public function messageList()
    {
        $from_id = inputs('from_id/d');
        $to_message    = ChatMessage::where('to_id', $this->user->id)
            ->where('from_id', $from_id)
            ->order('id', 'desc')
            ->select();
        $message_to   = ChatMessage::where('from_id', $this->user->id)
            ->where('to_id', $from_id)
            ->order('id', 'desc')
            ->select();
        // 按id顺序合并 两个数组
        $data = array_merge($to_message->toArray(), $message_to->toArray());
        $this->success('获取成功', $data);
    }
}