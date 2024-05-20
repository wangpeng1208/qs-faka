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

namespace app\common\util;

use app\common\model\SystemMenu as SystemMenuModel;
use support\Cache;

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
        // echo $roles['role_pc'];
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
        Cache::tag('merchant_user_menu')->set('merchant_user_menu_' . $user->id, $data);
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
                // todo /merchant/ 自定义网站后台路径配置 前端路由跳转需要使用别名模式
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