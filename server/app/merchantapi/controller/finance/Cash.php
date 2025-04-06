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

namespace app\merchantapi\controller\finance;

use app\merchantapi\controller\Base;
use think\facade\Db;

class Cash extends Base
{
    /**
     * @notes 提现记录
     * @auth false
     */
    public function index()
    {
        $res = $this->user->cashs()->with('user')->order("id desc")->paginate($this->limit);
        $this->success('获取成功', [
            'list'  => $res->items(),
            'total' => $res->total(),
        ]);
    }

    /**
     * @notes 资金收款配置
     * cash_type 提现方式 1自动提现 2手动提现
     * @auth false
     */
    public function setUserCashType()
    {
        $cash_type             = inputs("cash_type/d", 1);
        $this->user->cash_type = $cash_type;

        $res = $this->user->save();
        return $res ? $this->success("保存成功") : $this->error("保存失败");
    }

    // 收款设置获取
    public function getCollect()
    {
        // 提现方式
        $data['cash_type'] = $this->user->cash_type;
        // 系统提现配置options cashTypesOptions
        $cashTypeOptions          = [
            ['value' => 1, 'label' => '支付宝'],
            ['value' => 2, 'label' => '微信'],
            ['value' => 3, 'label' => '银行卡'],
        ];
        $conf_cashTypeOptions     = conf('cash_type');
        $data['cashTypesOptions'] = array_filter($cashTypeOptions, function ($v) use ($conf_cashTypeOptions) {
            return in_array($v['value'], $conf_cashTypeOptions);
        });
        // 收款信息
        $data['info'] = $this->user->collect;
        $this->success('获取成功', $data);
    }

    /**
     * 商户收款方式
     *
     */
    public function setCollect()
    {
        Db::startTrans();
        $user_collect = $this->user->collect;
        if (!empty($user_collect) && !$user_collect->allow_update) {
            Db::rollback();
            $this->error("当前不允许修改您的收款信息！");
        }
        if (inputs("type/d", '') === 3) {
            $info = [
                'account'       => inputs("account/s", ''),
                'realname'      => inputs("realname/s", ''),
                'idcard_number' => inputs("idcard_number/s", ''),
                'bank_name'     => inputs("bank_name/s", ''),
                'bank_branch'   => inputs("bank_branch/s", ''),
                'bank_card'     => inputs("idcard_number/s", '')
            ];
        } else {
            $info = [
                'account'       => inputs("account/s", ''),
                'realname'      => inputs("realname/s", ''),
                'idcard_number' => inputs("idcard_number/s", ''),
            ];
        }
        $data = [
            "user_id"   => $this->user->id,
            "info"      => $info,
            "type"      => inputs("type/d", ''),
            "create_at" => time()
        ];
        foreach ($data['info'] as $val) {
            empty($val) && $this->error("资料填写不完整或存在非法字符！");
        }

        $data["allow_update"] = 0;
        $data["collect_img"]  = inputs("collect_img/s", '');
        if ($user_collect) {
            $res = $user_collect->update($data, array("user_id" => $this->user->id));
        } else {
            $user_collect = new \app\common\model\UserCollect();
            $res          = $user_collect::create($data);
        }
        if ($res !== false) {
            Db::commit();
            $this->success("保存成功！");
        } else {
            Db::rollback();
            $this->error("保存失败，请重试！");
        }
    }

    /**
     * @notes 申请提现配置详情信息
     * @auth false
     */
    public function applyConfig()
    {
        $cash_limit_time_start = intval(conf("cash_limit_time_start"));
        $cash_limit_time_end   = intval(conf("cash_limit_time_end"));

        // 手续费类型
        $cash_fee_type = conf("cash_fee_type");
        $cash_fee      = conf('cash_fee');
        if ($cash_fee_type == 1) {
            $cash_fee = $cash_fee >= 0 ? round($cash_fee, 2) : 0; // 固定
        } else {
            $cash_fee = $cash_fee . '%'; // 前端动态计算 仅显示
        }

        // 自动提现手续费
        $auto_cash_fee_type = conf("auto_cash_fee_type");
        $auto_cash_fee      = conf('auto_cash_fee');
        if ($auto_cash_fee_type == 1) {
            $auto_fee = $auto_cash_fee >= 0 ? round($auto_cash_fee, 2) : 0; // 固定
        } else {
            $auto_fee = $auto_cash_fee . '%'; // 前端动态计算 仅显示
        }

        // 剩余提现次数
        $count     = $this->user->cashs()->whereTime('create_at', 'today')->count();
        $limit_num = intval(conf("cash_limit_num")) - $count;

        $this->success('获取成功', [
            'user'            => $this->user->visible(['id', 'money', 'freeze_money', 'cash_type']),
            'limit_num'       => $limit_num,
            'cash_fee_type'   => $cash_fee_type,
            'cash_fee'        => $cash_fee,
            'auto_cash_fee'   => $auto_fee,
            'cash_limit_time' => $cash_limit_time_start . ":00 ~ " . $cash_limit_time_end . ":00",
            'cash_min_money'  => conf("cash_min_money"),
            'auto_cash_money' => conf("auto_cash_money"),
        ]);
    }

