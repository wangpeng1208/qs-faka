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

class RoleAuth
{
    public function cacheUserMenuData($user)
    {
        $where = [['status', '=', '1'], ['app', '=', 'admin'], ['type', 'in', ['M', 'L', 'B']]];
        if ($user->id === 1) {
            $data = SystemMenuModel::where($where)->select()->toArray();
        } else {
            $roles   = $user->role->toArray();
            $rules   = array_unique(array_merge(...array_map(function ($item) {
                return explode(',', $item['rules']);
            }, $roles)));
            $where[] = ['id', 'in', $rules];
            $data    = SystemMenuModel::where($where)->select()->toArray();
        }
        $menu  = array_filter($data, function ($item) {
            return in_array($item['type'], ['M', 'L']);
        });
        $perms = array_filter($data, function ($item) {
            return !empty ($item['perms']);
        });
        $data  = ['menu' => $menu, 'perms' => $perms];
        return $data;
    }

    // 获取用户的权限
    public function getUserMenuData($user)
    {
        $perms = $this->cacheUserMenuData($user);
        return $perms;
    }

    public function getAllMenu($user)
    {
        $where = [['status', '=', '1'], ['app', '=', 'admin'], ['type', '=', 'M']];
        if ($user->id === 1) {
            $data = SystemMenuModel::where($where)->select()->toArray();
        } else {
            $roles   = $user->role->toArray();
            $rules   = array_unique(array_merge(...array_map(function ($item) {
                return explode(',', $item['rules']);
            }, $roles)));
            $where[] = ['id', 'in', $rules];
            $data    = SystemMenuModel::where($where)->select()->toArray();
        }
        $menu = array_filter($data, function ($item) {
            return in_array($item['type'], ['M']);
        });
        return $menu;
    }

    public function getUserMenu($user)
    {
        $menuData = $this->getUserMenuData($user);
        $data     = $menuData['menu'];
        foreach ($data as $key => $item) {
            if ($item['pid'] == 0) {
                $data[$key]['path'] = '/admin/' . $item['path'];

            } else if (strpos($item['redirect'], 'http') === 0) {
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
            if (!empty($item['keep_alive'])) {
                $data[$key]['meta']['keepAlive'] = $item['keep_alive'];
            }
            if (empty($data[$key]['redirect'])) {
                unset($data[$key]['redirect']);
            }
            unset($data[$key]['title']);
            unset($data[$key]['icon']);
            unset($data[$key]['hidden']);
            unset($data[$key]['orderNo']);
            unset($data[$key]['perms']);
            unset($data[$key]['keep_alive']);
            unset($data[$key]['type']);
            unset($data[$key]['status']);
            unset($data[$key]['app']);
        }

        $tree = [];
        foreach ($data as $item) {
            $tree[$item['id']] = $item;
        }
        foreach ($tree as $key => $item) {
            $tree[$item['pid']]['children'][] = &$tree[$key];
        }

        $tree = $tree[0]['children'] ?? [];
        return $tree;
    }

}