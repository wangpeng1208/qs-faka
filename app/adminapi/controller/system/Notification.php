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

namespace app\adminapi\controller\system;

use app\adminapi\controller\Base;
use app\common\model\SystemNotification;

class Notification extends Base
{
    public function list()
    {
        $res = SystemNotification::paginate($this->limit);
        return $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    public function detail()
    {
        $id   = input('id');
        $data = SystemNotification::find($id);
        return $this->success('获取成功', $data);
    }

    public function add()
    {
        $data = input('data/a', []);
        $res  = SystemNotification::create($data);
        if ($res) {
            return $this->success('添加成功');
        }
    }

    public function edit()
    {
        $data = input('data/a', []);
        $res  = SystemNotification::update($data);
        if ($res) {
            return $this->success('编辑成功');
        }
    }

    public function del()
    {
        $id  = input('id');

        $data = SystemNotification::find($id);
        if($data->system){
            return $this->error('系统通知不能删除');
        }
        $res = $data->delete();
        if ($res) {
            return $this->success('删除成功');
        }
    }

    /**
     * 获取通知信息的短信配置
     */
    public function getSmsConfig()
    {
        $id = input('id');
        $data = SystemNotification::find($id);
        return $this->success('获取成功', $data);
    }

    /**
     * 设置通知信息的短信配置
     */
    public function setSmsConfig()
    {
        $data = input('data/a', []);
        $notification = SystemNotification::find($data['id']);
        $notification->is_sms = $data['status'];
        $notification->sms_config = $data;
        $res = $notification->save();
        if ($res) {
            return $this->success('设置成功');
        }
    }
}