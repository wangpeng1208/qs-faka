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

namespace app\adminapi\validate\article;

use taoser\Validate;

class ArticleValidate extends Validate
{
	protected $rule = [
		'id'      => 'require',
		'title'   => 'require',
		'cate_id' => 'require',
	];

	protected $message = [
		'id.require'      => 'ID不能为空',
		'title.require'   => '文章名不能为空',
		'cate_id.require' => '请选择分类',
	];

	public function sceneAdd()
	{
		return $this->only(['title', 'cate_id']);
	}

	public function sceneEdit()
	{
		return $this->only(['id', 'title', 'cate_id']);
	}

}