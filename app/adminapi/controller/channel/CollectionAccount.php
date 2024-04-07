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

namespace app\adminapi\controller\channel;

use app\adminapi\controller\Base;
use app\common\model\Channel as ChannelModel;
use app\common\model\ChannelAccount as ChannelAccountModel;

class CollectionAccount extends Base
{

  /**
   * @notes 收款通道列表
   * @auth true
   */
  public function list()
  {
    $channel_id = input('id/d', 0);
    $res        = ChannelAccountModel::where(['channel_id' => $channel_id])->paginate($this->limit)->each(function ($item, $key) {
      $item->code           = $item->channel->code;
      $item->rate_type_text = $item->rate_type == 1 ? '单独设置' : '继承接口';
    });
    $this->success('获取成功', [
      'list'  => $res->items(),
      'total' => $res->total(),
    ]);
  }

  /**
   * @notes 获取渠道账户字段
   * @auth false
   */
  public function getFields()
  {
    $channel_id = input('channel_id/d', 0);
    $data       = [];
    $res        = ChannelModel::find($channel_id);
    if ($res) {
      if ($res->account_fields != '') {
        $account_fields = explode('|', $res->account_fields);
        foreach ($account_fields as $key => $value) {
          [$label, $name] = explode(':', $value);
          if (isset($name)) {
            $data[$key]['label'] = $label;
            $data[$key]['name']  = $name;
          }
        }
      }
    }
    $this->success('success', $data);
  }

  /**
   * @notes 获取支付渠道账户详情
   * @auth false
   */
  public function detail()
  {
    $id              = input('id/d', 0);
    $data            = ChannelAccountModel::where(['id' => $id])->find();
    $data['lowrate'] *= 1000;
    return $this->success('success', $data);
  }

  private function post()
  {
    $data     = [
      'id'         => input('id/d', ''),
      'name'       => input('name/s', ''),
      'rate_type'  => input('rate_type/d', 0),
      'status'     => input('status/d', 0),
      'params'     => input('params/a', []),
      'channel_id' => input('channel_id/d', 0),
    ];
    $validate = new \app\adminapi\validate\channel\CollectionAccountValidate;
    $validate->failException(true)->check($data);
    if ($data['rate_type'] == 1) {
      $data['lowrate'] = input('lowrate/d', 0);
      $data['lowrate'] /= 1000;
    }
    return $data;
  }

  /**
   * @notes 添加通道账号
   * @auth true
   */
  public function add()
  {
    $data = array_diff_key($this->post(), ['id']);
    $res  = ChannelAccountModel::create($data);
    return $res ? $this->success('操作成功！') : $this->error('操作失败！');
  }

  /**
   * @notes 编辑通道账号
   * @auth true
   */
  public function edit()
  {
    $data = $this->post();
    $res  = ChannelAccountModel::update($data);
    return $res ? $this->success('操作成功！') : $this->error('操作失败！');
  }

  /**
   * @notes 删除通道账号
   * @auth true
   */
  public function del()
  {
    $id      = input('id/d', 0);
    $account = ChannelAccountModel::find($id);
    if (empty($account)) {
      $this->error('账户不存在');
    }
    $res = ChannelAccountModel::destroy($id);
    return $res ? $this->success('删除成功！') : $this->error('删除失败！');
  }

  /**
   * @notes 通道账号状态
   * @auth true
   */
  public function status()
  {
    $account_id = input('id/d', 0);
    $account    = ChannelAccountModel::find($account_id);
    if (empty($account)) {
      return $this->error('账号不存在');
    }
    $status          = input('status/d', 1);
    $account->status = $status;
    $res             = $account->save();
    $remark          = $status == 1 ? '开启' : '关闭';
    return $res ? $this->success($remark . '成功！') : $this->error($remark . '失败，请重试！');
  }
}
