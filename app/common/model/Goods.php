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

namespace app\common\model;

use think\model\concern\SoftDelete;
use app\service\shortlink\ShortLinkService;

class Goods extends BaseModel
{
	use SoftDelete;
	protected $autoWriteTimestamp = true;
	protected $createTime = 'create_at';
	protected $deleteTime = "delete_at";
	// update_time 不需要
	protected $updateTime = false;

	// 设置json类型字段
	protected $json = ['wholesale_discount_list', 'event_give', 'addtion_give'];

	// 设置JSON数据返回数组
	protected $jsonAssoc = true;

	public function user()
	{
		return $this->belongsTo("User", "user_id");
	}
	
	public function shop()
	{
		return $this->belongsTo("ShopList", "user_id", "user_id");
	}

	public function category()
	{
		return $this->belongsTo("GoodsCategory", "cate_id")->bind([
			"cate_name" => "name",
		]);
	}

	public function cards($pk = "goods_id")
	{
		return $this->hasMany("GoodsCard", 'goods_id', $pk);
	}

	public function orders()
	{
		return $this->hasMany("Order", "goods_id");
	}

	public function pgoods()
	{
		return $this->belongsTo("Goods",  "proxy_id");
	}

	public function cross()
	{
		return $this->belongsTo("PluginCross", "cross_id");
	}

	public function link()
	{
		return $this->morphOne("Link", "relation", "goods")->order("id desc");
	}

	public function searchIdAttr($query, $value, $data)
	{
		$query->where('id', '=', $value);
	}

	public function searchUserIdAttr($query, $value, $data)
	{
		$query->where('user_id', '=', $value);
	}

	public function searchUsernameAttr($query, $value, $data)
	{
		$query->hasWhere('user', function ($query) use ($value) {
			$query->where('username', 'like', '%' . $value . '%');
		});
	}

	public function searchNameAttr($query, $value, $data)
	{
		$query->where('name', 'like', '%' . $value . '%');
	}
	
	public function searchIsFreezeAttr($query, $value, $data)
	{
		if ($value !== "") {
			$query->where('is_freeze', '=', $value);
		}
	}

	public function searchCateIdAttr($query, $value, $data)
	{
		$query->where('cate_id', '=', $value);
	}

	public function searchDateRangeAttr($query, $value, $data)
	{
		if (empty(trim($value[0])) || empty(trim($value[1]))) {
			return;
		} else {
			$query->whereBetweenTime('create_time', $value[0], $value[1]);
		}
	}

	public function getCardsStockCountAttr($value, $data)
	{
		$pk = !empty($data['proxy_id']) ? "proxy_id" : "id";
		// ->where("unfreeze_at", "<", time()) 锁卡机制停用
		// todo 可以考虑 总数量小于某个值的时候使用锁卡机制
		return $this->cards($pk)->where("status", 1)->count();
	}

	protected function getCardsSoldCountAttr($value, $data)
	{
		$pk = !empty($data['proxy_id']) ? "proxy_id" : "id";
		return $this->cards($pk)->where("status", 2)->count();
	}

	public function getLinksAttr($value, $data)
	{
		return conf("site_shop_domain") . "/links/" . $this->link()->value('token');
	}

	public function getResetShortLinkAttr($value, $data)
	{
		return (new ShortLinkService())->resetShortLink($data["user_id"], $data["id"], "goods");
	}
	public function getShortLinkAttr($value, $data)
	{
		return (new ShortLinkService())->getShortLink($data["user_id"], $data["id"], "goods");
	}

	public function getLinkStatusAttr($value, $data)
	{
		return $this->link()->value("status");
	}

}
