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