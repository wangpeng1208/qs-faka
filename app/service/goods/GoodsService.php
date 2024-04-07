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

namespace app\service\goods;

use think\facade\Db;
use app\common\model\Order as OrderModel;
use app\service\notify\GoodsStockLackService;

class goodsService
{
    public function sendOut($trade_no)
    {
        $order = OrderModel::where(["trade_no" => $trade_no])->find() ?: throw new \Exception("订单不存在");
        if ($order->status == 0) {
            throw new \Exception("订单未付款，请重新支付，或联系客服处理！");
        }
        if ($order->status == 2) {
            throw new \Exception("订单超时未付款，系统已自动关闭该订单！");
        }
        if ($order->status == 3) {
            throw new \Exception("订单已经退款，不支持查看详情！");
        }
        $goods = $order->goods;
        $cards_count = $order->cards()->count(); // 已出卡数量
        if (!$cards_count && !$goods) {
            throw new \Exception("商品不存在，请联系客服处理！");
            // return json(["msg" => "商品不存在，请联系客服处理！", "quantity" => 0, "status" => 0]);
        }
        // 用户设置的库存提醒
        if ($goods->inventory_notify > $goods->cards_stock_count) {
            // 通知用户 卡密不足
            (new GoodsStockLackService())->notify($goods->user, $goods);
        }
        // 出卡量小于订单量的出卡，则开始出卡
        if ($cards_count < $order->quantity) {
            if ($goods->cards_stock_count < $order->quantity) {
                throw new \Exception("商品库存不足，请联系客服补充库存后再取卡密！");
            }
            $limit = $order->quantity - $cards_count;
            // card_order出卡顺序  先售老卡0 先售新卡1  随机售卡2 自主选号3
            if ($goods->card_order == 0) {
                $cards = $goods->cards()->where("status", 1)->lock(true)->limit($limit)->order("unfreeze_at desc,is_first desc,create_at asc,id asc")->select();
            } elseif ($goods->card_order == 1) {
                $cards = $goods->cards()->where("status", 1)->lock(true)->limit($limit)->order("unfreeze_at desc,is_first desc,create_at desc,id desc")->select();
            } elseif ($goods->card_order == 2) {
                $cards = $goods->cards()->where("status", 1)->lock(true)->limit($limit)->order("is_first desc,unfreeze_at desc")->orderRaw("rand()")->select();
            } elseif ($goods->card_order == 3) {
                $order->select_cards = $order->select_cards ? $order->select_cards : [];
                $cards               = $goods->cards()->where("status", 1)->where("id", "in", $order->select_cards)->lock(true)->limit($limit)->order("unfreeze_at desc")->select();
                // 自主选号的卡密不足时，补充其他卡密
                if (count($cards) < $limit) {
                    $tod_limit = $limit - count($cards);
                    $tod_cards = $goods->cards()->where("status", 1)->where("id", "not in", $order->select_cards)->lock(true)->limit($tod_limit)->order("unfreeze_at desc,create_at asc,id asc")->select();
                    $cards     = array_merge((array) $cards, (array) $tod_cards);
                }
            } else {
                $cards = $goods->cards()->where("status", 1)->lock(true)->limit($limit)->order("unfreeze_at desc,is_first desc,create_at asc,id asc")->select();
            }
            $data_cards = [];

            if ($cards) {
                foreach ($cards as $card) {
                    $data_cards[] = ["order_id" => $order->id, "number" => $card->number, "secret" => $card->secret, "card_id" => $card->id];
                }
                Db::startTrans();
                try {
                    // order_card表插入数据
                    $res = $order->cards()->saveAll($data_cards);
                    // goods_card表更新数据
                    $goods->cards()->where("id", "in", array_column($data_cards, "card_id"))->update(["status" => 2, "sell_time" => time()]);
                    // echo 'ress'. $ress;
                    if (!$res) {
                        throw new \Exception("服务器繁忙，请稍候刷新页面");
                    }

                    $order->sendout = count($data_cards);
                    $res            = $order->where(["trade_no" => $trade_no])->update(['sendout' => $order->sendout]);

                    if ($res) {
                        $order_card_quantity = $order->cards()->count();
                        // echo  $order_card_quantity;
                        if ($order_card_quantity <= $order->quantity) {
                            Db::commit();
                        } else {
                            Db::rollback();
                            throw new \Exception("请刷新页面重试-01");
                        }
                    } else {
                        Db::rollback();

                        throw new \Exception("请刷新页面重试sss-02");
                    }
                } catch (\Exception $e) {
                    Db::rollback();
                    throw new \Exception("出货失败，" . $e->getMessage());
                }
            }
        }

        // 购买数量 2
        $quantity     = $order['quantity'];
        $addtion_give = $goods->addtion_give;
        // 如果有额外的附加其他商品赠送
        if ($addtion_give) {
            //  是否符合赠送条件
            $need_addtions = $this->needAddtions($addtion_give, $quantity);
            // halt($need_addtions);
            if (count($need_addtions) > 0) {
                // 赠送数量 买2送1 买了2 总2+1
                $addtions_quantity = array_sum(array_column($need_addtions, 'give_num'));
                // 自购数量
                if (empty($cards)) {
                    $cards = $order->cards;
                }
                $cards_quantity = count($cards);

                // 如果卡密数据和 总数量不同 2 + 1
                if ($cards_quantity < $addtions_quantity + $quantity) {
                    // 循环获取卡密-即更新卡密表使用状态和新增购买卡密表
                    $this->goodsAddtionsCard($need_addtions, $order['id']);
                }
            }
        }
        return A(1, "出货成功");
    }

    public function needAddtions($data, $quantity)
    {
        $list = [];
        foreach ($data as $key => $value) {
            if (empty($value['bug_num']) || empty($value['give_num'])) {
                return [];
            }
            if ($quantity == $value['bug_num']) {
                $list[$key]['good_id']  = $value['good_id'];
                $list[$key]['give_num'] = $value['give_num'];
            }
        }
        return $list;
    }

    //  额外卡密信息
    public function goodsAddtionsCard($list, $order_id)
    {
        foreach ($list as $key => $value) {
            $card_list = Db::name('goods_card')->where(['goods_id' => $value['good_id'], 'status' => 1, 'delete_at' => NULL])->limit($value['give_num'])->select();
            // 			halt($card_list);
            foreach ($card_list as $k => $v) {
                $new_card_list[$k]['status']    = 2;
                $new_card_list[$k]['sell_time'] = time();
                //对应goods_id的卡密状态为2 已使用 ，且更新售出时间sell_time
                Db::name('goods_card')->where(['id' => $v['id']])->update($new_card_list[$k]);
                // 并入库该已使用的卡密到order_card表
                $order_card[$k]['order_id'] = $order_id;
                $order_card[$k]['number']   = $v['number'];
                $order_card[$k]['secret']   = $v['secret'];
                $order_card[$k]['card_id']  = $v['id'];
                Db::name('order_card')->insert($order_card[$k]);
            }
        }
    }
}
