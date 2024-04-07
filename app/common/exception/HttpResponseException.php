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

namespace app\common\exception;

use Exception;

class HttpResponseException extends Exception
{
    public $respone = [];
    public $statusCode = 200;

    public function __construct($statusCode = 200, $respone = [])
    {
        parent::__construct();
        $this->statusCode = $statusCode;
        $this->respone    = $respone;
    }


}
