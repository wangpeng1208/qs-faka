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

namespace app\service\analysis;

use app\common\model\UserAnalysis as UserAnalysisModel;
use app\common\model\ShopIplist as ShopIplistModel;

class AnalysisService
{
    public function weekAnalysis($user_id)
    {
        $user_anlysis = UserAnalysisModel::where("user_id", $user_id)->whereTime("date", ">", date("Y-m-d", strtotime("-7 day")))->select();
        $week_arr     = ["周日", "周一", "周二", "周三", "周四", "周五", "周六"];
        $data         = [];
        foreach ($this->getWeeks() as $val) {
            $day_amount     = 0;
            $finally_amount = 0;
            $order_count    = 0;
            foreach ($user_anlysis as $value) {
                if ($value["date"] == $val) {
                    $day_amount += $value["day_amount"];
                    $finally_amount += $value["finally_amount"];
                    $order_count += $value["order_count"];
                }
            }
            $week   = $week_arr[date("w", strtotime($val))];
            $data[] = ["week" => $week, "day_amount" => $day_amount, "order_count" => $order_count, "finally_amount" => $finally_amount];
        }
        $data[4]["week"] = "前天";
        $data[5]["week"] = "昨天";
        $data[6]["week"] = "今天";
        return $data;
    }

    public function monthAnalysis($user_id)
    {
        $month_arr = ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"];
        $data      = [];
        foreach ($this->getMonth() as $date) {
            $Y                    = date("Y", strtotime($date . "-1"));
            $M                    = date("m", strtotime($date . "-1"));
            $last_day             = $this->getLastday($Y, $M);
            $month_amount         = UserAnalysisModel::where("user_id", $user_id)->whereTime("date", "between", [$Y . "-" . $M . "-1", $Y . "-" . $M . "-" . $last_day])->sum("day_amount");
            $month_finally_amount = UserAnalysisModel::where("user_id", $user_id)->whereTime("date", "between", [$Y . "-" . $M . "-1", $Y . "-" . $M . "-" . $last_day])->sum("finally_amount");
            $month_order_count    = UserAnalysisModel::where("user_id", $user_id)->whereTime("date", "between", [$Y . "-" . $M . "-1", $Y . "-" . $M . "-" . $last_day])->sum("order_count");
            $month                = $month_arr[intval(date("m", strtotime($date)) - 1)];
            $data[]               = ["month" => $month, "month_amount" => $month_amount, "month_order_count" => $month_order_count, "month_finally_amount" => $month_finally_amount];
        }
        return $data;
    }

    public function ipAnalysis($user_id)
    {
        $today_pv = ShopIplistModel::whereTime("create_at", 'today')->where("user_id", $user_id)->count();

        $yesterday_pv = ShopIplistModel::whereTime("create_at", 'yesterday')->where("user_id", $user_id)->count();

        $today_uv = ShopIplistModel::whereTime("create_at", 'today')->where("user_id", $user_id)->group("ip")->count();

        $yesterday_uv = ShopIplistModel::whereTime("create_at", 'yesterday')->where("user_id", $user_id)->group("ip")->count();

        if ($yesterday_pv == 0) {
            $compare_pv = $today_pv > 0 ? 100 : 0;
        } else {
            $compare_pv = round(($today_pv - $yesterday_pv) / $yesterday_pv * 100);
        }
        if ($yesterday_uv == 0) {
            $compare_uv = $today_uv > 0 ? 100 : 0;
        } else {
            $compare_uv = round(($today_uv - $yesterday_uv) / $yesterday_uv * 100);
        }
        return ["today_pv" => $today_pv, "today_uv" => $today_uv, "yesterday_pv" => $yesterday_pv, "yesterday_uv" => $yesterday_uv, "compare_pv" => $compare_pv, "compare_uv" => $compare_uv];
    }

    /**
     * 统计分析更新
     *
     * @param integer $user_id 用户id
     * @param integer $total_price 总金额
     * @param integer $finally_amount 最终金额
     * @param integer $profit 利润
     * @param integer $order_count 订单数
     * @param integer $time 时间
     */
    public static function analysis($user_id, $total_price = 0, $finally_amount = 0, $profit = 0, $order_count = 1, $time = 0)
    {
        $user_analysis = UserAnalysisModel::where('user_id', $user_id)
            ->where('date', date('Y-m-d', $time))
            ->find();

        if ($user_analysis) {
            $user_analysis->day_amount += $total_price;
            $user_analysis->finally_amount += $finally_amount;
            $user_analysis->profit += $profit;
            $user_analysis->order_count += $order_count;
        } else {
            $user_analysis                 = new UserAnalysisModel();
            $user_analysis->user_id        = $user_id;
            $user_analysis->date           = date('Y-m-d', $time);
            $user_analysis->day_amount     = $total_price;
            $user_analysis->finally_amount = $finally_amount;
            $user_analysis->profit         = $profit;
            $user_analysis->order_count    = $order_count;
        }

        $user_analysis->save();
    }

    /**
     * 统计减法
     * @param $user_id 用户id
     * @param int $amount 金额
     * @param int $finally_amount 最终金额
     * @param int $profit 利润
     * @param int $order_count 订单数
     * @param int $date 时间
     */
    public static function analysis_dec($user_id, $amount = 0, $finally_amount = 0, $profit = 0, $order_count = 0, $date = 0)
    {
        $user_analysis = UserAnalysisModel::where(["user_id" => $user_id, "date" => date("Y-m-d", $date)])->order("id", "desc")->find();
        if ($user_analysis) {
            $user_analysis->day_amount -= $amount;
            $user_analysis->finally_amount -= $finally_amount;
            $user_analysis->profit -= abs($profit);
            $user_analysis->order_count -= $order_count;
            $user_analysis->save();
        }
    }

    // 获取最近七天日期
    private function getWeeks($time = '', $format = 'Y-m-d')
    {
        $time = $time != '' ? $time : time();
        //组合数据
        $date = [];
        for ($i = 1; $i <= 7; $i++) {
            $date[] = date($format, strtotime('+' . $i - 7 . ' days', $time));
        }
        return $date;
    }

    // 计算最近十二个月份
    private function getMonth()
    {
        $date = [];
        for ($i = 11; $i >= 0; $i--) {
            $firstDayOfMonth = date('Y-m-01', time());
            $date[]          = date('Y-m', strtotime($firstDayOfMonth . ' -' . $i . ' month'));
        }
        return $date;
    }

    // 获取某年某月的最后一天
    private function getLastday($year, $month)
    {
        if ($month == 2) {
            $lastday = date('L', $year) ? 29 : 28;
        } elseif ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            $lastday = 30;
        } else {
            $lastday = 31;
        }
        return $lastday;
    }
}
