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

namespace app\adminapi\controller;

use think\facade\Db;
use support\Cache;
use app\common\util\RoleAuth;
use app\common\model\SystemMenu;

class User extends Base
{

    /**
     * 用户资料及权限
     * @auth false
     */
    public function getAdminUserInfo(RoleAuth $roleAuth)
    {
        $visitor_id = inputs('visitor_id/d', 0);
        if ($visitor_id) {
            $data = array_unique(array_merge(Cache::get($visitor_id) ?? [], [$this->user->id]));
            Cache::set($visitor_id, $data, 300);
        }

        $this->success('success', [
            'user'  => $this->user,
            'perms' => [],
        ]);
    }

    /**
     * 路由菜单
     * @auth false
     */
    public function getAdminUserMenu(RoleAuth $roleAuth)
    {
        $menu = $roleAuth->getUserMenu($this->user);
        $this->success('success', $menu);
    }

    /**
     * 用户自定义快捷菜单
     * @auth false
     */
    public function getAdminUserShortcutMenu(RoleAuth $roleAuth)
    {
        $menu_ids     = Db::name('admin_menu')->where('user_id', $this->user->id)->column('menu_id');
        $shortcutMenu = SystemMenu::where('id', 'in', $menu_ids)->select()->toArray();
        $this->success('success', $shortcutMenu);
    }

    /**
     * 用户自定义快捷菜单添加
     * @auth false
     */
    public function addAdminUserShortcutMenu()
    {
        $menuId = $this->request->post('menu_id');
        $menu   = Db::name('admin_menu')->where('user_id', $this->user->id)->where('menu_id', $menuId)->find();
        if ($menu) {
            $this->error('已添加');
        }
        $data = [
            'user_id' => $this->user->id,
            'menu_id' => $menuId,
        ];
        Db::name('admin_menu')->insert($data);
        $this->success('添加成功');
    }

    /**
     * 用户自定义快捷菜单删除
     * @auth false
     */
    public function deleteAdminUserShortcutMenu()
    {
        $menuId = $this->request->post('menu_id');
        $menu   = Db::name('admin_menu')->where('user_id', $this->user->id)->where('menu_id', $menuId)->find();
        if (!$menu) {
            $this->error('未添加');
        }
        Db::name('admin_menu')->where('user_id', $this->user->id)->where('menu_id', $menuId)->delete();
        $this->success('删除成功');
    }

    /**
     * 权限下所有菜单
     * @auth false
     */
    public function getAdminAllMenu(RoleAuth $roleAuth)
    {
        $allMenu = $roleAuth->getAllMenu($this->user);
        $this->success('success', $allMenu);
    }
}