    /**
     * @notes 申请提现
     * @auth false
     */
    public function apply()
    {
        $cash_limit_time_start = intval(conf("cash_limit_time_start"));
        $cash_limit_time_end   = intval(conf("cash_limit_time_end"));

        // 系统关闭 提现
        conf("cash_status") == 0 && $this->error(conf("cash_close_tips"));
        // 检查用户状态
        $this->user->is_freeze == 1 && $this->error("无法申请提现操作，您的账户已被冻结！");
        // 检查用户是否设置收款信息
        !$this->user->collect && $this->error("您还未设置收款信息！");

        // 检查是否在允许提现时间
        $h = intval(date("H"));
        if ($h < $cash_limit_time_start || $cash_limit_time_end < $h) {
            $this->error("不在允许提现时间（" . $cash_limit_time_start . ":00 ~ " . $cash_limit_time_end . ":00）");
        }

        // 检查今日提现次数
        $count = $this->user->cashs()->whereTime('create_at', 'today')->count();
        // 没有提现次数提示语
        if (intval(conf("cash_limit_num")) - $count <= 0)
            $this->error(conf("cash_limit_num_tips"));
        $money = inputs("money/f", 0);
        if ($money <= 0)
            $this->error("提现金额不能小于等于0！");
        if ($money < conf("cash_min_money"))
            $this->error("提现金额不能小于最低提现金额！");
        if ($this->user->money < $money)
            $this->error("您的余额不足以提现");

        $text    = "";
        $collect = $this->user->collect;
        switch ($collect->type) {
            case 1:
                $text .= "支付宝账号：" . $collect->info->account . "<br>";
                $text .= "真实姓名：" . $collect->info->realname . "<br>";
                $text .= "身份证号：" . $collect->info->idcard_number;
                break;
            case 2:
                $text .= "微信账号：" . $collect->info->account . "<br>";
                $text .= "真实姓名：" . $collect->info->realname . "<br>";
                $text .= "身份证号：" . $collect->info->idcard_number;
                break;
            case 3:
                $text .= "开户银行：" . $collect->info->bank_name . "<br>";
                $text .= "开户地址：" . $collect->info->bank_branch . "<br>";
                $text .= "收款账号：" . $collect->info->bank_card . "<br>";
                $text .= "真实姓名：" . $collect->info->realname . "<br>";
                $text .= "身份证号：" . $collect->info->idcard_number;
                break;
        }
        Db::startTrans();
        try {
            $user        = $this->user;
            $user->money -= $money;
            $money_text  = "申请提现金额" . $money . "元";
            record_user_money_log("apply_cash", $user->id, -$money, $user->money, $money_text);

            $cash_fee = $this->cashFee($money);

            $data = [
                "user_id"      => $user->id,
                "type"         => $collect->type,
                "collect_info" => $text,
                "collect_img"  => $collect->collect_img,
                "auto_cash"    => 0, // 手动提现
                "money"        => $money,
                "fee"          => $cash_fee,
                "actual_money" => round($money - $cash_fee, 2),
                "status"       => 0,
                "create_at"    => time()
            ];
            switch (intval($collect->type)) {
                case 1:
                    $cash_data = array_merge($data, ["bank_card" => $collect->info->account, "realname" => $collect->info->realname, "idcard_number" => $collect->info->idcard_number]);
                    break;
                case 2:
                    $cash_data = array_merge($data, ["bank_card" => $collect->info->account, "realname" => $collect->info->realname, "idcard_number" => $collect->info->idcard_number]);
                    break;
                case 3:
                    $cash_data = array_merge($data, ["bank_name" => $collect->info->bank_name, "bank_branch" => $collect->info->bank_branch, "bank_card" => $collect->info->bank_card, "realname" => $collect->info->realname, "idcard_number" => $collect->info->idcard_number]);
                    break;
            }
            $this->user->cashs()->save($cash_data);
            $user->save();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error("申请提现失败，原因：" . $e->getMessage());
        }
        $this->success("申请成功");
    }

    /**
     * 获取手动提现手续费
     */
    private function cashFee($money)
    {
        $type = (int) conf('cash_fee_type');
        $fee  = conf('cash_fee');
        switch ($type) {
            case 1: // 固定
                return $fee >= 0 ? round($fee, 2) : 0;
            case 100: // 百分比
                if ($fee < 0 || $fee > 100) {
                    return 0;
                } else {
                    return round($fee / 100 * $money, 2);
                }
            default:
                return 0;
        }
    }


}