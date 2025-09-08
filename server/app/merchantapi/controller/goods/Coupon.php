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

namespace app\merchantapi\controller\goods;

use app\common\model\GoodsCoupon as GoodsCouponModel;
use app\merchantapi\controller\Base;

class Coupon extends Base
{
    /**
     * 优惠券过期 打开时自动标记删除
     */
    private function expire()
    {
        $this->user->goodsCoupon()->where(["status" => 1])->where("expire_at", "< time", date("Y-m-d H:i:s", time()))->update(["delete_at" => time()]);
    }

    /**
     * 优惠券列表
     */
    public function index()
    {
        $this->expire();
        $where = $this->request->params([
            ['cate_id', ''],
            ['status', ''],
        ]);
        $list  = $this->user->goodsCoupon()
            ->with('category')  // 预加载 category
            ->withSearch($where[0], $where[1])
            ->order("id desc")
            ->paginate($this->limit)
            ->each(function ($item) {
                $item->cate_name = $item['cate_id'] == 0 ? '全部' : $item->category->name;
            });
        return $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }

    /**
     * 优惠券回收站
     * @return mixed
     */
    public function trash()
    {
        $this->expire();
        $where = $this->request->params([
            ['cate_id', ''],
            ['status', ''],
        ]);
        $list  = $this->user->goodsCoupon()
            ->with('category')
            ->withSearch($where[0], $where[1])
            ->onlyTrashed()
            ->order("delete_at desc, id desc")
            ->paginate($this->limit)
            ->each(function ($item) {
                $item->cate_name = $item->cate_id == 0 ? '全部' : $item->category->name;
                $item->status = $item->expire_day;
            });
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }

    /**
     * @notes 添加优惠券
     * @auth true
     */
    public function add()
    {
        $validate = new \app\merchantapi\validate\goods\CouponValidate;
        $data     = $validate->data('add', [
            'user_id' => $this->user->id,
        ]);
        $post     = array_fill(0, $data['quantity'], $data);
        $post     = array_map(function ($item) {
            $item['code']      = strtoupper(substr(md5(uniqid() . $this->user->id), 0, 12) . get_random_string(4));
            $item['create_at'] = time();
            $item['expire_at'] = strtotime($item['expire_at']);
            $item['status'] = 1;
            return $item;
        }, $post);
        $result = $this->user->goodsCoupon()->saveAll($post);
        return $result ? $this->success("成功添加" . count($result) . "张优惠券！") : $this->error("添加失败！");
    }

    /**
     * 删除|批量删除至回收站
     *
     */
    public function batchDel()
    {
        $ids = inputs("ids/a", []);
        count($ids) == 0 && $this->error("没有选中项！");

        $result = $this->user->goodsCoupon()->whereIn("id", $ids)->update(["delete_at" => time()]);
        return $result ? $this->success("批量删除优惠券成功") : $this->error("删除失败！");
    }

    /**
     * 恢复|批量恢复
     *
     */
    public function restore()
    {
        $ids = inputs("ids/a", []);
        empty($ids) && $this->error('没有选中项！');
        $result = $this->user->goodsCoupon()->onlyTrashed()->whereIn("id", $ids)->update(["delete_at" => null]);
        return $result ? $this->success("恢复成功！") : $this->error("恢复失败！");
    }

    /**
     * 批量清空回收站
     *
     */
    public function clear()
    {
        $where[] = ["user_id", "=", $this->user->id];
        $where[] = ["delete_at", ">", 0];
        $result  = GoodsCouponModel::onlyTrashed()->where($where)->chunk(100, function ($items) {
            foreach ($items as $item) {
                $item->force()->delete();
            }
        });
        return $result ? $this->success("删除成功！") : $this->error("删除失败！");
    }

}
