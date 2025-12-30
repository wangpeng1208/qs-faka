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

use app\common\model\SystemMenu as SystemMenuModel;
use app\adminapi\controller\Base;

class Menu extends Base
{
    /**
     * @notes 菜单列表
     * @auth true
     */
    public function list()
    {
        $app  = inputs('app', 'admin');
        $list = SystemMenuModel::where(['app' => $app])->order('orderNo asc')->select()->toArray();
        $tree = [];
        foreach ($list as $item) {
            $tree[$item['id']] = $item;
        }
        foreach ($tree as $key => $item) {
            $tree[$item['pid']]['children'][] = &$tree[$key];
        }

        $tree = isset($tree[0]['children']) ? $tree[0]['children'] : [];
        // 去掉所有id和pid
        foreach ($tree as $key => $item) {
            unset($tree[$key]['pid']);
        }
        $this->success('获取成功', [
            'list' => $tree
        ]);
    }

    /**
     * @notes 菜单详情
     * @auth false
     */
    public function detail()
    {
        $id   = inputs('id/d', 0);
        $data = SystemMenuModel::where(['id' => $id])->find();
        $this->success('获取成功', $data);
    }

    /**
     * @title 路由name计算
     * @description 路由name计算
     */
    private function computeName($app, $pid, $name)
    {
        // 如果 $name 以 http 开头，直接返回
        if (strpos($name, 'http') === 0) {
            return $name;
        }
        if ($pid == 0) {
            $pname = $app;
        } else {
            $pname = SystemMenuModel::where(['id' => $pid])->value('name');
        }
        return $pname . ucfirst($name);
    }

    private function post()
    {
        $data = [
            'app'       => inputs('app', 'admin'),
            'id'        => inputs('id/d', 0),
            'pid'       => inputs('pid'),
            'title'     => inputs('title'),
            'path'      => inputs('path'),
            'component' => inputs('component'),
            'icon'      => inputs('icon'),
            'orderNo'   => inputs('orderNo'),
            'hidden'    => inputs('hidden') ? 1 : 0,
            'redirect'  => inputs('redirect'),
            'type'      => inputs('type', 'L'),
            'perms'     => inputs('perms'),
        ];
        // 数据验证
        $validate = new \app\adminapi\validate\permission\MenuValidate;
        if ($data['type'] == 'M') {
            $validate->scene('menu')->failException(true)->check($data);
        }
        if ($data['type'] == 'L') {
            $validate->scene('list')->failException(true)->check($data);
        }
        if ($data['type'] == 'B') {
            $validate->scene('button')->failException(true)->check($data);
        }
        return $data;
    }

    /**
     * @notes 菜单添加
     * @auth true
     */
    public function add()
    {
        $data = $this->post();
        unset($data['id']);
        $data['name'] = $this->computeName($data['app'], $data['pid'], $data['path']);
        // 一级目录默认为Layout
        if ($data['type'] == 'L' && $data['pid'] == 0) {
            $data['component'] = 'Layout';
        }
        // 二级目录默认为BLANK
        if ($data['type'] == 'L' && $data['pid'] > 0) {
            $data['component'] = 'BLANK';
        }
        // $data['path']是url时，component为IFRAME
        if (strpos($data['path'], 'http') === 0) {
            $data['component'] = 'Iframe';
        }

        $res = SystemMenuModel::create($data);
        // 更新排序
        $res->orderNo = $res->id;
        $res->save();
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 菜单编辑
     * @rule true
     */
    public function edit()
    {
        $data = $this->post();
        $res  = SystemMenuModel::update($data);
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 菜单删除
     * @auth true
     */
    public function del()
    {
        $id  = inputs('id/d', 0);
        $res = SystemMenuModel::destroy($id);
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 菜单树
     * @auth false
     */
    public function treeSimple()
    {
        $where[] = ['app', '=', inputs('app', 'admin')];
        $where[] = ['type', 'in', ['M', 'L']];
        $list    = SystemMenuModel::where($where)->field('id as value,pid,title as label')->order('orderNo asc')->select()->toArray();
        $tree    = [];
        foreach ($list as $item) {
            $tree[$item['value']] = $item;
        }
        foreach ($tree as $key => $item) {
            $tree[$item['pid']]['children'][] = &$tree[$key];
        }
        $tree = isset($tree[0]['children']) ? $tree[0]['children'] : [];

        array_unshift($tree, ['value' => 0, 'pid' => 0, 'label' => '顶级菜单']);
        return $this->success('获取成功', [
            'list' => $tree
        ]);
    }

}
