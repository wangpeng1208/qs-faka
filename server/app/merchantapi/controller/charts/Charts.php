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

namespace app\merchantapi\controller\charts;

use app\merchantapi\controller\Base;
use app\common\model\Order as OrderModel;
use app\common\model\ShopIplist as ShopIplistModel;

class Charts extends Base
{
    public function money()
    {
        $params = [
            "status"     => 1,
            "date_range" => inputs("date_range/s", ""),
            "trade_no"   => inputs("trade_no/s", ""),
            "goods_id"   => inputs("goods_id/d", "")
        ];
        $where  = [];
        if (isset($params["paytype"]) && $params["paytype"] !== "") {
            $where[] = ["paytype", "in", $params["paytype"]];
        }
        if ($params["status"] !== "") {
            $where["status"] = $params["status"];
        }
        if ($params["trade_no"] !== "") {
            $where["trade_no"] = $params["trade_no"];
        }
        if ($params["goods_id"] !== "") {
            $where["goods_id"] = $params["goods_id"];
        }
        if ($params["date_range"] && $params["date_range"][0] && $params["date_range"][1]) {
            $where[] = ['sell_time', 'between', [strtotime($params["date_range"][0]), strtotime($params["date_range"][1])]];
        }

        $order            = $this->user->orders()->where($where)->field("total_price, total_product_price, total_cost_price, sms_payer, sms_price")->select();
        $total_price      = 0;
        $total_cost_price = 0;
        $cost_price       = 0;
        foreach ($order as $value) {
            $total_price += (float) $value["total_product_price"];
            $total_cost_price += (float) $value["total_cost_price"];
            if ($value["sms_payer"] == 1) {
                $cost_price += (float) $value["sms_price"];
            }
        }
        $total_profit               = round($total_price - $total_cost_price - $cost_price, 2);
        $limit                      = inputs('limit', 10);
        $res                        = $this->user->orders()->where($where)->order("id desc")->paginate($limit)->each(function ($item, $key) {
            $item->cards_count = $item->cards_count;
            $item->paytype = get_paytype($item['paytype'])->name;
            if ($item->cards_count) {
                if ($item->cards_count >= $item->quantity) {
                    $item->task_status = '已取';
                } else {
                    $item->task_status = '部分已取';
                }
            } else {
                $item->task_status = '未取';
            }
        });
        $charts                     = [];
        $charts['total_price']      = $total_price;
        $charts['total_cost_price'] = $total_cost_price;
        $charts['total_profit']     = $total_profit;
        $this->success('获取成功', [
            'list'   => $res->items(),
            'total'  => $res->total(),
            'charts' => $charts
        ]);
    }
    // todo前台
    public function channel()
    {
        $where = $this->request->params([
            ['date_range', ''],
            ['keywords', ''],
            ['type', 0],
            ['user_id', $this->user->id],
            ['status', 1]
        ]);
        $res   = OrderModel::withSearch($where[0], $where[1])->select();
        $data  = [];
        foreach ($res as $value) {
            if (!isset($data[$value->channel_id])) {
                $data[$value->channel_id]["title"]            = $value->channel->title;
                $data[$value->channel_id]["count"]            = 0;
                $data[$value->channel_id]["paid"]             = 0;
                $data[$value->channel_id]["unpaid"]           = 0;
                $data[$value->channel_id]["sum_money"]        = 0;
                $data[$value->channel_id]["sum_actual_money"] = 0;
            }
            $data[$value->channel_id]["count"]++;
            if ($value->status == 1) {
                $data[$value->channel_id]["paid"]++;
                $data[$value->channel_id]["sum_money"] += $value->total_price;
                $data[$value->channel_id]["sum_actual_money"] += $value->total_price - $value->fee;
            } else {
                $data[$value->channel_id]["sum_money"] += $value->total_price;
                $data[$value->channel_id]["unpaid"]++;
            }
        }
        $totals["title"]            = "合计";
        $totals["count"]            = array_sum(array_column($data, "count"));
        $totals["paid"]             = array_sum(array_column($data, "paid"));
        $totals["unpaid"]           = array_sum(array_column($data, "unpaid"));
        $totals["sum_money"]        = array_sum(array_column($data, "sum_money"));
        $totals["sum_actual_money"] = array_sum(array_column($data, "sum_actual_money"));
        $data = array_values($data);
        $this->success('获取成功', [
            'list' => $data
        ]);
    }

    public function rankList()
    {
        $where  = $this->request->params([
            ['date_range', ''],
            ['keywords', ''],
            ['type', 0],
            ['user_id', $this->user->id],
            ['status', 1]
        ]);
        $res = OrderModel::withSearch($where[0], $where[1])->field("contact,sum(total_price) as money,count(*) as times")->group("contact")->order("money desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 店铺访问记录
     */
    public function iplist()
    {
        $params = ["date_range" => inputs("date_range/s", ""), "keywords" => inputs("keywords/s", "")];
        if ($this->request->isPost()) {
            if (inputs("action/s") == "del") {
                $id   = inputs("id/d", 0);
                $data = ShopIplistModel::where(["id" => $id, "user_id" => $this->user->id])->find();
                if (empty($data))
                    $this->error("不存在该IP！");
                $res = $data->delete();
                if ($res !== false) {
                    $this->success("删除成功！");
                } else {
                    $this->error("删除失败！");
                }
            }
        }
        $where   = [];
        $where[] = ['user_id', '=', $this->user->id];
        if ($params["keywords"] !== "") {
            $where[] = ['ip', 'like', "%" . $params["keywords"] . "%"];
        }

        if ($params["date_range"] && $params["date_range"][0] && $params["date_range"][1]) {
            $where[] = ['create_at', 'between', [strtotime($params["date_range"][0]), strtotime($params["date_range"][1])]];
        }
        $list = ShopIplistModel::where($where)->order("id", "desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }
}
