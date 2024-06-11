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

namespace app\merchantapi\controller\order;

use app\merchantapi\controller\Base;
use app\common\model\Order as OrderModel;
use app\common\model\OrderCard as OrderCardModel;
use app\service\goods\GoodsService;

class Order extends Base
{
    /**
     * 订单数据
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['cid', ''],
            ['type', ''],
            ['keywords', ''],
            ['paytype', ''],
            ['status', ''],
            ['date_range', ''],
            ['order_type', ''],
        ]);
        $list = $this->user->orders()->order("id desc")->withSearch($where[0], $where[1])->fetchSql(true)->paginate($this->limit)->each(function ($item) {
            $item->paytype          = get_paytype($item->paytype)->name;
            $item->take_status_text = $item->cards_count > 0
                ? ($item->cards_count >= $item->quantity ? '已取' : '已取部分')
                : '未取';
        });
        $this->success('获取成功', [
            'list'  => $list->items(),
            'total' => $list->total(),
        ]);
    }

    /**
     * 支付类型
     * @auth false
     */
    public function payType()
    {
        $data = (new \app\common\model\PayType())->select();
        $this->success('获取成功', $data);
    }

    /**
     * 查看卡密
     * @auth true
     */
    public function card()
    {
        $id    = inputs("id/d", 0) ?: $this->error("参数错误！");
        $order = OrderModel::where(['user_id' => $this->user->id])->findOrFail($id);
        (new GoodsService())->sendOut($order->trade_no);

        $card = OrderCardModel::where(["order_id" => $order->id])->selectOrFail();
        $data = [
            "trade_no" => $order->trade_no,
            "card"     => $card,
        ];
        $this->success('获取成功', $data);
    }
}