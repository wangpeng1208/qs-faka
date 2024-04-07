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

namespace app\adminapi\controller\order;

use app\adminapi\controller\Base;
use app\common\model\Order as OrderModel;
use app\service\export\ExportService;

class Analysis extends Base
{
    /**
     * 商户分析
     */
    public function merchant()
    {
        $where  = $this->request->params([
            ['username', ''],
            ['channel_id', ''],
            ['paytype', ''],
            ['status', ''],
            ['date_range', ''],
        ]);
        $statis = [];
        OrderModel::withSearch($where[0], $where[1])
            ->where('status', 1)
            ->order('id') // 必须要有一个排序，否则 chunk 方法可能会漏掉一些数据
            ->chunk(5000, function ($orders) use (&$statis) {
                foreach ($orders as $value) {
                    if (!isset ($statis[$value->user_id])) {
                        $statis[$value->user_id]["user_id"]            = $value->user_id;
                        $statis[$value->user_id]["username"]           = $value->user->username;
                        $statis[$value->user_id]["count"]              = 0;
                        $statis[$value->user_id]["paid"]               = 0;
                        $statis[$value->user_id]["unpaid"]             = 0;
                        $statis[$value->user_id]["sum_money"]          = 0;
                        $statis[$value->user_id]["sum_actual_money"]   = 0;
                        $statis[$value->user_id]["sum_platform_money"] = 0;
                    }
                    $statis[$value->user_id]["count"]++;
                    if ($value->status == 1) {
                        $statis[$value->user_id]["paid"]++;
                        $statis[$value->user_id]["sum_money"]          = bcadd($statis[$value->user_id]["sum_money"], $value->total_price, 3);
                        $statis[$value->user_id]["sum_actual_money"]   = bcadd($statis[$value->user_id]["sum_actual_money"], $value->total_price - $value->fee, 3);
                        $statis[$value->user_id]["sum_platform_money"] = bcadd($statis[$value->user_id]["sum_platform_money"], $value->fee, 3);
                    } else {
                        $statis[$value->user_id]["unpaid"]++;
                        $statis[$value->user_id]["sum_money"] += $value->total_price;
                    }
                }
            });

        $counts["user_id"]            = "合计";
        $counts["username"]           = "共" . count($statis) . "个商户";
        $counts["count"]              = array_sum(array_column($statis, "count"));
        $counts["paid"]               = array_sum(array_column($statis, "paid"));
        $counts["unpaid"]             = array_sum(array_column($statis, "unpaid"));
        $counts["sum_money"]          = array_sum(array_column($statis, "sum_money"));
        $counts["sum_actual_money"]   = array_sum(array_column($statis, "sum_actual_money"));
        $counts["sum_platform_money"] = array_sum(array_column($statis, "sum_platform_money"));
        // $counts 作为 $statis 的第一项
        array_unshift($statis, $counts);
        if (input("action/s", "") == "export") {
            $file_name  = "商户分析_" . date("Ymd");
            $out_data   = [];
            $out_data[] = ["商户ID", "商户名称", "提交订单", "已付订单", "未付订单", "提交金额", "商户收入", "平台收入"];
            foreach (array_map("array_values", $statis) as $item) {
                $out_data[] = $item;
            }
            $out_data[] = array_values($counts);
            $res        = (new ExportService())->createExcel($out_data, $file_name . '.xlsx');
            return $this->success('获取成功', $res);
        }

        $this->success("获取成功", [
            "list"  => $statis,
            "total" => count($statis) - 1,
        ]);

    }

    /**
     * 通道分析
     */
    public function channel(OrderModel $model)
    {

        $where  = $this->request->params([
            ['username', ''],
            ['channel_id', ''],
            ['paytype', ''],
            ['status', ''],
            ['date_range', ''],
        ]);
        $statis = [];
        $model->withSearch($where[0], $where[1])
            ->where('status', 1)
            ->order('id') // 必须要有一个排序，否则 chunk 方法可能会漏掉一些数据
            ->chunk(1000, function ($orders) use (&$statis) {
                foreach ($orders as $item) {
                    if (!isset ($statis[$item->channel_id])) {
                        $statis[$item->channel_id]["channel_id"]         = $item->channel_id;
                        $statis[$item->channel_id]["title"]              = $item->channel->title;
                        $statis[$item->channel_id]["count"]              = 0;
                        $statis[$item->channel_id]["paid"]               = 0;
                        $statis[$item->channel_id]["unpaid"]             = 0;
                        $statis[$item->channel_id]["sum_money"]          = 0;
                        $statis[$item->channel_id]["sum_actual_money"]   = 0;
                        $statis[$item->channel_id]["sum_platform_money"] = 0;
                    }
                    $statis[$item->channel_id]["count"]++;
                    if ($item->status == 1) {
                        $statis[$item->channel_id]["paid"]++;
                        $statis[$item->channel_id]["sum_money"]          = bcadd($statis[$item->channel_id]["sum_money"], $item->total_price, 3);
                        $statis[$item->channel_id]["sum_actual_money"]   = bcadd($statis[$item->channel_id]["sum_actual_money"], $item->total_price - $item->fee, 3);
                        $statis[$item->channel_id]["sum_platform_money"] = bcadd($statis[$item->channel_id]["sum_platform_money"], $item->fee, 3);
                    } else {
                        $statis[$item->channel_id]["unpaid"]++;
                        $statis[$item->channel_id]["sum_money"] += $item->total_price;
                    }
                }
            });

        $counts["channel_id"]         = "合计";
        $counts["title"]              = "共" . count($statis) . "个渠道";
        $counts["count"]              = array_sum(array_column($statis, "count"));
        $counts["paid"]               = array_sum(array_column($statis, "paid"));
        $counts["unpaid"]             = array_sum(array_column($statis, "unpaid"));
        $counts["sum_money"]          = array_sum(array_column($statis, "sum_money"));
        $counts["sum_actual_money"]   = array_sum(array_column($statis, "sum_actual_money"));
        $counts["sum_platform_money"] = array_sum(array_column($statis, "sum_platform_money"));
        if (input("action/s", "") == "export") {
            $file_name  = "渠道分析";
            $out_data   = [];
            $out_data[] = ["渠道ID", "渠道名称", "提交订单", "已付订单", "未付订单", "提交金额", "商户收入", "平台收入"];
            foreach (array_map("array_values", $statis) as $item) {
                $out_data[] = $item;
            }
            $out_data[] = array_values($counts);
            $res        = (new ExportService())->createExcel($out_data, $file_name . '.xlsx');
            return $this->success('获取成功', $res);
        }
        array_unshift($statis, $counts);
        $this->success("获取成功", [
            "list"  => $statis,
            "total" => count($statis) - 1,
        ]);
    }
}
