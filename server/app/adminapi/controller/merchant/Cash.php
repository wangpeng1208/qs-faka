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

namespace app\adminapi\controller\merchant;

use think\facade\Db;
use app\adminapi\controller\Base;
use app\common\model\Cash as CashModel;
use app\common\model\User as UserModel;
use app\service\notify\CashService as CashNotifyService;

class Cash extends Base
{
    /**
     * @notes 提现列表
     * @auth true
     */
    public function list()
    {
        $where = $this->request->params([
            ['date_type', ''],
            ['username', ''],
            ['type', ''],
            ['status', ''],
            ['date_range', ''],
        ]);

        $res = CashModel::withSearch($where[0], $where[1])->order('id desc')->paginate($this->limit)->each(function ($item) {
            $item->username = $item->user->username;
        });
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 提现统计
     * @auth false
     */
    public function cashCount(CashModel $cash_model)
    {
        //今日结算总金额
        $data['todaysum'] = $cash_model->whereTime('create_at', 'today')->sum('money');
        //结算总金额
        $data['totalsum'] = $cash_model->where(['status' => 1])->sum('money');
        //结算手续费
        $data['totalfee'] = $cash_model->where(['status' => 1])->sum('fee');
        //实结金额
        $data['totalactual'] = $cash_model->where(['status' => 1])->sum('actual_money');
        //未结金额
        $data['totalmoney'] = UserModel::sum('money');
        foreach ($data as $key => $value) {
            $data[$key] = number_format($value, 2, '.', '');
        }
        $res = [
            ['name' => '今日结算总金额', 'value' => $data['todaysum']],
            ['name' => '结算总金额', 'value' => $data['totalsum']],
            ['name' => '结算手续费', 'value' => $data['totalfee']],
            ['name' => '实结金额', 'value' => $data['totalactual']],
            ['name' => '未结金额', 'value' => $data['totalmoney']],
        ];
        $this->success('获取成功', $res);
    }

    /**
     * @notes 代付打款
     */
    public function autoPass()
    {
        $this->error('请使用命令行操作');
    }

    /**
     * @notes 提现通过
     * @auth true
     */
    public function pass()
    {
        $cash_id = inputs('id/d', 0);
        $cash    = CashModel::findOrFail($cash_id);

        $cash->status == 1 && $this->error('已经审核通过，无需再次审核！');
        // 不设置此处，有一直回款的风险
        $cash->status == 2 && $this->error('已经审核不通过，无法操作！');

        Db::startTrans();
        try {
            $cash->status      = 1;       //审核通过
            $cash->complete_at = time();
            $cash->save();
            // 记录用户金额变动日志
            $reason = "申请提现成功，提现金额{$cash->money}元，手续费{$cash->fee}元，实际到账{$cash->actual_money}元";
            record_user_money_log('cash_success', $cash->user_id, 0, $cash->user->money, $reason);
            // 发送通知：提现通知
            $user = $cash->user()->lock(true)->find();
            (new CashNotifyService())->notify($user, $cash->money, $cash->fee, $cash->actual_money);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error('操作失败！' . $e->getMessage());
        }
        $this->success('操作成功！');
    }

    /**
     * @notes 提现驳回
     * @auth true
     */
    public function refuse()
    {
        $cash_id = inputs('id/d', 0);
        $cash    = CashModel::findOrFail($cash_id);

        $cash->status == 2 && $this->error('已经审核不通过，无法操作！');

        $reason = inputs('reason/s', '');
        Db::startTrans();
        try {
            $cash->status = 2;
            $cash->save();
            $user        = $cash->user()->lock(true)->find();
            $user->money += $cash->money;
            $user->save();
            // 记录用户金额变动日志
            $reason = "申请提现未通过，返还金额{$cash->money}元，原因：" . $reason;
            record_user_money_log('cash_notpass', $cash->user_id, $cash->money, $cash->user->money, $reason);
            // 发送通知：提现通知
            (new CashNotifyService())->notify($user, $cash->money, $cash->fee, $cash->actual_money, $reason);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error('操作失败！' . $e->getMessage());
        }
        $this->success('操作成功！');
    }

    /**
     * @notes 删除提现记录
     * @auth true
     */
    public function del()
    {
        $cash_id = inputs('id/d', 0);
        $cash    = CashModel::findOrFail($cash_id);
        if ($cash->status != 1) {
            $this->error('只能删除已经审核通过的记录！');
        }
        return $cash->delete() ? $this->success('删除成功', '') : $this->error('删除失败', '');
    }

    /**
     * @notes 批量删除提现记录
     * @auth true
     */
    public function delBatch()
    {
        $ids = inputs("ids/a", []);
        if (empty($ids)) {
            $this->error("请选择要删除的日志！");
        }
        $res = CashModel::destroy($ids);
        return $res ? $this->success("删除成功！") : $this->error("删除失败，请重试！");
    }
    
}
