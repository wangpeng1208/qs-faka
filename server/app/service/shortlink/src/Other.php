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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

// 第三方短网址生成
class Other implements Link
{
  public function create($url)
  {
    $options = conf('site_shortlink_other_option');

    // 允许 $options 是 JSON 字符串或数组
    if (is_string($options)) {
      $decoded = json_decode($options, true);
      if (json_last_error() === JSON_ERROR_NONE) {
        $options = $decoded;
      }
    }

    if (!is_array($options)) {
      throw new \Exception('第三方短网址配置异常');
    }

    // 基础拉平与清理空格
    $api    = isset($options['api']) ? trim((string) $options['api']) : '';
    $method = isset($options['method']) ? strtolower(trim((string) $options['method'])) : 'post';
    $from   = isset($options['from']) ? trim((string) $options['from']) : 'url';
    $params = $options['params'] ?? [];

    // 验证必要项
    if ($api === '') {
      throw new \Exception('第三方短网址配置缺少 api');
    }
    if (!filter_var($api, FILTER_VALIDATE_URL)) {
      throw new \Exception('第三方短网址配置 api 非法');
    }
    if ($from === '') {
      throw new \Exception('第三方短网址配置缺少 from');
    }
    if (!in_array($method, ['get', 'post'], true)) {
      throw new \Exception('第三方短网址配置 method 仅支持 get/post');
    }
    if (!is_array($params)) {
      throw new \Exception('第三方短网址配置 params 必须为数组');
    }

    // 将动态链接写入到指定字段名（默认 url）
    $params[$from] = $url;

    $client = new Client([
      'timeout' => 10,
      'verify'  => false,
    ]);

    try {
      if ($method === 'get') {
        $response = $client->request('GET', $api, [
          'query' => $params,
        ]);
      } else {
        $response = $client->request('POST', $api, [
          'form_params' => $params,
        ]);
      }
    } catch (GuzzleException $e) {
      throw new \Exception('请求失败：' . $e->getMessage());
    }

    $body = (string) $response->getBody();

    // 匹配 http(s):// 开头，后接域名与可选路径，尽量排除空白与引号
    if (preg_match('#https?://[^\s"\'"\)\>]+#i', $body, $m)) {
      return $m[0];
    }

    throw new \Exception('未能解析短网址');
  }

}
