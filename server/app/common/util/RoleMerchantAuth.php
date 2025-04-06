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

namespace app\common\util;

use app\common\model\SystemMenu as SystemMenuModel;

class RoleMerchantAuth
{
    // 检查权限
    public function check($path, $user)
    {
        // $path 如果以 / 开头的路径 需要去掉 / 
        $path  = $path[0] === '/' ? substr($path, 1) : $path;
        $perms = $this->getUserPerms($user);
        return in_array($path, $perms) ? true : false;
    }

    public function getUserPerms($user)
    {
        $menuData  = $this->getUserMenuData($user);
        $permsData = $menuData['perms'];
        $roles     = $user->role->toArray();
        // roles数组的每一项里的rules进行过滤合并
        $rules = explode(',', $roles['role_pc']);
        // $permsData里与$rules里的id相同的perms，只返回$permsData里的perms
        $perms = array_reduce($permsData, function ($carry, $item) use ($rules) {
            if (in_array($item['id'], $rules)) {
                $carry[] = $item['perms'];
            }
            return $carry;
        }, []);
        return $perms;
    }

    public function cacheUserMenuData($user)
    {
        $where   = [];
        $where[] = ['status', '=', '1'];
        $where[] = ['app', '=', 'merchant'];
        $where[] = ['type', 'in', ['M', 'L', 'B']];

        $data = SystemMenuModel::where($where)->select()->toArray();

        // M L 的数组
        $menu = array_filter($data, function ($item) {
            return in_array($item['type'], ['M', 'L']);
        });
        // perms不为空的数组
        $perms = array_filter($data, function ($item) {
            return !empty ($item['perms']);
        });

        $data = [
            'menu'  => $menu,
            'perms' => $perms,
        ];
        return $data;
    }

    // 获取用户的权限
    public function getUserMenuData($user)
    {
        return $this->cacheUserMenuData($user);
    }

    public function getUserMenu($user)
    {
        $menuData = $this->getUserMenuData($user);
        $data     = $menuData['menu'];
        foreach ($data as $key => $item) {
            if ($item['pid'] == 0) {
                $data[$key]['path'] = '/merchant/' . $item['path'];

            } else if (strpos($item['path'], 'http') === 0) {
                $data[$key]['meta']['frameSrc'] = $item['redirect'];
                unset($data[$key]['redirect']);
            }
            $data[$key]['meta']['title'] = $item['title'];
            if (!empty($item['icon'])) {
                $data[$key]['meta']['icon'] = $item['icon'];
            }
            if (!empty($item['hidden'])) {
                $data[$key]['meta']['hidden'] = true;
            }
            if (!empty($item['orderNo'])) {
                $data[$key]['meta']['orderNo'] = $item['orderNo'];
            }
            if (empty($data[$key]['redirect'])) {
                unset($data[$key]['redirect']);
            }
            unset($data[$key]['title']);
            unset($data[$key]['icon']);
            unset($data[$key]['hidden']);
            unset($data[$key]['orderNo']);
            unset($data[$key]['perms']);
        }

        $tree = [];
        foreach ($data as $item) {
            $tree[$item['id']] = $item;
        }
        foreach ($tree as $key => $item) {
            $tree[$item['pid']]['children'][] = &$tree[$key];
        }

        $tree = isset($tree[0]['children']) ? $tree[0]['children'] : [];
        return $tree;
    }

}