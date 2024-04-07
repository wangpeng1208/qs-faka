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

namespace app\service\message;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailMessageService
{
    /**
     * 邮件发送
     * @param  string $to 收件方
     * @param  string $title 标题
     * @param  string $content 内容
     * @return bool 返回结果
     */
    public static function send($to, $title, $content)
    {
        $from      = conf('email_user');
        $smtp      = sprintf('smtp://%s:%s@%s:%s', $from, conf('email_pass'), conf('email_smtp'), conf('email_port'));
        $transport = Transport::fromDsn($smtp);
        $mailer    = new Mailer($transport);
        $email     = (new Email())->from($from)->to($to)->subject($title)->text($content)->html($content);
        try {
            $mailer->send($email);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return true;
    }

}