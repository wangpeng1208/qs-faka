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

use app\common\model\GoodsCard;
use app\merchantapi\controller\Base;

class Good extends Base
{
    /**
     * 商品列表
     */
    public function list()
    {
        $where = $this->request->params([
            ['cate_id', ''],
            ['name', ''],
        ]);
        $list  = $this->user->goods()
            ->with(['category'])
            ->withSearch($where[0], $where[1])
            ->order("sort desc,id desc")
            ->paginate($this->limit)
            ->each(function ($item) {
                $item->cate_name = $item->category->name; // 分类名称
            });
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }

    // 违禁词检测
    private function checkWordfilter($name)
    {
        $check_name = check_wordfilter($name);
        $check_name && $this->error("分类名包含敏感词汇“" . $check_name . "”！");
    }

    private function check_post($id = '')
    {
        $post = [
            "user_id"                 => $this->user->id,
            "cate_id"                 => inputs("cate_id/d", 0),
            "theme"                   => inputs("theme/s", "default"),
            "sort"                    => inputs("sort/d", 0),
            "name"                    => inputs("name/s", ""),
            "price"                   => inputs("price/f", 0),
            "wholesale_discount"      => inputs("wholesale_discount/d", 0),
            "wholesale_discount_list" => inputs("wholesale_discount_list/a", null),
            "cost_price"              => inputs("cost_price/f", 0),
            "limit_quantity"          => inputs("limit_quantity/d", 1),
            "limit_quantity_max"      => inputs("limit_quantity_max/d", 0),
            "inventory_notify"        => inputs("inventory_notify/d", 0),
            "inventory_notify_type"   => inputs("inventory_notify_type/d", 1),
            "coupon_type"             => inputs("coupon_type/d", 0),
            "sold_notify"             => inputs("sold_notify/d", 0),
            "take_card_type"          => inputs("take_card_type/d", 0),
            "visit_type"              => inputs("visit_type/d", 0),
            "visit_password"          => inputs("visit_password/s", ""),
            "contact_limit"           => inputs("contact_limit/s", ""),
            "content"                 => inputs("content/s", ""),
            "remark"                  => inputs("remark/s", ""),
            "sms_payer"               => inputs("sms_payer/d", 0),
            "card_order"              => inputs("card_order/d", 0),
            "selectcard_fee"          => inputs("selectcard_fee", 0),
            // 叠加赠送
            "event_give"              => inputs("event_give/a", null),
            // 额外赠送
            "addtion_give"            => inputs('addtion_give/a', null)
        ];

        if ($post['price'] <= $post['cost_price']) {
            $this->error("商品价格必须大于成本价");
        }

        $this->checkWordfilter($post["name"]);
        $this->checkWordfilter($post["content"]);
        $this->checkWordfilter($post["remark"]);
        if (conf("goods_min_price") > 0 && $post["price"] < conf("goods_min_price")) {
            $this->error("商品价格不能少于" . conf("goods_min_price") . "元");
        }
        if (conf("goods_max_price") > 0 && conf("goods_max_price") < $post["price"]) {
            $this->error("商品价格不能超过" . conf("goods_max_price") . "元");
        }
        // 活动赠送
        if ($post['event_give']) {
            foreach ($post['event_give'] as $key => $value) {
                $post['event_give'][$key]['num']      = abs($value['num']);
                $post['event_give'][$key]['give_num'] = abs($value['give_num']);
                if (empty($value['num']) || empty($value['give_num'])) {
                    unset($post['event_give'][$key]);
                }
            }
        }

        // 附加赠送
        if ($post['addtion_give']) {
            $addtion_give_arr = array_column($post['addtion_give'], 'good_id');
            if (count($addtion_give_arr) != count(array_unique($addtion_give_arr))) {
                $this->error("附加赠送有重复的id！");
            }
            // bug_num、give_num 0过滤
            foreach ($post['addtion_give'] as $key => $value) {

                if ($id && $id == $value['good_id']) {
                    $this->error("不能赠送本身商品，否则与叠加赠送冲突！");
                }

                $post['addtion_give'][$key]['bug_num']  = abs($value['bug_num']);
                $post['addtion_give'][$key]['give_num'] = abs($value['give_num']);
                if (empty($value['bug_num']) || empty($value['give_num'])) {
                    unset($post['addtion_give'][$key]);
                }
            }
        }

        // 批发优惠
        if ($post['wholesale_discount_list']) {
            foreach ($post['wholesale_discount_list'] as $key => $value) {
                $post['wholesale_discount_list'][$key]['num']   = abs($value['num']);
                $post['wholesale_discount_list'][$key]['price'] = abs($value['price']);
                if (empty($value['num']) || empty($value['price'])) {
                    unset($post['wholesale_discount_list'][$key]);
                }
            }
        }

        // 查询数据放在最后
        $this->user->categorys()->where(["id" => $post["cate_id"]])->find() ?:
            $this->error("不存在该分类！");
        return $post;
    }


