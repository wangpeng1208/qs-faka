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

namespace app\adminapi\controller\goods;

use app\common\model\Goods as GoodsModel;
use app\adminapi\controller\Base;

class Goods extends Base
{
    /**
     * @notes 商品列表
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['id', ''],
            ['user_id', ''],
            ['username', ''],
            ['name', ''],
            ['status', ''],
            ['date_range', ''],
            ['is_freeze', '']
        ]);
        $res   = GoodsModel::withTrashed()
            ->withSearch($where[0], $where[1])
            ->order("id desc")
            ->paginate($this->limit)
            ->each(function ($item, $key) {
                $item->username = $item->user->username;
            });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 商品状态
     * @auth true
     */
    public function status()
    {
        $id    = input("id/d", 0);
        $goods = GoodsModel::findOrFail($id);
        $goods->is_freeze == 1 && $this->error("请先解冻商品后再上架！");
        $goods->status = $goods->status == 1 ? 0 : 1;
        $res           = $goods->save();
        $text          = $goods->status == 1 ? "上架" : "下架";
        return $res ? $this->success($text . "成功！") : $this->error($text . "失败，请重试！");
    }

    /**
     * @notes 冻结商品|解冻商品
     * @auth true
     */
    public function freeze()
    {
        $id    = input("id/d", 0);
        $goods = GoodsModel::findOrFail($id);

        $goods->is_freeze = $goods->is_freeze == 1 ? 0 : 1;
        //冻结商品时，自动下架；解冻时，不自动上架
        $goods->status = $goods->is_freeze == 1 ? 0 : 0;
        $res           = $goods->save();
        $text          = $goods->is_freeze == 0 ? "冻结" : "解冻";
        return $res ? $this->success($text . "成功！") : $this->error($text . "失败，请重试！");
    }

    /**
     * @notes 删除商品|恢复商品
     * @auth true
     */
    public function del()
    {
        $id  = input("id/d", 0);
        $val = input("val/d", 0);
        // 强制删除
        if ($val == 1) {
            $res = GoodsModel::destroy($id, true);
            return $res ? $this->success("强制删除成功！") : $this->error("删除失败，请重试！");
        }
        $goods = GoodsModel::withTrashed()->findOrFail($id);
        // 判断商品是否被删除
        if ($goods->delete_at && $val == 0) {
            // 恢复商品
            $res = $goods->restore();
            return $res ? $this->success("恢复成功！") : $this->error("恢复失败，请重试！");
        } else {
            // 删除商品
            $res = $goods->delete();
            return $res ? $this->success("删除成功！") : $this->error("删除失败，请重试！");
        }
    }

}
