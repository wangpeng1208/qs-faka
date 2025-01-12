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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use think\facade\Db;

class UnfreezeMoneyCommand extends Command
{
    protected static $defaultName = 'unfreeze:money';
    protected static $defaultDescription = '自动解冻订单金额';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("========== " . date('Y-m-d H:i:s') . " 自动解冻任务开始 ========== ");
        $time = time();
        $sql  = sprintf("select user_id, sum(money) money from auto_unfreeze where unfreeze_time<'%s' AND status = 1 group by user_id", $time);
        $rows = Db::query($sql);
        $output->writeln("info: 找到" . count($rows) . "个需要解冻的账户");
        foreach ($rows as $row) {
            $this->unfreeze($row['user_id'], $row['money'], $time, $output);
        }
        $output->writeln("========== " . date('Y-m-d H:i:s') . " 自动解冻任务结束 ==========");
        return parent::SUCCESS;
    }

    private function unfreeze($user_id, $money, $time, $output)
    {
        try {
            // 解冻
            Db::startTrans();
            $user = Db::table('user')->where('id', $user_id)->lock(true)->find();
            if (!$user) {
                throw new \Exception("找不到用户 user_id: " . $user_id);
            }
            // 用户冻结资金 小于 要解冻资金| 是否会出现此问题 有待商榷
            if ($user['freeze_money'] < $money) {
                $output->writeln('warning: 用户冻结余额不足！user_id: ' . $user_id . '，用户冻结余额' . $user['freeze_money'] . '，欲解冻金额: ' . $money . "，已自动调整解冻金额");
                //当前不可解冻队列总额
                $no_freeze_money_sum = Db::table('auto_unfreeze')->where(['user_id' => $user_id, 'unfreeze_time' => ['egt', $time]])->sum('money');
                if ($no_freeze_money_sum > 0) {
                    $money = $user['freeze_money'] - $no_freeze_money_sum;
                } else {
                    $money = $user['freeze_money'];
                }
            }
            
            // 解冻资金大于0
            if ($money > 0) {
                // 更新用户资金
                Db::table('user')->where('id', $user_id)->dec('freeze_money', $money)->inc('money', $money)->update();

                // 记录用户金额变动日志
                record_user_money_log('unfreeze', $user['id'], $money, $user['money'] + $money, "订单金额T+1日自动解冻，解冻金额：{$money}元");

                // 删除自动解冻表数据
                Db::table('auto_unfreeze')->where("user_id={$user_id} and unfreeze_time<'{$time}' AND status = 1")->delete();
                
                Db::commit();
                $output->writeln("info: 成功解冻 user_id:{$user_id} money:{$money}");
            } else {
                Db::rollback();
            }
        } catch (\Exception $e) {
            Db::rollback();

            $output->writeln("error: T+1自动解冻失败：{$e->getMessage()} user_id:{$user_id}");
        }
    }
}
