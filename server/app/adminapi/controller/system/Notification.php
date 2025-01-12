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
        $id   = inputs('id');
        $data = SystemNotification::find($id);
        return $this->success('获取成功', $data);
    }

    public function add()
    {
        $data = inputs('data/a', []);
        $res  = SystemNotification::create($data);
        if ($res) {
            return $this->success('添加成功');
        }
    }

    public function edit()
    {
        $data = inputs('data/a', []);
        $res  = SystemNotification::update($data);
        if ($res) {
            return $this->success('编辑成功');
        }
    }

    public function del()
    {
        $id  = inputs('id');

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
        $id = inputs('id');
        $data = SystemNotification::find($id);
        return $this->success('获取成功', $data);
    }

    /**
     * 设置通知信息的短信配置
     */
    public function setSmsConfig()
    {
        $data = inputs('data/a', []);
        $notification = SystemNotification::find($data['id']);
        $notification->is_sms = $data['status'];
        $notification->sms_config = $data;
        $res = $notification->save();
        if ($res) {
            return $this->success('设置成功');
        }
    }
}