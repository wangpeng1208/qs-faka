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

class Charts extends Base
{

    public function charts()
    {
        $where            = $this->request->params([
            ['status', 1],
            ['date_range', ''],
            ['trade_no', ''],
            ['goods_id', ''],
        ]);
        $order            = $this->user->orders()->withSearch($where[0], $where[1])->field("total_price, total_product_price, total_cost_price, sms_payer, sms_price")->select()->toArray();
        $total_price      = 0;
        $total_cost_price = 0;
        $cost_price       = 0;
        foreach ($order as $value) {
            $total_price += (float) $value['total_product_price'];
            $total_cost_price += (float) $value["total_cost_price"];
            if ($value['sms_payer'] == 1) {
                $cost_price += (float) $value["sms_price"];
            }
        }
        $total_profit               = round($total_price - $total_cost_price - $cost_price, 2);
        $charts                     = [];
        $charts['total_price']      = $total_price;
        $charts['total_cost_price'] = $total_cost_price;
        $charts['total_profit']     = $total_profit;
        $this->success(
            '获取成功',
            $charts
        );
    }
    public function money()
    {
        $where = $this->request->params([
            ['status', 1],
            ['date_range', ''],
            ['trade_no', ''],
            ['goods_id', ''],
        ]);
        $res   = $this->user->orders()->withSearch($where[0], $where[1])->order("id desc")->paginate($this->limit)->each(function ($item, $key) {
            $item->setAttr('cards_count', $item->cards_count);
            $item->paytype = get_paytype($item['paytype'])?->name;
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
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    public function rankList()
    {
        $where = $this->request->params([
            ['date_range', ''],
            ['keywords', ''],
            ['type', 0],
            ['user_id', $this->user->id],
            ['status', 1]
        ]);
        $res   = $this->user->orders()->withSearch($where[0], $where[1])->field("contact,sum(total_price) as money,count(*) as times")->group("contact")->order("money desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

}
