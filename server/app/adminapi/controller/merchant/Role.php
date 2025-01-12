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

use app\adminapi\controller\Base;
use app\common\model\Channel as ChannelModel;
use app\common\model\UserRole as UserRoleModel;
use app\common\model\UserRoleRate as UserRoleRateModel;
use app\common\model\SystemMenu as SystemMenuModel;
use app\common\model\UserRoleRelation as UserRoleRelationModel;

class Role extends Base
{

    /**
     * @notes 用户分组列表
     * @auth true
     */
    public function list()
    {
        $res = UserRoleModel::paginate(20);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 用户分组列表label value
     */
    public function listsimple()
    {
        $res = UserRoleModel::field('id as value, name as label')->select();
        $this->success('获取成功', $res);
    }

    /**
     * @notes 用户分组详情
     */
    public function detail()
    {
        $id               = inputs('id/d', 0);
        $data             = UserRoleModel::where('id', $id)->find();
        $data['role_pc']  = array_map('intval', explode(',', $data['role_pc']));
        $data['role_wap'] = array_map('intval', explode(',', $data['role_wap']));
        $this->success('获取成功', $data);
    }


    /**
     * @notes 删除用户分组
     * @auth true
     */
    public function delete()
    {
        $id = inputs('id/d', 0);
        if ($id == 1) {
            return $this->error('默认分组不能删除');
        }
        // 查找分组内所有用户 修改为默认分组
        UserRoleRelationModel::where('role_id', $id)->update(['role_id' => 1]);
        UserRoleRateModel::where('role_id', $id)->delete();
        $res = UserRoleModel::where('id', $id)->delete();
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 获取商户菜单
     * @auth false
     */
    public function menu()
    {
        $where[] = ['status', '=', '1'];
        $where[] = ['app', '=', 'merchant'];
        $where[] = ['type', 'in', ['M', 'L', 'B']];
        $data    = SystemMenuModel::where($where)->select()->toArray();
        $tree    = [];
        foreach ($data as $value) {
            $tree[$value['id']] = $value;
        }
        foreach ($tree as $key => $value) {
            $tree[$value['pid']]['children'][] = &$tree[$key];
        }

        $pc = isset($tree[0]['children']) ? $tree[0]['children'] : [];
        $this->success('获取成功', [
            'pc'  => $pc,
            'wap' => [],
        ]);
    }

    /**
     * @notes 添加商户分组
     * @auth true
     */
    public function add()
    {
        $data = [
            'role_pc'  => implode(',', inputs('role_pc/a')),
            'role_wap' => implode(',', inputs('role_wap/a')),
            'name'     => inputs('name', '未知分组'),
            'remark'   => inputs('remark', ''),
        ];

        UserRoleModel::create($data);
        return $this->success('操作成功');
    }

    /**
     * @notes 编辑商户分组
     * @auth true
     */
    public function edit()
    {
        $data = [
            'id'       => inputs('id'),
            'role_pc'  => implode(',', inputs('role_pc/a')),
            'role_wap' => implode(',', inputs('role_wap/a')),
            'name'     => inputs('name', '未知分组'),
            'remark'   => inputs('remark', ''),
        ];
        UserRoleModel::update($data);
        return $this->success('操作成功');
    }

    /**
     * @notes 获取分组通道费率
     * @auth true
     */
    public function rateList()
    {
        $id   = inputs('id/d', 0);
        $role = UserRoleModel::where('id', $id)->find();
        $res  = ChannelModel::where('type', 1)->paginate($this->limit)->each(function ($item) use ($role, $id) {
            $role_rate = $role->rate()->where(['channel_id' => $item->id, 'role_id' => $id])->find();
            if (empty($role_rate)) {
                $item->rate       = $item->lowrate * 1000;
                $item->status     = 0;
                $item->status_tip = '未设置，当前使用通道费率';
            } else {
                $item->rate       = $role_rate->rate * 1000;
                $item->status     = $role_rate->status;
                $item->status_tip = '已设置';
            }
        });
        $this->success('获取成功', [
            'role'  => $role,
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 编辑分组通道费率
     * @auth true
     */
    public function editRate()
    {
        $data = [
            'role_id'    => inputs('role_id/d', 0),
            'channel_id' => inputs('channel_id/d', 0),
            'status'     => inputs('status/d', 0),
            'rate'       => inputs('rate/d', 0) / 1000,
        ];
        $info = UserRoleRateModel::where(['role_id' => $data['role_id'], 'channel_id' => $data['channel_id']])->find();
        if (empty($info)) {
            $res = UserRoleRateModel::create($data);
        } else {
            $res = UserRoleRateModel::update($data, [
                'role_id'    => $data['role_id'],
                'channel_id' => $data['channel_id'],
            ]);
        }
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }
}
