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
use Symfony\Component\Console\Style\SymfonyStyle;
use Illuminate\Support\Str;

class AutoInstallCommand extends Command
{
    protected static $defaultName = 'auto:install';
    protected static $defaultDescription = '安装辅助工具';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("安装辅助工具");
        $output->writeln("");
        // 如果存在 .env 文件 则退出
        if (file_exists(base_path(false) . DIRECTORY_SEPARATOR . '.env')) {
            $output->writeln("<error>系统已经安装，请重新安装，请先删除 .env 文件！</error>");
            return parent::FAILURE;
        }

        $output->writeln([
            "📌 \033[1;36m宝塔面板配置指南\033[0m",
            "",
            "🔷 第一步：登录宝塔面板",
            "",
            "🔷 第二步：创建站点",
            "  ├─ 点击【网站】",
            "  └─ 点击【添加站点】",
            "",
            "🔷 第三步：填写配置",
            "  ├─ 域名：您的域名",
            "  ├─ 根目录：" . base_path(false),
            "  ├─ PHP版本：8.1 或 8.2",
            "  └─ 数据库：MySQL",
            "",
            "✨ 完成以上步骤后继续安装"
        ]);

        // 确认是否继续安装
        $io      = new SymfonyStyle($input, $output);
        $confirm = $io->confirm("是否继续安装？回车继续", true);
        if (!$confirm) {
            $output->writeln("<error>安装已取消</error>");
            return parent::FAILURE;
        }
        // 重命名根目录env文件
        $envFile = base_path(false) . DIRECTORY_SEPARATOR . '.env.example';
        if (file_exists($envFile)) {
            // 复制一份并命名为 .env
            copy($envFile, base_path(false) . DIRECTORY_SEPARATOR . '.env');
        } else {
            $output->writeln('.env.example 文件不存在');
            return parent::FAILURE;
        }

        // 交互配置数据库
        $output->writeln("==开始配置数据库==");

        $io     = new SymfonyStyle($input, $output);
        $dbName = $io->ask('请输入/粘贴 数据库名称');
        $dbUser = $io->ask('请输入/粘贴 数据库用户名');
        $dbPwd  = $io->ask('请输入/粘贴 数据库密码');

        // 写入env文件
        $env = file_get_contents(base_path(false) . DIRECTORY_SEPARATOR . '.env');
        $env = preg_replace('/^DB_USERNAME\s*=.*$/m', 'DB_USERNAME = ' . $dbUser, $env);
        $env = preg_replace('/^DB_DATABASE\s*=.*$/m', 'DB_DATABASE = ' . $dbName, $env);
        $env = preg_replace('/^DB_PASSWORD\s*=.*$/m', 'DB_PASSWORD = ' . $dbPwd, $env);

        // 生成一个随机的密钥
        $key = Str::random(32);
        $env = preg_replace('/^JWT_SECRET_KEY\s*=.*$/m', 'JWT_SECRET_KEY = ' . $key, $env);

        file_put_contents(base_path(false) . DIRECTORY_SEPARATOR . '.env', $env);


        // 自动导入数据库
        $sql_file = base_path(false) . DIRECTORY_SEPARATOR . 'mysql.sql';
        // 数据库文件是否存在
        if (!file_exists($sql_file)) {
            $output->writeln("<error>数据库文件不存在！</error>");
            return parent::FAILURE;
        }
        // 执行还原数据库命令
        $command = "mysql -u" . $dbUser . " -p" . $dbPwd . " " . $dbName . " < " . $sql_file;
        $output->writeln("正在还原数据库...");
        $output->writeln($command);

        // 执行命令 并打印输出
        exec($command, $output_lines, $return_var);

        if ($return_var !== 0) {
            $output->writeln("<error>数据库还原失败！错误信息:</error>");
            foreach ($output_lines as $line) {
                $output->writeln($line);
            }
            return parent::FAILURE;
        }

        $output->writeln("数据库还原成功！");

        // 启动项目
        $output->writeln("正在启动项目...");
        // 在根目录启动
        $command = "php " . base_path(false) . DIRECTORY_SEPARATOR . "start.php start -d";
        // 执行命令 并打印输出
        $output->writeln(shell_exec($command));
        $output->writeln("项目启动成功");

        $output->writeln([
            "",
            "\033[1;36m┌──────────────────────────────────────┐\033[0m",
            "\033[1;36m│        反向代理配置指南              │\033[0m",
            "\033[1;36m└──────────────────────────────────────┘\033[0m",
            "",
            "🔸 第1步：打开宝塔面板",
            "  ├─ 点击【网站】",
            "  ├─ 选择【您的站点】",
            "  ├─ 点击【设置】",
            "  └─ 找到【反向代理】",
            "",
            "🔸 第2步：添加反向代理",
            "  ├─ 点击【添加反向代理】",
            "  │",
            "  ├─ \033[1;33m代理名称：\033[0m随意填写",
            "  ├─ \033[1;33m目标URL：\033[0m\033[1;32mhttp://127.0.0.1:8786\033[0m",
            "  └─ \033[1;33m发送域名：\033[0m\033[1;32m\$host\033[0m",
            "",
            "🔸 第3步：保存配置",
            "  └─ 点击【提交】保存设置",
            "",
            "\033[1;42m ✓ 恭喜！反向代理配置完成 \033[0m",
            ""
        ]);

        $output->writeln("全部安装完成！");

        return parent::SUCCESS;
    }
}
