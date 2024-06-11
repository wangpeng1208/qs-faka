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
use app\common\model\OrderComplaint as ComplaintModel;
use app\common\model\OrderComplaintMessage as ComplaintMessage;

class Complaint extends Base
{

    /**
     * 投诉列表
     * @auth false
     */
    public function list()
    {
        $where = $this->request->params([
            ['type', ''],
            ['status', ''],
        ]);
        // 自己的投诉订单
        $where2["user_id"] = $this->user->id;
        $res               = $this->user->complaints()->withSearch($where[0], $where[1])->where($where2)->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->goods_name = $item->orders->goods_name;
            unset($item->pwd);
        });

        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 代理投诉订单列表
     * @auth false
     */
    public function proxyList()
    {
        $where = $this->request->params([
            ['type', ''],
            ['status', ''],
        ]);
        // 下级代理的投诉订单  proxy_parent_user_id
        $where2["proxy_parent_user_id"] = $this->user->id;
        $res                            = ComplaintModel::withSearch($where[0], $where[1])->where($where2)->order("id desc")->paginate($this->limit)->each(function ($item) {
            $item->goods_name = $item->orders->goods_name;
            unset($item->pwd);
        });

        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 投诉详情
     * @auth false
     */
    public function detail()
    {
        $data        = [
            'id' => inputs("id/d")
        ];
        $where["id"] = $data['id'];

        $where["user_id|proxy_parent_user_id"] = $this->user->id;
        $complaint                             = $this->user->complaints()->where($where)->findOrFail();
        unset($complaint->pwd);
        $messages = $complaint->messages()->order('id desc')->select();

        $this->success('获取成功', [
            'complaint' => $complaint,
            'order'     => $complaint->orders,
            'messages'  => $messages,
        ]);
    }

    /**
     * 投诉发送
     * @auth false
     */
    public function send()
    {
        $data        = [
            'id' => inputs("id/d")
        ];
        $where["id"] = $data['id'];

        $where["user_id|proxy_parent_user_id"] = $this->user->id;
        $complaint                             = $this->user->complaints()->where($where)->findOrFail();
        $content = inputs("content/s", "") ?: $this->error('请输入沟通内容');
        if ($complaint->status == 2) {
            $this->error('投诉已处理');
        }
        // 判断我是代理还是商户
        if ($complaint->proxy_parent_user_id == $this->user->id) {
            $type = 'proxy';
        } else {
            $type = 'merchant';
        }
        $post = [
            "from"      => $this->user->id,
            "agent_id"  => $complaint->proxy_parent_user_id,
            'type'      => $type,
            "trade_no"  => $complaint->trade_no,
            "content"   => $content,
            "create_at" => time()
        ];
        $res = ComplaintMessage::create($post);
        return $res ? $this->success("发送成功") : $this->error("发送失败");
    }
}
