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

namespace app\adminapi\controller\merchant;

use app\adminapi\controller\Base;
use app\common\model\ShopVerify as ShopVerifyModel;
use app\common\model\ShopList as ShopListModel;
use app\service\message\MessageService;

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