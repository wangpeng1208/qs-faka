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

use app\common\model\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use think\facade\Db;

class RebuildTableCommand extends Command
{
    protected static $defaultName = 'rebuild:table';
    protected static $defaultDescription = '删库重建';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("========== " . date('Y-m-d H:i:s') . " 删库重建开始执行 ========== ");
        $triggerTime = time();
        // 清空数据库表
        $rebuild_table_name = [ 'auto_unfreeze', 'cash', 'order_complaint', 'order_complaint_message', 'gateway_goods', 'gateway_order', 'goods', 'goods_card', 'goods_category', 'goods_coupon', 'invite_code', 'article_read', 'link',  'merchant_log', 'merchant_message', '`order`', 'order_api', 'order_card', 'order_master', 'shop_list', 'shop_verify',    'user', 'user_analysis', 'user_apply', 'user_channel', 'user_collect', 'user_login_error_log', 'user_login_log', 'user_money_log', 'user_proxy', 'user_rate', 'user_risk',  'shop_iplist',  'user_role_relation', 'admin_log','channel_account','channel_custompay_order','chat_message','wechat_fans','article'];

        // 用户资金 清空用户资金相关
        // $rebuild_table_name = ['`order`', 'user_analysis', 'user_money_log', 'auto_unfreeze', 'order_master', 'admin_log', 'merchant_log', 'user_login_log', 'order_complaint', 'order_complaint_message', 'order_card'];
        foreach ($rebuild_table_name as $table_name) {
            $output->writeln("正在清空表：{$table_name}...");
            Db::query('truncate table ' . $table_name);
        }

        // 用户资金测试
        // User::where(['id' => 1])->update(['money' => 0, 'freeze_money' => 0, 'fee_money' => 200]);
        // User::where(['id' => 2])->update(['money' => 0, 'freeze_money' => 0, 'fee_money' => 200]);

        // $this->execute($input,  $output);
        $timeUsed = time() - $triggerTime;
        $output->writeln("info: 删库重建执行完成，用时：" . $timeUsed . "秒");
        return parent::SUCCESS;
    }
}
