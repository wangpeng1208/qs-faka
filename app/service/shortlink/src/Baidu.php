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

namespace app\service\shortlink\src;

use app\service\shortlink\interfaces\Link;

/**
 * 百度短网址
 * 在百度短网址服务里提交你的域名 百度过白名单后即可使用。短网址默认设置的永不过期。需要过期请把long-term 修改为 1-year 代表1年
 */
class Baidu implements Link
{
	public function create($url)
	{
		$token = '2c00c57ab0edd4b9cedafc09cacee423'; //修改你的token 
		$head  = array("Content-type: application/json", "Dwz-Token:$token");
		$data  = '[{"LongUrl":"' . $url . '","TermOfValidity":"1-year"}]';
		$a     = $this->post_json('https://dwz.cn/api/v3/short-urls', $data, $head);
		$b     = json_decode($a, true);
		if ($b['Code'] == '0') {
			return $b['ShortUrls']['0']['ShortUrl'];
		}
	}
	public function post_json($uri, $post, $head)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //是否抓取跳转后的页面
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$s = curl_exec($ch);
		curl_close($ch);
		return $s;
	}
}
