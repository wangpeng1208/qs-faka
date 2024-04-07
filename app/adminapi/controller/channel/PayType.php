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

use app\common\model\PayType as PayTypeModel;
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
    $id   = input('id/d', 0);
    $data = PayTypeModel::where(['id' => $id])->find();
    return $this->success('success', $data);
  }

  private function post()
  {
    $data = [
      'id'   => input('id/d', 0),
      'name' => input('name'),
      'logo' => input('logo/s', ''),
      'ico'  => input('ico/s', ''),
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
    if ($res) {
      return $this->success('操作成功');
    }
    return $this->error('操作失败');
  }

  /**
   * @notes 编辑支付方式分类
   * @auth true
   */
  public function edit()
  {
    $data = $this->post();
    $res  = PayTypeModel::update($data);
    if ($res) {
      return $this->success('操作成功');
    }
    return $this->error('操作失败');
  }

  /**
   * @notes 删除支付方式分类
   * @auth true
   */
  public function del()
  {
    $id  = input('id/d', 0);
    $res = PayTypeModel::destroy($id);
    if ($res) {
      return $this->success('操作成功');
    }
    return $this->error('操作失败');
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
