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

namespace app\service\common;

use app\common\exception\HttpResponseException;

abstract class Api
{

    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    protected function response($code, $msg = '', $data = '')
    {
        $result = [
            'code' => $code,
            'msg'  => $msg ? $msg : ($code ? '操作成功' : '操作失败'),
            'data' => $data,
            'time' => time(),
        ];
        throw new HttpResponseException(200, $result);
    }

    protected function success($msg = '', $data = '')
    {
        $this->response(1, $msg, $data);
    }

    protected function error($msg = '', $data = '')
    {
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg  = $msg['msg'];
        } else {
            $code = 0;
        }
        $this->response($code, $msg, $data);
    }

}
