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
        $id    = inputs("id/d", 0);
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
        $id    = inputs("id/d", 0);
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
        $id  = inputs("id/d", 0);
        $val = inputs("val/d", 0);
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
