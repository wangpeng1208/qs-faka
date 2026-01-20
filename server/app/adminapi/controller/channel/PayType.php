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

use app\common\model\PayType as PayTypeModel;
use app\common\model\Channel as ChannelModel;
use app\adminapi\controller\Base;

/**
 * 支付类型管理
 */
class PayType extends Base
{

  /**
   * @notes 支付方式分类列表
   * @auth true
   */
  public function list()
  {
    $res = PayTypeModel::order("id asc")->paginate($this->limit);
    $this->success('获取成功', [
      'list'  => $res->items(),
      'total' => $res->total(),
    ]);
  }

  /**
   * @notes 支付方式分类详情
   * @auth false
   */
  public function detail()
  {
    $id   = inputs('id/d', 0);
    $data = PayTypeModel::where(['id' => $id])->find();
    return $this->success('success', $data);
  }

  private function post()
  {
    $data = [
      'id'   => inputs('id/d', 0),
      'name' => inputs('name'),
      'logo' => inputs('logo/s', ''),
      'ico'  => inputs('ico/s', ''),
    ];
    // 验证数据
    $validate = new \app\adminapi\validate\channel\PayTypeValidate;
    $validate->failException(true)->check($data);
    return $data;
  }

  /**
   * @notes 添加支付方式分类
   * @auth true
   */
  public function add()
  {
    $data = array_diff_key($this->post(), ['id' => 0]);
    $res  = PayTypeModel::create($data);
    return $res ? $this->success('操作成功') : $this->error('操作失败');
  }

  /**
   * @notes 编辑支付方式分类
   * @auth true
   */
  public function edit()
  {
    $data = $this->post();
    $res  = PayTypeModel::update($data);
    return $res ? $this->success('操作成功') : $this->error('操作失败');
  }

  /**
   * @notes 删除支付方式分类
   * @auth true
   */
  public function del()
  {
    $id  = inputs('id/d', 0);
    // 验证是否在使用中
    if(ChannelModel::where('paytype', $id)->find()) {
      $this->error('使用中，禁止删除');
    }
    $res = PayTypeModel::destroy($id);
    return $res ? $this->success('操作成功') : $this->error('操作失败');
  }

  /**
   * 获取支付方式分类下拉选择
   * @auth false
   */
  public function payTypeSimple()
  {
    $list = PayTypeModel::field('id as value,name as label,ico')->order('id asc')->select()->toArray();
    $this->success('success', $list);
  }
}
