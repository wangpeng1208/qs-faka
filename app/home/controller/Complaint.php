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

namespace app\home\controller;

use think\facade\Db;
use support\Cache;
use app\service\sms\SmsService;
use app\common\model\Order as OrderModel;
use app\common\model\OrderComplaint as ComplaintModel;
use app\common\model\AutoUnfreeze as AutoUnfreezeModel;
use app\common\model\OrderComplaintMessage as ComplaintMessage;

class Complaint extends Base
{
    /**
     * 买家投诉
     */
    public function doComplaint()
    {
        $post = [
            'trade_no' => inputs('trade_no', ''),
            'type'     => inputs('type', ''),
            'qq'       => inputs('qq', ''),
            'mobile'   => inputs('mobile', ''),
            'desc'     => inputs('desc', ''),
        ];

        $validate = new \app\home\validate\ComplaintValidate;
        $validate->failException(true)->check($post);
        $order = OrderModel::where(["trade_no" => $post['trade_no']])->findOrFail();

        try {
            Db::startTrans();
            $pwd    = rand(100000, 999999);
            $result = ComplaintModel::create([
                "user_id"              => $order->user_id,
                "proxy_parent_user_id" => $order->proxy_parent_user_id,
                "trade_no"             => $post['trade_no'],
                "type"                 => $post['type'],
                "qq"                   => $post['qq'],
                "mobile"               => $post['mobile'],
                "desc"                 => $post['desc'],
                "status"               => 0,
                "create_at"            => time(),
                "create_ip"            => $this->request->ip(),
                "pwd"                  => $pwd,
                "expire_at"            => time() + 86400,
                "buyer_qrcode"         => ''
            ]);

            $user = $order->user()->lock(true)->find();

            if ($user->isEmpty()) {
                Db::rollback();
                $this->error("商户不存在");
            }

            if (!empty($result)) {
                $unfreeze_time = strtotime(date('Y-m-d', strtotime('+1 day'))) - 1;

                $auto_freeze = AutoUnfreezeModel::update(["status" => -1, "unfreeze_time" => $unfreeze_time], ["trade_no" => $order->trade_no]);

                if ($auto_freeze) {
                    $order->is_freeze = 1;
                    if ($order->save()) {
                        Db::commit();

                        $sms = new SmsService();
                        // 向买家发送投诉短信 短信密码
                        $sms->sendSms('complaint_to_buyer', $post['mobile'], [
                            'trade_no' => $post['trade_no'],
                            'code'     => $pwd
                        ]);
                        // 向商户发送投诉短信
                        $sms->sendSms('complaint_to_merchant', $order->user->mobile, [
                            'trade_no' => $post['trade_no']
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Db::rollback();
            $this->error("操作失败，请重试！" . $e->getMessage());
        }
        $this->success("投诉成功！");
    }


    /**
     * 投诉订单查询
     */
    public function complaintQuery()
    {
        $trade_no  = inputs('trade_no');
        $pwd       = inputs('pwd');
        $complaint = ComplaintModel::where([
            "trade_no" => $trade_no,
            "pwd"      => $pwd
        ])->find();
        if (!empty($complaint)) {
            $post['messages']  = $complaint->messages;
            $post['order']     = $complaint->orders;
            $post['complaint'] = $complaint;
            // 记录缓存
            $ip = $this->request->ip();
            // 记录ip缓存 用于验证发送聊天权限和push消息通道权限
            Cache::set('complaint_query_' . $complaint->id, $ip, 86400);
            $this->success('密码正确！', $post);
        } else {
            $this->error('密码不正确，如有问题请联系客服处理！');
        }
    }

    /**
     * 买家投诉信息发送
     */
    public function send()
    {
        $content     = inputs("content/s", "") ?: $this->error('请输入沟通内容');
        $id          = inputs("id/d", "") ?: $this->error('参数错误');
        $complaint   = ComplaintModel::findOrFail($id);
        $check_cache = Cache::get('complaint_query_' . $complaint->id);
        if ($check_cache !== $this->request->ip()) {
            $this->error('非法操作');
        }
        $post = [
            "from"      => 0,
            "type"      => 'buyer',
            "trade_no"  => $complaint->trade_no,
            "content"   => $content,
            "create_at" => time()
        ];
        $res  = ComplaintMessage::create($post);

        return $res ? $this->success("发送成功") : $this->error("发送失败");
    }
}
