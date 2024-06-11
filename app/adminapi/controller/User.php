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
