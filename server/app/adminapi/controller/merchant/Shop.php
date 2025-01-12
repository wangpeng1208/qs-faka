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
use app\common\model\ShopList as ShopListModel;

/**
 * 商铺管理
 */
class Shop extends Base
{
    /**
     * @notes 商铺列表
     * @auth true
     */
    public function list()
    {
        $list = ShopListModel::order('id desc')->paginate($this->limit)->each(function ($item, $key) {
            $item->username = $item->user->username;
        });
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }
}