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

namespace app\merchantapi\validate\agent;

use app\merchantapi\validate\Base;

class AgentValidate extends Base
{
    protected $rule = [
        'agent_key' => 'min:3|unique:user',
    ];

    protected $message = [
        'agent_key.min'           => '对接码不能少于3位！',
        'agent_key.checkAgentKey' => '您的对接码已存在！',
    ];


    public function sceneAdd()
    {
        return $this->only(['agent_key']);
    }

    public function sceneAgentKey()
    {
        return $this->only(['agent_key']);
    }

}