    /**
     * @notes 新增商品
     * @auth true
     */
    public function add()
    {
        // 是否存在分类
        $this->user->categorys()->find() ?: $this->error('请先添加分类');

        $post              = $this->check_post();
        $post['status']    = 1;
        $post['create_at'] = time();

        $res = $this->user->goods()->save($post);
        return $res ? $this->success("添加商品成功") : $this->error("添加商品失败");
    }

    public function detail()
    {
        $id   = inputs("id/d", 0);
        $good = $this->user->goods()->withTrashed()->where(["id" => $id])->lock(true)->findOrFail();
        return $this->success('获取成功', $good);
    }

    /**
     * @notes 编辑商品
     * @auth true
     */
    public function edit()
    {
        $id   = inputs("id/d", 0);
        $good = $this->user->goods()->withTrashed()->where(["id" => $id])->lock(true)->find() ?: $this->error("商品不存在！");
        $post = $this->check_post($id);
        $res  = $good->save($post);
        return $res ? $this->success("编辑商品成功") : $this->error("编辑商品失败");
    }

    /**
     * @notes 删除商品
     * @auth true
     */
    public function del()
    {
        $id   = inputs("id/d", 0);
        $data = $this->getGoods($id);
        $res  = $data->delete();
        return $res ? $this->success("删除商品成功！") : $this->error("删除失败！");
    }

    /**
     * 商品回收站
     */
    public function trash()
    {
        $where = $this->request->params([
            ['cate_id', ''],
            ['name', ''],
        ]);
        $res   = $this->user->goods()
            ->with('category')
            ->onlyTrashed()
            ->withSearch($where[0], $where[1])
            ->order("sort desc,id desc")
            ->paginate($this->limit)
            ->each(function ($item) {
                $item->cate_name = $item->category->name;
            });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    // 批量恢复
    public function recover()
    {
        $ids = inputs("ids/a", []);
        empty($ids) && $this->error('没有选中项！');
        $where[] = ["id", "in", $ids];
        $result  = $this->user->goods()->onlyTrashed()->where($where)->update(["delete_at" => null]);
        return $result ? $this->success("恢复成功") : $this->error("恢复失败");
    }

    // 获取商品信息
    private function getGoods($id)
    {
        return $this->user->goods()->find($id) ?: $this->error("不存在该商品！");
    }

    public function status()
    {
        $id   = inputs("id/d", 0);
        $good = $this->getGoods($id);
        $good->is_freeze == 1 && $this->error("该商品已被冻结，如果要上架，请修改相关商品信息再上架");
        $status       = inputs("val/d", 0);
        $status       = $status ? 1 : 0;
        $status_text  = $status == 1 ? "上架" : "下架";
        $good->status = $status;
        $res          = $good->save();
        return $res ? $this->success($status_text . "成功") : $this->error($status_text . "失败");
    }

    // 	附加赠送用到的 获取商品列表id+name
    public function goodList()
    {
        $list = $this->user->goods()->field('id,name')->order("sort desc,id desc")->select();
        $this->success("获取成功", $list);
    }

    // 	清空卡密==把未售卡密放入回收站
    public function emptiedCards(GoodsCard $card)
    {
        $id  = inputs("id/d", 0);
        $res = $card::update(["delete_at" => time()], ["goods_id" => $id, "user_id" => $this->user->id, "status" => 1]);
        return $res ? $this->success("清空商品未售卡密成功") : $this->error("清空失败！");
    }

}
