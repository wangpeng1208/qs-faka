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

namespace app\merchantapi\controller\charts;

use app\merchantapi\controller\Base;
use app\common\model\Order as OrderModel;
use app\common\model\ShopIplist as ShopIplistModel;
use app\service\export\ExportService;

class Charts extends Base
{
    public function money()
    {
        $params = [
            "status"     => 1,
            "date_range" => input("date_range/s", ""),
            "trade_no"   => input("trade_no/s", ""),
            "goods_id"   => input("goods_id/d", "")
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
        $limit                      = input('limit', 10);
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
        if (input("action/s", "") == "export") {
            $file_title = "渠道分析_" . date("Ymd");
            $result     = [];
            $result[]   = ["支付方式", "提交订单数", "已付订单数", "未付订单数", "订单总金额", "订单实收金额"];
            foreach (array_map("array_values", $data) as $item) {
                $result[] = $item;
            }
            $result[] = array_values($totals);
            $res      = (new ExportService())->createExcel($result, $file_title . ".xlsx");
            $this->success("导出成功", $res);
        }
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
        $action = input("action/s", "");
        if ($action == "export") {
            $data = OrderModel::withSearch($where[0], $where[1])->field("contact,sum(total_price) as money,count(*) as times")->group("contact")->order("money", "desc")->select();
            if ($data->isEmpty()) {
                $this->error("暂无数据");
            }
            // 文件名
            $file_title = "消费列表_" . date("Ymd");
            $result     = [];
            // 标头
            $result[] = ["买家", "购买次数", "付款总额"];
            foreach ($data as $v) {
                $result[] = [$v['contact'], $v['times'], $v['money']];
            }
            $res = (new ExportService())->createExcel($result, $file_title . ".xlsx");
            $this->success("导出成功", $res);
        }
        $res = OrderModel::withSearch($where[0], $where[1])->field("contact,sum(total_price) as money,count(*) as times")->group("contact")->order("money desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 店铺访问记录
     * todo前台
     * todo模型搜索器
     */
    public function iplist()
    {
        $params = ["date_range" => input("date_range/s", ""), "keywords" => input("keywords/s", "")];
        if ($this->request->isPost()) {
            if (input("action/s") == "del") {
                $id   = input("id/d", 0);
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
