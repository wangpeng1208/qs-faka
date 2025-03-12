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

namespace app\adminapi\controller\channel;

use app\common\model\Channel as ChannelModel;
use app\common\model\UserRoleRate as UserRoleRateModel;
use app\common\model\ChannelAccount as ChannelAccountModel;
use app\adminapi\controller\Base;

class Collection extends Base
{
    /**
     * @notes 收款通道列表
     * @auth true
     */
    public function list(ChannelModel $channelModel)
    {
        //  type 1收款 2打款
        $type = inputs('type', 1);
        // is_custom 0官方渠道
        $is_custom = inputs('is_custom', 0);
        $res       = $channelModel->where(['type' => $type, 'is_custom' => $is_custom])->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * 收款通道 label value
     * @auth false
     */
    public function listSimple()
    {
        $type = inputs('type', 1);
        $res  = ChannelModel::where(['type' => $type, 'is_custom' => 0])->field('id as value,title as label')->order('sort asc')->select()->toArray();
        $this->success('获取成功', $res);
    }

    /**
     * @notes 通道详情
     * @auth false
     */
    public function detail()
    {
        $id   = inputs('id/d', 0);
        $data = ChannelModel::where(['id' => $id])->find();

        $data['lowrate'] *= 1000;
        $this->success('success', $data);
    }

    /**
     * @notes 删除通道
     * @auth true
     */
    public function del()
    {
        $id  = inputs('id/d', 0);
        $res = ChannelModel::destroy($id);
        //  删除通道时删除通道费率
        UserRoleRateModel::where('channel_id', $id)->delete();
        // 删除通道时删除通道下的所有账号
        ChannelAccountModel::where('channel_id', $id)->delete();
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * post数据验证
     */
    private function postData()
    {
        $data     = [
            'id'             => inputs('id/d', ''),
            'title'          => inputs('title'),
            'lowrate'        => inputs('lowrate'),
            'paytype'        => inputs('paytype'),
            'status'         => inputs('status'),
            'show_name'      => inputs('show_name'),
            'is_available'   => inputs('is_available'),
            'sort'           => inputs('sort'),
            'type'           => inputs('type'),
            'code'           => inputs('code'),
            'account_fields' => inputs('account_fields'),
            'default_fields' => inputs('default_fields', ''),
            'applyurl'       => inputs('applyurl'),
            'is_custom'      => inputs('is_custom', 0),
        ];
        $validate = new \app\adminapi\validate\channel\CollectionValidate;
        $validate->scene('collection')->failException(true)->check($data);
        $data['lowrate'] /= 1000;
        return $data;
    }

    /**
     * @notes 添加通道
     * @auth true
     */
    public function add()
    {
        $data      = array_diff_key($this->postData(), ['id']);
        $res       = ChannelModel::create($data);
        $res->sort = $res->id;
        $res->save();
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }

    /**
     * @notes 编辑通道
     * @auth true
     */
    public function edit()
    {
        $data = $this->postData();
        $res  = ChannelModel::update($data);
        return $res ? $this->success('操作成功') : $this->error('操作失败');
    }
}