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

namespace app\adminapi\controller\permission;

use app\common\model\AdminUser as AdminUserModel;
use app\adminapi\controller\Base;

class Admin extends Base
{

    /**
     * @notes 管理员列表
     * @auth true
     * @param AdminUserModel $user
     * @return void
     */
    public function list(AdminUserModel $user)
    {
        $where = $this->request->params([
            ['username', ''],
            ['nickname', ''],
            ['status', ''],
            ['id', ''],
        ]);
        $res   = $user->withSearch($where[0], $where[1])->order("id asc")->paginate($this->limit)->each(function ($item, $key) {
            $names = '';
            if(!empty($item->role)){
                foreach ($item->role as $key => $value) {
                    $names .= $value->name . ',';
                }
            }
            $item->role_name = rtrim($names, ',');
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 管理员详情
     * @auth false
     * @param AdminUserModel $user
     * @return void
     */
    public function detail(AdminUserModel $user)
    {
        $id   = inputs('id/d', 0);
        $info = $user->with('role')->find($id);
        unset($info->password);
        $this->success('获取成功', $info);
    }

    /**
     * @notes 管理员添加/编辑
     * @auth true
     * @return void
     */
    public function edit()
    {
        $data = [
            'id'       => inputs('id/d', 0),
            'username' => inputs('username'),
            'password' => inputs('password'),
            'nickname' => inputs('nickname'),
            'avatar'   => inputs('avatar'),
            'email'    => inputs('email'),
            'mobile'   => inputs('mobile'),
            'status'   => inputs('status'),
        ];
        if ($data['id']) {
            if (!$data['password']) {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $res = AdminUserModel::update($data);
        } else {
            unset($data['id']);
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $res = AdminUserModel::create($data);
        }

        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * @notes 管理员删除
     * @auth true
     * @return void
     */
    public function delete()
    {
        // id 为 1 的用户不能删除
        $id = inputs('id/d', 0);
        if ($id == 1) {
            $this->error('不能删除超级管理员');
        }
        $res = AdminUserModel::destroy($id);
        if ($res) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * @notes 获取管理员角色
     * @auth false
     * @return void
     */
    public function getRoles()
    {
        $id   = inputs('id/d', 0);
        $user = AdminUserModel::find($id);
        $roles = $user->role;
        // 取roles中的id 成字符串用,分割
        $ids = [];
        foreach ($roles as  $role) {
            $ids[] = $role->id;
        }
        $data['id'] = $id;
        $data['role'] = implode(',', $ids);
        $this->success('获取成功', $data);
    }

    /**
     * @notes 设置管理员角色
     * @auth true
     * @return void
     */
    public function setRoles()
    {
        $admin_id   = inputs('id/d', 0);
        $roleIds = inputs('role/a', []);
        $user    = AdminUserModel::findOrFail($admin_id);
        // clear old role
        $user->roles()->delete();
        // add new role
        $data = [];
        foreach ($roleIds as $role_id) {
            $data[] = [
                'admin_id' => $admin_id,
                'role_id'  => $role_id,
            ];
        }
        $user->roles()->saveAll($data);
        $this->success('操作成功');
    }
}