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