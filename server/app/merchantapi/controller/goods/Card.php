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

use app\common\model\GoodsCard as GoodsCardModel;
use think\facade\Db;
use app\merchantapi\controller\Base;

class Card extends Base
{
    public function list()
    {
        $withSearch = $this->request->params([
            ['goods_id', ''],
            ['status', ''],
            ['number', ''],
            // ['contact', ''],
            ['trade_no', ''],
            ['cate_id', ''],
        ]);

        $res = GoodsCardModel::with('goods')
            ->where(['user_id' => $this->user->id])
            ->withSearch($withSearch[0], $withSearch[1])
            ->order("id desc")
            ->paginate($this->limit)
            ->each(function ($item) {
                $item->good_price    = $item?->goods?->price ?? 0;
                $item->good_name     = $item?->goods?->name ?? '商品已删除';
                $item->category_name = $item?->goods?->category?->name ?? '栏目已删除';
            });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }


    // 文本是否是gb2312 转 utf-8
    private function gbk_to_utf($str)
    {
        if (mb_detect_encoding($str, 'UTF-8, GBK') == 'GBK') {
            return iconv('GBK', 'UTF-8', $str);
        }
        return $str;
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $goods_id = inputs("goods_id/d", 0);
            $this->user->goods()->find($goods_id) ?: $this->error("商品不存在");
            $import_type = inputs("import_type/s", 1);
            $split_type  = inputs("split_type/s", " ");
            $content     = inputs("content/s", "");
            $check_card  = inputs("check_card/d", 0);
            $is_pre      = inputs("is_pre/d");
            $file        = $this->request->file('files');
            if ($import_type == 2 && $file[0]['raw']->isValid() && $file[0]['raw']->getSize() / 1024 <= 20480) {
                $content = $this->gbk_to_utf(file_get_contents($file[0]['raw']));
            }
            //  \n  PHP_EOL的区别
            $content_arr       = explode("\n", trim($content));
            $content_arr_count = count($content_arr);
            if ($content_arr_count > 500) {
                $this->error("一次最多添加500张");
            }
            $content_arr = array_map(function ($v) {
                return trim(
                    str_replace(
                        chr(194) . chr(160),
                        " ",
                        $v
                    )
                );
            }, $content_arr);
            if ($check_card == 1) {
                $content_arr = array_values(array_unique($content_arr));
            }
            if ($split_type == "0") {
                if (strpos($content_arr[0], " ") !== false) {
                    $split_type = " ";
                } elseif (strpos($content_arr[0], ",") !== false) {
                    $split_type = ",";
                } elseif (strpos($content_arr[0], "|") !== false) {
                    $split_type = "|";
                } elseif (strpos($content_arr[0], "----") !== false) {
                    $split_type = "----";
                } else {
                    $split_type = "";
                }
            }
            $cards = [];
            foreach ($content_arr as $value) {
                if (!empty($split_type)) {
                    $val = array_values(array_filter(explode($split_type, $value)));
                } else {
                    $val = [$value, ""];
                }
                if (isset($val[0])) {
                    $val[0] = preg_replace('/(^\s+)|(\s+$)/u', '', html_entity_decode($val[0]));
                } else {
                    continue;
                }
                if ($val[0] === "") {
                    continue;
                }
                $number = $val[0];
                if (isset($val[1])) {
                    $val[1] = preg_replace('/(^\s+)|(\s+$)/u', '', html_entity_decode($val[1]));
                } else {
                    continue;
                }
                if ($val[1] !== "") {
                    $secret = $val[1];
                } else {
                    $secret = "";
                }
                if ($check_card == 1) {
                    $card = GoodsCardModel::where(["user_id" => $this->user->id, "number" => $number, "secret" => $secret])->find();
                    if ($card) {
                        continue;
                    }
                }
                $cards[] = [
                    "user_id"   => $this->user->id,
                    "goods_id"  => $goods_id,
                    "number"    => $number,
                    "secret"    => $secret,
                    "status"    => 1,
                    "create_at" => time(),
                    "is_pre"    => $is_pre
                ];
            }
            if (empty($cards)) {
                $this->error("虚拟卡内容格式不正确, 或卡密已存在");
            }
            $order_type = inputs("order_type/d", 1);
            if ($order_type == 2) {
                shuffle($cards);
            }
            Db::startTrans();
            try {
                $res = $this->user->cards()->saveAll($cards);
            } catch (\Exception $e) {
                Db::rollback();
                $this->error("添加失败," . $e->getMessage());
            }
            Db::commit();
            $count_ok = count($res);
            return $res ? $this->success("添加成功", "共" . $content_arr_count . "张卡密，成功添加" . $count_ok . "张卡密！") : $this->error("添加失败！");
        }
    }

    /**
     * 批量删除
     * 为保证效率，直接使用update方法更新数据，而不是循环使用软删除
     * @return void
     */
    public function del()
    {
        $ids = inputs("ids/a");
        empty($ids) && $this->error("没有选中项！");
        $res = $this->user->cards()->whereIn("id", $ids)->update(["delete_at" => time()]);
        return $res ? $this->success("删除成功！") : $this->error("删除失败！");
    }

    /**
     * 全部清空
     */
    public function clearGoodsCards()
    {
        $res = $this->user->cards()->whereNull('delete_at')->update(["delete_at" => time()]);
        return $res ? $this->success("删除成功！") : $this->error("删除失败！");
    }

    /**
     * 一键删除未售出库存
     */
    public function allDel()
    {
        $res = $this->user->cards()->where('status', '<>', 2)->update(['delete_at' => time()]);
        return $res ? $this->success("删除成功！") : $this->error("删除失败！");
    }

    /**
     * 库存回收站
     *
     * @return void
     */
    public function trash()
    {
        $where = $this->request->params([
            ['goods_id', ''],
            ['status', ''],
            ['cate_id', ''],
        ]);
        $res   = $this->user->cards()->with('goods')->withSearch($where[0], $where[1])->onlyTrashed()->order("delete_at desc, id desc")->paginate($this->limit)->each(function ($item) {
            $item->goods_name = $item?->goods?->name ?? '商品已删除';
            $item->cate_name = $item?->goods?->category?->name ?? '栏目已删除';
            $item->price = $item?->goods?->price ?? 0;
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 回收站批量删除
     *
     * @return void
     */
    public function trashBatchDel()
    {
        $ids = inputs("ids/a");
        empty($ids) && $this->error("没有选中项！");
        $where[] = ["id", "in", $ids];
        $where[] = ["user_id", "=", $this->user->id];
        $where[] = ["delete_at", ">", 0];
        $result  = GoodsCardModel::onlyTrashed()->where($where)->chunk(100, function ($items) {
            foreach ($items as $item) {
                $item->force()->delete();
            }
        });
        return $result ? $this->success("删除成功！") : $this->error("删除失败！");
    }

    /**
     * 回收站清空
     */
    public function clear()
    {
        $where[] = ["user_id", "=", $this->user->id];
        $where[] = ["delete_at", ">", 0];
        $result  = GoodsCardModel::onlyTrashed()->where($where)->chunk(100, function ($items) {
            foreach ($items as $item) {
                $item->force()->delete();
            }
        });
        return $result ? $this->success("清空虚拟卡回收站成功") : $this->error("删除失败！");
    }

    public function trashBatchRestore()
    {
        $ids = inputs("ids/a", []);
        if (empty($ids)) {
            $this->error("没有选中项！");
        }
        $where[] = ["id", "in", $ids];
        $result  = $this->user->cards()->onlyTrashed()->where($where)->update(["delete_at" => null]);
        return $result ? $this->success("恢复虚拟卡成功") : $this->error("恢复失败！");
    }

    public function first()
    {
        $id     = inputs("id/d", 0);
        $status = inputs("status/d", 0);
        $res    = $this->user->cards()->where(["id" => $id])->update(["is_first" => $status]);
        return $res ? $this->success("修改成功！") : $this->error("修改失败！");
    }

    public function delete_card_right()
    {
        $goods_id = inputs("goods_id/d", 0);
        $this->user->goods()->where(['id' => $goods_id])->find() ?: $this->error("不存在该商品！");
        // 按条件筛选出已售出数据进行删除
        // 卡密状态已售出条件
        $withSearch       = $this->request->params([
            ['goods_id', ''],
            ['status', ''],
            ['date_range', ''],
        ]);
        $where['user_id'] = $this->user->id;

        $res    = GoodsCardModel::withSearch($withSearch[0], $withSearch[1])->where($where);
        $count  = $res->count();
        $result = $res->delete();
        return $result ? $this->success("成功删除" . $count . "条已售出卡密记录") : $this->error("删除失败");
    }
}
