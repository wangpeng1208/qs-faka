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

use app\service\message\MessageService;
use think\facade\Db;
use app\service\common\PayService;
use app\adminapi\controller\Base;
use app\common\model\OrderComplaint;
use app\common\model\AutoUnfreeze as AutoUnfreezeModel;
use app\common\model\OrderComplaintMessage;

class Complaint extends Base
{
    /**
     * 投诉列表
     */
    public function list()
    {
        $where = $this->request->params([
            ['id', ''],
            ['user_id', ''],
            ['username', ''],
            ['trade_no', ''],
            ['status', ''],
            ['admin_read', ''],
            ['type', ''],
            ['date_range', ''],
        ]);
        $res   = OrderComplaint::withSearch($where[0], $where[1])->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->username   = $item->user->username;
            $item->parentname = $item->user->parent->username ?? "";
        });
        return $this->success("获取成功", [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);

    }

    /**
     * 投诉详情
     */
    public function detail()
    {

        $id        = inputs("id/d");
        $complaint = OrderComplaint::findOrFail($id);

        if (!$complaint->admin_read) {
            OrderComplaintMessage::create([
                "from"      => $this->user->id,
                "trade_no"  => $complaint->trade_no,
                "content"   => "我们已收到您的投诉请求,并通知了商家,请耐心等待",
                "type"      => 'admin',
                "create_at" => time()
            ]);
        }
        // 打开详情后，管理员已读 
        $complaint->admin_read = 1;
        $complaint->save();

        $messages = $complaint->messages()->order('id desc')->select();
        return $this->success("获取成功", [
            'complaint' => $complaint,
            'messages'  => $messages,
        ]);
    }

    /**
     * 投诉消息发送
     */
    public function send()
    {
        $content   = inputs("content/s", "") ?: $this->error('请输入沟通内容');
        $id        = inputs("id/d", "");
        $complaint = OrderComplaint::findOrFail($id);
        $post      = [
            "from"      => $this->user->id,
            "type"      => 'admin',
            "trade_no"  => $complaint->trade_no,
            "content"   => $content,
            "create_at" => time()
        ];
        $res       = OrderComplaintMessage::create($post);

        return $res ? $this->success("发送成功") : $this->error("发送失败");
    }

    // 使用 Db::raw('score+1') 可以防止出现竞态条件 或者 inc dec, 但是inc dec查最新数据需要使用 refresh()
    public function win()
    {
        $id        = inputs("id/d");
        $complaint = OrderComplaint::where(["id" => $id])->find();
        if (!$complaint) {
            $this->error("投诉不存在");
        }
        if ($complaint->status != 0) {
            $this->error("投诉已处理");
        }
        $trade_no          = $complaint->trade_no;
        $result            = inputs("result/d");
        $complaint->status = 1;
        $complaint->result = $result;
        $order             = $complaint->orders;
        $user              = $complaint->user()->lock(true)->find();
        DB::startTrans();
        try {
            $res = $complaint->save();
            if ($res) {
                // 商家胜诉
                if ($result == 1) {
                    // 资金冻结表处理 
                    $auto_unfreeze = AutoUnfreezeModel::where([
                        "trade_no" => $trade_no,
                        "status"   => -1
                    ])->select();
                    if (empty(count($auto_unfreeze))) {
                        throw new \Exception("资金冻结中不存在该订单，无法判决。【资金信息未找到或已被结算】");
                    }
                    // 更新所有该订单资金的冻结记录
                    AutoUnfreezeModel::update(["status" => 1], ["trade_no" => $order->trade_no]);

                    // 订单解冻
                    $order->is_freeze = 0;
                    $res              = $order->save();
                    // T1订单 ，只需要给商户发送一条消息
                    $user = $complaint->user()->lock(true)->find();
                    MessageService::send(0, $user->id, "投诉胜诉", "投诉订单：" . $trade_no . "。结果：商家胜诉，资金可正常结算。");

                    DB::commit();
                } else {
                    AutoUnfreezeModel::where(["trade_no" => $complaint->trade_no])->delete();
                    // 官方渠道 扣除冻结金额
                    $user = $complaint->user()->lock(true)->find();

                    $user->freeze_money = round($user->freeze_money - $order->finally_money, 3);
                    $user->save();
                    // $user->money 应该显示对应的 比如 余额 保证金 预存款的剩余 ；不然操作 保证金 预存款 ，用的的余额资金明细没有任何变化
                    record_user_money_log("goods_refund", $order->user_id, -1 * $order->finally_money, $user->money, "订单败诉，扣除冻结金额，扣除金额：" . $order->finally_money . "元");

                    $order->status = 3;
                    $order->save();
                    DB::commit();

                    if (conf("complaint_refund") == 1) {
                        if ($order->channel->is_custom == 1) {
                            return J(200, "判决成功商家投诉保证金已扣除,商家自定义支付通道不支持退款，您需要人工联系买家进行退款！");
                        }
                        $pay         = new PayService();
                        $pay_channel = $pay->invoke($order->channel->code);
                        if (method_exists($pay_channel, "refund")) {
                            $refund_result = $pay_channel->refund($order);
                            if ($refund_result["code"] == 1) {
                                return J(200, "判决成功商家余额已扣除,买家已通过API退款。");
                            } else {
                                return J(200, "判决成功商家余额已扣除,API退款失败请手动操作！（" . $refund_result["msg"] . "），您需要人工联系买家进行退款！");
                            }
                        } else {
                            return J(200, "判决成功商家余额已扣除,当前支付通道不支持退款，您需要人工联系买家进行退款！");
                        }
                    } else {
                        return J(200, "判决成功商家余额已扣除,您需要人工联系买家进行退款！");
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            if ($e->getMessage()) {
                $this->error($e->getMessage());
            } else {
                $this->error("判决失败");
            }
        }
        $this->success("判决成功");
    }

    public function del()
    {
        $id  = inputs("id/d", 0);
        $res = OrderComplaint::destroy($id);
        return $res ? $this->success("删除成功") : $this->error("删除失败");
    }
}
