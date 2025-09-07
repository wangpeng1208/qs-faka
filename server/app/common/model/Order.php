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

namespace app\common\model;

use app\service\order\OrderService;

class Order extends BaseModel
{
	public function channel()
	{
		return $this->belongsTo("Channel", "channel_id")->withDefault([
			'title' => '',
		]);
	}
	public function channelAccount()
	{
		return $this->belongsTo("ChannelAccount", "channel_account_id");
	}
	public function user()
	{
		return $this->belongsTo("User", "user_id");
	}
	public function shop()
	{
		return $this->belongsTo("ShopList", "user_id", "user_id")->withDefault([
			'shop_name' => '',
		]);
	}
	public function goods()
	{
		return $this->belongsTo("Goods", "goods_id");
	}
	public function cards()
	{
		return $this->hasMany("OrderCard", "order_id");
	}
	public function autoUnfreeze()
	{
		return $this->hasOne("AutoUnfreeze", "trade_no", "trade_no");
	}

	// 搜索器
	public function searchUserIdAttr($query, $value, $data)
	{
		$query->where("user_id", $value);
	}
	public function searchUsernameAttr($query, $value, $data)
	{
		$query->hasWhere('user', function ($query) use ($value) {
			$query->where('username', 'like', '%' . $value . '%');
		});
	}
	public function searchPaytypeAttr($query, $value, $data)
	{
		$query->whereIn("paytype", $value);
	}
	public function searchStatusAttr($query, $value, $data)
	{
		$query->where("status", $value);
	}
	public function searchTradeNoAttr($query, $value, $data)
	{
		$query->where("trade_no", $value);
	}

	public function searchTransactionIdAttr($query, $value, $data)
	{
		$query->where("transaction_id", $value);
	}

	public function searchChannelIdAttr($query, $value, $data)
	{
		$query->where("channel_id", $value);
	}

	public function searchIsFreezeAttr($query, $value, $data)
	{
		$query->where("is_freeze", $value);
	}

	public function searchCardAttr($query, $value, $data)
	{
		$query->hasWhere('OrderCard', function ($query) use ($value) {
			$query->where('number|secret', 'like', '%' . $value . '%');
		});
	}

	
	public function searchContactAttr($query, $value, $data)
	{
		$query->where("contact", "like", "%{$value}%");
	}

	public function searchDateTypeAttr($query, $value, $data)
	{
		match ($value) {
			"1" => $query->whereTime("create_at", "today"),
			"2" => $query->whereTime("create_at", "yesterday"),
			"3" => $query->whereTime("create_at", "week"),
			"4" => $query->whereTime("create_at", "month"),
			"5" => $query->whereTime("create_at", "year"),
		};
	}

	public function searchDateRangeAttr($query, $value, $data)
	{
		if (empty($value) || empty(trim($value[0])) || empty(trim($value[1]))) {
			return;
		} else {
			$query->whereBetweenTime('create_at', $value[0], $value[1]);
		}
	}

	// 商户搜索
	public function searchTypeAttr($query, $value, $data)
	{
		if (empty($data['keywords'])) {
			return;
		}
		if ($value == 'trade_no') {
			$query->where("trade_no", $data['keywords']);
		} elseif ($value == 'goods_name') {
			$query->where("goods_name", "like", "%{$data['keywords']}%");
		} elseif ($value == 'contact') {
			$query->where("contact", "like", "%{$data['keywords']}%");
		}
	}
	public function searchKeywordsAttr($query, $value, $data)
	{
	}

	public function searchCidAttr($query, $value, $data)
	{
		$query->hasWhere('goods', function ($query) use ($value) {
			$query->where('cate_id', $value);
		});
	}

	public function searchDateAttr($query, $value, $data)
	{
		$query->whereTime("create_at", "between", [$value . " 00:00:00", $value . " 23:59:59"]);
	}


	public function getStatusTextAttr($value, $data)
	{
		$arr = ["0" => "未支付", "1" => "已支付", "2" => "已关闭", "3" => "已退款"];
		return $arr[$data["status"]];
	}

	public function getCardsCountAttr($value, $data)
	{
		return $this->cards()->count();
	}

	// 生成订单同步回调地址
	public function callbackUrl()
	{
		return 'order';
	}

	// 完成订单
	public function completeOrder($order)
	{
		(new OrderService())->complete($order);
	}
}
