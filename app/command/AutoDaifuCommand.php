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
use Symfony\Component\Console\Input\ArrayInput;
use app\common\model\Cash as CashModel;
use app\common\model\Channel;
use app\service\message\MessageService;
use support\Container;

class AutoDaifuCommand extends Command
{
    protected static $defaultName = 'auto:daifu';
    protected static $defaultDescription = '自动代付任务';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $channels    = Channel::where('type', 2)->where('is_custom', 0)->where('status', 1)->select();
        $allAccounts = collect([]);
        foreach ($channels as $item) {
            $accounts = $item->accounts()->where('status', 1)->select();
            if ($accounts->isEmpty()) {
                continue;
            } else {
                foreach ($accounts as $account) {
                    $allAccounts->push($account);
                }
            }
        }
        // 随机一个打款账号
        if ($allAccounts->isEmpty()) {
            $output->writeln("没有可用的代付账号");
            return parent::SUCCESS;
        }
        $account = $allAccounts[array_rand($allAccounts->toArray())];
        $channel = $account->channel;
        // 支付宝类型，待打款列表数据
        $cashs = collect(CashModel::where(['status' => 0, 'type' => 1])->limit(1)->order('id desc')->select());
        if (!$cashs->isEmpty()) {
            foreach ($cashs as $cash) {
                $user = $cash->user;
                //更新代付账号到提现记录中
                $cash->channel_id         = $channel->id;
                $cash->channel_account_id = $account->id;
                $cash->trade_no           = generate_trade_no('TX'); // TX2208080046041000015
                $cash->save();
                // 记录订单
                $orderMaster           = new \app\common\model\OrderMaster();
                $orderMaster->trade_no = $cash->trade_no;
                $orderMaster->model    = 'Cash';
                $orderMaster->save();
                //尝试代付
                $class = Container::get("\\app\\home\\settlement\\" . $channel->code);
                $res   = $class->pay($cash, $user);
                // 打款失败时候的记录
                if (strstr($res['msg'], 'Failed') || $res['code'] === 0) {
                    // 输出报错信息
                    $output->writeln($res['msg']);
                    // 记录cash状态2 ，状态为驳回
                    $cash->status = 2;
                    $cash->save();
                    // 解冻金额
                    $user->money += $cash->money;
                    $user->save();
                    // 记录用户金额变动日志
                    $reason = "结算失败，返还金额{$cash->money}元，原因：" . $res['msg'];
                    record_user_money_log('cash_notpass', $cash->user_id, $cash->money, $cash->user->money, $reason);
                    $output->writeln("info: 用户ID:" . $user->id . ', 金额:' . $cash->money);
                    MessageService::send(0, $cash->user_id, "结算失败", $reason);
                } else {
                    // 记录用户金额变动日志
                    $reason = "结算成功，提现金额{$cash->money}元，手续费{$cash->fee}元，实际到账{$cash->actual_money}元";
                    record_user_money_log('cash_success', $cash->user_id, 0, $cash->user->money, $reason);
                    $output->writeln("用户id" . $cash->user_id . ':' . $reason);
                    $notify = new \app\service\notify\CashService();
                    $notify->notify($user, $cash->money, $cash->fee, $cash->actual_money);
                    $output->writeln("info: 自动代付成功：user:" . $user->id . ', money:' . $cash->money, '实际到账:' . $cash->actual_money);
                    MessageService::send(0, $cash->user_id, "结算成功", $reason);
                }
            }

            $command   = $this->getApplication()->find(self::$defaultName);
            $arguments = ['command' => self::$defaultName];
            $input     = new ArrayInput($arguments);
            $command->run($input, $output);
        } else {
            $output->writeln("运行结束，全部完成");
            return parent::SUCCESS;
        }
    }
}
