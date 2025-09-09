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

namespace app\adminapi\controller;

use app\common\model\Order;
use app\common\model\User;
use app\common\model\Cash;
use app\common\model\Channel;
use app\common\model\UserAnalysis;

class Workbench extends Base
{
    /**
     * 工作台基础数据展示
     * @auth false
     */
    public function basic()
    {
        $data          = [];
        $data['price'] = array_merge(['title' => '今日销售额'], $this->calculateData(Order::class, 'sum', 'total_price', 1));
        $data['order'] = array_merge(['title' => '今日订单数'], $this->calculateData(Order::class, 'count', null, 1));
        $data['user']  = array_merge(['title' => '今日注册用户'], $this->calculateData(User::class, 'count'));
        // // 待审核商户
        $data['notpass_user'] = User::where('status', 0)->count();
        // 冻结商户
        $data['frozen_user'] = User::where('status', 2)->count();
        // 提现数据
        $data['cash'] = array_merge(['title' => '今日提现'], $this->calculateData(Cash::class, 'sum', 'money', 1));

        $this->success('success', $data);
    }

    private function calculateData($model, $method, $field = null, $status = null)
    {
        $today     = $model::whereTime('create_at', 'today');
        $yesterday = $model::whereTime('create_at', 'yesterday');
        $total     = new $model();

        if ($status !== null) {
            $today     = $today->where('status', $status);
            $yesterday = $yesterday->where('status', $status);
            $total     = $total->where('status', $status);
        }

        $today     = $field ? $today->$method($field) : $today->$method();
        $yesterday = $field ? $yesterday->$method($field) : $yesterday->$method();
        $total     = $field ? $total->$method($field) : $total->$method();

        if ($today != 0 && $yesterday == 0) {
            $ratio = 100;
        } elseif ($today == 0 && $yesterday != 0) {
            $ratio = -100;
        } elseif ($today == 0 && $yesterday == 0) {
            $ratio = 0;
        } else {
            $ratio = round(($today - $yesterday) / $yesterday, 4) * 100;
        }

        return [
            'today'     => $today,
            'yesterday' => $yesterday,
            'total'     => $total,
            'ratio'     => $ratio
        ];
    }

    /**
     * 收款渠道数据
     * @auth false
     */
    public function channelCollectionOrderPriceSum()
    {
        $channels = Channel::where(['status' => 1, 'type' => 1])
            ->withSum('activeOrders', 'total_price')
            ->select();

        $data = [];
        foreach (collect($channels) as $key => $channel) {
            $data[$key]['value'] = $channel->active_orders_sum ?? 0;
            $data[$key]['name']  = $channel->title;
        }
        $this->success('success', $data);
    }

    /**
     * 订单收款统计数据
     * @input period 期间时长
     * @input unit 单位 day week month year
     * @auth false
     */
    public function orderStatisData()
    {
        $period = inputs('period', 7);
        $unit   = inputs('unit', 'day');
        $data   = [];
        for ($i = 0; $i < $period; $i++) {
            if ($unit === 'month') {
                $start = (new \DateTime("first day of -$i month"))->format('Y-m-d');
                $end   = (new \DateTime("last day of -$i month"))->format('Y-m-d');
            } elseif ($unit === 'week') {
                $start = (new \DateTime("-$i week monday"))->format('Y-m-d');
                $end   = (new \DateTime("-$i week sunday"))->format('Y-m-d');
            } elseif ($unit === 'year') {
                $start = (new \DateTime("first day of january -$i year"))->format('Y-m-d');
                $end   = (new \DateTime("last day of december -$i year"))->format('Y-m-d');
            } else {
                $start = (new \DateTime("-$i day"))->format('Y-m-d');
                $end   = $start;
            }
            $dateFormat = $unit === 'month' ? 'Y-m' : ($unit === 'year' ? 'Y' : 'Y-m-d');
            $data[]     = [
                $unit   => date($dateFormat, strtotime($start)),
                'value' => UserAnalysis::whereTime('date', 'between', [$start, $end])->sum('day_amount') ?? 0
            ];
        }
        $data = array_reverse($data); // 反转数组，使其按时间升序排列.
        // data组成echarts需要的数据格式
        $result = [
            'xAxis'  => array_column($data, $unit),
            'series' => array_column($data, 'value')
        ];
        $this->success('success', $result);
    }

    /**
     * 软件系统版本信息
     * @auth false
     */
    public function systemVersion()
    {
        $data      = [
            'authorize' => [
                'status'   => true,
                'end_time' => '开源版'
            ],
            'version'   => config('site.version'),
            'framework' => [
                'backend'  => 'webman',
                'frontend' => 'Vue3, '
            ],
            'author'    => [
                'name'  => '邮箱',
                'email' => '990504246@qq.com'
            ],
            'license'   => config('site.api_license'),
        ];
        $this->success('success', $data);
    }

    /**
     * 商户收款排行榜
     * unit 单位 day当天 month当月 year当年 all全部
     * @auth false
     */
    public function userCollectionRank()
    {
        $data = [
            'today' => $this->getUserCollectionRank('today'),
            'week'  => $this->getUserCollectionRank('week'),
            'month' => $this->getUserCollectionRank('month'),
            'year'  => $this->getUserCollectionRank('year'),
            'all'   => $this->getUserCollectionRank('all')
        ];
        $this->success('success', $data);
    }

    public function getUserCollectionRank($unit)
    {
        $query = UserAnalysis::field("user_id,sum(day_amount) as transaction_money")
            ->group("user_id")
            ->order("transaction_money desc");

        if ($unit !== 'all') {
            $query->whereTime('date', $unit);
        }

        $anas = $query->with('user')->limit(6)->select();
        $data = [];
        foreach (collect($anas) as $ana) {
            if (!$ana->user) {
                continue;
            }
            $data[] = [
                "username"          => $ana->user->username,
                "transaction_money" => $ana->transaction_money
            ];
        }
        return $data;
    }

}