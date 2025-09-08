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

class RebuildTableCommand extends Command
{
    protected static $defaultName = 'rebuild:table';
    protected static $defaultDescription = '删库重建';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("========== " . date('Y-m-d H:i:s') . " 删库重建开始执行 ========== ");
        $triggerTime = time();
        // 清空数据库表

        $rebuild_table_name = ['pay_auto_unfreeze', 'user_cash', 'order_complaint', 'order_complaint_message', 'goods', 'goods_card', 'goods_category', 'goods_coupon', 'article_read', 'shop_link', 'user_log', 'user_message', '`order`', 'order_card', 'order_master', 'shop_list', 'user', 'user_analysis', 'user_collect', 'user_login_error_log', 'user_login_log', 'user_money_log', 'user_rate', 'user_role_relation', 'admin_log', 'pay_channel_account',  'article', 'article_category'];


        foreach ($rebuild_table_name as $table_name) {
            $output->writeln("正在清空表：{$table_name}...");
            Db::query('truncate table ' . $table_name);
        }

        // $this->execute($input,  $output);
        $timeUsed = time() - $triggerTime;
        $output->writeln("info: 删库重建执行完成，用时：" . $timeUsed . "秒");
        return parent::SUCCESS;
    }
}
