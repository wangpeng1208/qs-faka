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

namespace app\adminapi\controller\order;

use app\adminapi\controller\Base;
use app\common\model\Order as OrderModel;
use app\service\analysis\AnalysisService;
use app\service\order\OrderService;
use think\facade\Db;

class Order extends Base
{
    /**
     * @notes 订单列表
     * @auth true
     */
    public function list(OrderModel $model)
    {
        $where = $this->request->params([
            ['date_type', ''],
            ['username', ''],
            ['contact', ''],
            ['trade_no', ''],
            ['transaction_id', ''],
            ['channel_id', ''],
            ['paytype', ''],
            ['status', ''],
            ['is_freeze', ''],
            ['date_range', ''],
            ['card', ''],
            ['order_type', ''],
        ]);
        $res   = $model->with(['channel', 'user', 'shop'])
            ->visible(['shop' => ['shop_name'], 'channel' => ['title']])
            ->withCache(30)
            ->withSearch($where[0], $where[1])->order("id desc")
            ->paginate($this->limit)
            ->each(function ($item, $key) {
                $item->cards_count = $item->cards()->count();
            });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 一键清空无效订单
     */
    public function clear()
    {
        $res = OrderModel::where(["status" => 2])->delete();
        return $res ? $this->success("清空成功！") : $this->error("清空失败！");
    }

    /**
     * @notes 订单删除
     * @auth true
     */
    public function del()
    {
        $id    = inputs('id/d', 0);
        $order = OrderModel::findOrFail($id);
        if ($order->status == 1) {

            $total_product_price = $order->total_product_price;
            AnalysisService::analysis_dec($order->user_id, $total_product_price, $order->finally_money, $order->finally_money - $order->total_cost_price, 1, $order->success_at);

        }
        $res = OrderModel::where(["id" => $id])->delete();
        return $res ? $this->success("删除成功！") : $this->error("删除失败！");
    }

    /**
     * @notes 后台补单
     * @auth true
     */
    public function notify()
    {
        $id    = inputs("id/d", 0);
        $order = OrderModel::findOrFail($id);
        if ($order->status != 0) {
            $this->error("该订单不是未支付状态！");
        }
        (new OrderService())->complete($order);
        $order->status = 1;
        $this->success("补单成功", $order->toArray());
    }

    /**
     * @notes 订单冻结
     * @auth true
     */
    public function freeze()
    {
        $id    = inputs("id/d", 0);
        $order = OrderModel::where(["id" => $id, "status" => 1])->findOrFail();

        $is_freeze = $order->is_freeze == 1 ? 0 : 1;

        $user          = $order->user;
        $auto_unfreeze = Db::name("pay_auto_unfreeze")->where(["trade_no" => $order->trade_no])->find();
        if (empty($auto_unfreeze)) {
            if ($is_freeze == 1) {
                $msg = "冻结";
                if ($user->money < $order->total_price) {
                    return $this->error("冻结失败！用户余额不足冻结该订单！");
                }
            } else {
                $msg = "解冻";
                if ($user->freeze_money < $order->total_price) {
                    return $this->error("解冻失败！用户冻结余额不足解冻该订单！");
                }
            }
        }
        Db::startTrans();
        try {
            $order->is_freeze = $is_freeze;
            $order->save();
            if ($is_freeze == 1) {
                $msg = "冻结";
                if (empty($auto_unfreeze)) {
                    $user->money -= $order->total_price;
                    $user->freeze_money += $order->total_price;
                    $user->save();
                    record_user_money_log("freeze", $user->id, -1 * $order->total_price, $user->money, "后台冻结订单：" . $order->trade_no . "，冻结金额：" . $order->total_price . "元");
                } else {
                    Db::table("auto_unfreeze")->where(["trade_no" => $order->trade_no])->update(["status" => -1]);
                    record_user_money_log("freeze", $user->id, 0, $user->money, "后台冻结订单：" . $order->trade_no . "，冻结金额：0元（订单收入尚未解冻）。");
                }
            } else {
                $msg       = "解冻";
                $complaint = Db::name("order_complaint")->where(["trade_no" => $order->trade_no])->find();
                if (empty($complaint) || $complaint["status"] == 1 && $complaint["result"] == 1) {
                    if (empty($auto_unfreeze)) {
                        $user->money += $order->total_price;
                        $user->freeze_money -= $order->total_price;
                        $user->save();
                        record_user_money_log("unfreeze", $user->id, $order->total_price, $user->money, "后台解冻订单：" . $order->trade_no . "，解冻金额：" . $order->total_price . "元");
                    } else {
                        Db::table("auto_unfreeze")->where(["trade_no" => $order->trade_no])->update(["status" => 1]);
                        record_user_money_log("unfreeze", $user->id, 0, $user->money, "后台解冻订单：" . $order->trade_no . "，解冻金额：0元 (订单收入尚未解冻)。");
                    }
                } else {
                    $this->error("该订单有投诉，不允许解冻");
                }
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error("更新失败，原因" . $e->getMessage());
        }
        $this->success("更新成功！", $order);
    }
}