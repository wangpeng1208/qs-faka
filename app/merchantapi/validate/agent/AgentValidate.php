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