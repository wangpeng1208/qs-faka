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
	// protected $autoWriteTimestamp = true;
	// protected $createTime         = 'create_at';
	public function channel()
	{
		return $this->belongsTo("Channel", "channel_id");
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
		return $this->belongsTo("ShopList", "user_id", "user_id");
	}

	// 通过中间表获取用户信息
	// order表中 proxy_id 是Goods表中的id；Goods表中的user_id是User表中的id
	public function proxyUser()
	{
		return $this->hasOneThrough("User", "Goods", "id", "id", "proxy_id", "user_id");
	}
	public function goods()
	{
		return $this->belongsTo("Goods", "goods_id");
	}
	// 代理商品
	public function pgoods()
	{
		return $this->belongsTo("Goods", "proxy_id");
	}
	public function proxy()
	{
		return $this->belongsTo("Goods", "proxy_id");
	}
	public function cross()
	{
		return $this->belongsTo("PluginCross", "cross_id");
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
	// transaction_id
	public function searchTransactionIdAttr($query, $value, $data)
	{
		$query->where("transaction_id", $value);
	}
	// channel_id
	public function searchChannelIdAttr($query, $value, $data)
	{
		$query->where("channel_id", $value);
	}
	// is_freeze
	public function searchIsFreezeAttr($query, $value, $data)
	{
		$query->where("is_freeze", $value);
	}
	// card
	public function searchCardAttr($query, $value, $data)
	{
		$query->hasWhere('OrderCard', function ($query) use ($value) {
			$query->where('number|secret', 'like', '%' . $value . '%');
		});
	}
	// contact
	public function searchContactAttr($query, $value, $data)
	{
		$query->where("contact", "like", "%" . $value . "%");
	}
	// date_type
	public function searchDateTypeAttr($query, $value, $data)
	{
		if ($value == 1) {
			$query->whereTime("create_at", "today");
		} elseif ($value == 2) {
			$query->whereTime("create_at", "yesterday");
		} elseif ($value == 3) {
			$query->whereTime("create_at", "week");
		} elseif ($value == 4) {
			$query->whereTime("create_at", "month");
		} elseif ($value == 5) {
			$query->whereTime("create_at", "year");
		}
	}
	public function searchDateRangeAttr($query, $value, $data)
	{
		if (empty($value) || empty(trim($value[0])) || empty(trim($value[1]))) {
			return;
		} else {
			$query->whereBetweenTime('create_at', $value[0], $value[1]);
		}
	}

	public function searchOrderTypeAttr($query, $value, $data)
	{
		if ($value != "" && $value == 0) {
			$query->where("is_proxy", 0);
		} elseif ($value != "" && $value == 1) {
			$query->where("is_proxy", 1);
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
			$query->where("goods_name", "like", "%" . $data['keywords'] . "%");
		} elseif ($value == 'contact') {
			$query->where("contact", "like", "%" . $data['keywords'] . "%");
		}
	}
	public function searchKeywordsAttr($query, $value, $data)
	{
	}
	// cid
	public function searchCidAttr($query, $value, $data)
	{
		$query->hasWhere('goods', function ($query) use ($value) {
			$query->where('cate_id', $value);
		});
	}

	// date
	public function searchDateAttr($query, $value, $data)
	{
		// create_at 等于 $value当天时间段
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
