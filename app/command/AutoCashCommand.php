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

namespace app\command;

use think\facade\Db;
use app\common\model\Cash;
use app\common\model\User as UserModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AutoCashCommand extends Command
{
    protected static $defaultName = 'auto:cash';
    protected static $defaultDescription = '创建自动提现';
    private $lockFileName;

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->lockFileName = runtime_path() . '/logs/' . 'auto_cash.lock';
        $lockFileHandler    = fopen($this->lockFileName, "a+");

        if (!$this->acquireLock($lockFileHandler)) {
            $output->writeln("info: 自动提现任务，获取锁失败，自动退出");
            return parent::FAILURE;
        }

        $lastTriggerTime = fgets($lockFileHandler);
        $todayTime       = strtotime(date('Y-m-d'));
        $autoCashTime    = $this->getAutoCashTime();

        if ($this->isTaskAlreadyExecutedToday($lastTriggerTime, $todayTime)) {
            $output->writeln('info: 今日已执行过此任务，如果强制执行请先删除锁文件/runtime/logs/auto_cash.lock后执行');
            return parent::FAILURE;
        }

        $triggerTime = time();
        $output->writeln("========== " . date('Y-m-d H:i:s') . " 自动提现任务开始执行 ==========");


        //已开启提现和自动提现，今天未提现，同时到达设定的自动提现时间
        if ($this->shouldExecuteAutoCashTask($lastTriggerTime, $todayTime, $autoCashTime)) {
            // 最低自动提现金额
            $leastCashMoney = (int) conf('auto_cash_money');

            // 有收款信息的用户且余额大于最低提现金额且付款类型为自动提现的 未冻结 用户
            $users = UserModel::hasWhere('collect', function ($query) {
                $query->whereIn('type', [1, 2, 3])->where('status', 1)->whereColumn('user_id', 'User.id');
            })->where('cash_type', 1)
                ->where('is_freeze', 0)
                ->where('money', '>=', $leastCashMoney)
                ->select();
            if (empty($users)) {
                $output->writeln("info: 无符合要求的自动提现");
                return parent::FAILURE;
            }

            foreach (collect($users) as $user) {
                // 申请提现
                try {
                    Db::startTrans();

                    $collect = $user->collect;
                    // 今日可提现次数
                    $todayCount      = $user->cashs()->where(['create_at' => ['>=', $todayTime]])->count();
                    $limitNum        = (int) conf('cash_limit_num');
                    $todayCanCashNum = max(0, $limitNum - $todayCount);

                    // 检测今日提现次数
                    if ($todayCanCashNum > 0) {
                        $money        = $user->money;
                        $collect_info = '';
                        switch ($collect->type) {
                            case 1: //支付宝
                                $collect_info .= "支付宝账号：{$collect->info->account}<br>";
                                $collect_info .= "真实姓名：{$collect->info->realname}<br>";
                                $collect_info .= "身份证号：{$collect->info->idcard_number}";
                                break;
                            case 2: //微信
                                $collect_info .= "微信账号：{$collect->info->account}<br>";
                                $collect_info .= "真实姓名：{$collect->info->realname}<br>";
                                $collect_info .= "身份证号：{$collect->info->idcard_number}";
                                break;
                            case 3: //银行
                                $collect_info .= "开户银行：{$collect->info->bank_name}<br>";
                                $collect_info .= "开户地址：{$collect->info->bank_branch}<br>";
                                $collect_info .= "收款账号：{$collect->info->account}<br>";
                                $collect_info .= "真实姓名：{$collect->info->realname}<br>";
                                $collect_info .= "身份证号：{$collect->info->idcard_number}";
                                break;
                        }

                        //如果减后金额小于0，会抛异常
                        $user->money -= $money;
                        if ($user->money < 0) {
                            // 余额不能为负数
                            throw new \Exception("余额不能为负数", 10001);
                        }
                        $user->save();

                        // 记录用户金额变动日志
                        $reason = "申请提现金额{$money}元";
                        record_user_money_log('apply_cash', $user->id, -$money, $user->money, $reason);
                        // 获取提现手续费
                        $fee = $this->autoCashFee($money);
                        // 创建提现记录 记录提现日志
                        $cashData = [
                            'user_id'      => $user->id,
                            'type'         => $collect->type,
                            'collect_info' => $collect_info,
                            'collect_img'  => $collect->collect_img,
                            'auto_cash'    => 1,
                            'money'        => $money,
                            'fee'          => $fee,
                            'actual_money' => round($money - $fee, 2),
                            'status'       => 0,
                            'create_at'    => time(),
                        ];

                        switch (intval($collect->type)) {
                            case 2:
                            case 1:
                                $cashData = array_merge($cashData, [
                                    'bank_card'     => $collect->info->account,
                                    'realname'      => $collect->info->realname,
                                    'idcard_number' => $collect->info->idcard_number,
                                ]);
                                break;
                            case 3:
                                $cashData = array_merge($cashData, [
                                    'bank_name'     => $collect->info->bank_name,
                                    'bank_branch'   => $collect->info->bank_branch,
                                    'bank_card'     => $collect->info->bank_card,
                                    'realname'      => $collect->info->realname,
                                    'idcard_number' => $collect->info->idcard_number,
                                ]);
                                break;
                        }
                        Cash::create($cashData);
                        $output->writeln("info: 自动提现成功：user:" . $user->id . ', money:' . $money);
                    }

                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                    $money = $money ?? 0;
                    $output->writeln("info: 自动提现失败，user: {$user->id}, money: {$money}, 原因：" . $e->getMessage());
                }
                ;
            }

            ftruncate($lockFileHandler, 0);
            fwrite($lockFileHandler, $triggerTime);
            fflush($lockFileHandler); // flush output before releasing the lock
            flock($lockFileHandler, LOCK_UN); // release the lock
        }
        $timeUsed = time() - $triggerTime;
        $output->writeln("info: 自动提现任务执行完成，用时：" . $timeUsed);
        return parent::SUCCESS;
    }

    // 获取锁
    private function acquireLock($lockFileHandler)
    {
        return flock($lockFileHandler, LOCK_EX | LOCK_NB);
    }

    // 自动任务重新可执行时间
    private function getAutoCashTime()
    {
        $autoCashHour = intval(conf('auto_cash_time'));
        return strtotime(date('Y-m-d') . ' ' . $autoCashHour . ':0');
    }

    // 今日任务是否已执行
    private function isTaskAlreadyExecutedToday($lastTriggerTime, $todayTime)
    {
        return !empty ($lastTriggerTime) && $lastTriggerTime > $todayTime;
    }

    private function shouldExecuteAutoCashTask($lastTriggerTime, $todayTime, $autoCashTime)
    {
        return (empty ($lastTriggerTime) || $lastTriggerTime < $todayTime) && conf('auto_cash') && time() > $autoCashTime;
    }

    // 获取自动提现手续费
    private function autoCashFee($money)
    {
        $type = (int) conf('auto_cash_fee_type');
        $fee  = conf('auto_cash_fee');

        if ($type === 1) { // 固定
            return $fee >= 0 ? round($fee, 2) : 0;
        }

        if ($type === 100) { // 百分比
            return  ($fee < 0 || $fee > 100) ? 0 : round($fee / 100 * $money, 2);
        }

        return 0;
    }
}
