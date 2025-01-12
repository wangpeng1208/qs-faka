<?php

/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace support;

/**
 * Class Request
 * @package support
 */
class Request extends \Webman\Http\Request
{
  public function isMobile()
  {
    $userAgent = $this->header('user-agent');
    $isMobile = false;
    if (preg_match('/(iPhone|Android|iPad|Mobile|MicroMessenger)/i', $userAgent)) {
      $isMobile = true;
    }
    return $isMobile;
  }

  public function ip()
  {
    return $this->getRealIp(true);
  }

  public function module()
  {
    return $this->app;
  }

  public function controller()
  {
    return $this->controller;
  }

  public function action()
  {
    return $this->action;
  }

  public function time()
  {
    return $this->header('x-request-time');
  }


  /**
   * 获取请求参数
   * @param array $params
   * @param bool $filter
   * @return array
   */
  public function params(array $params, bool $filter = true, bool $hide = true): array
  {
    $input = [];
    foreach ($params as $param) {
      $key = $param[0];
      // 解析name
      if (strpos($key, '/')) {
        [$name, $type] = explode('/', $key);
      } else {
        $name = $key;
      }
      $default = $param[1];
      $item_filter = $param[2] ?? $filter;
      $input[$name] = $this->paramFilter(inputs($key, $default), $item_filter);
      //过滤后产生空字符串，按照默认值
      if ($input[$name] === '') {
        $input[$name] = $default;
      }
    }
    // 过滤空数组中空值 
    $input = array_filter($input, function ($value) {
      return $value !== '';
    });
    // 过滤数组中的空数组
    $input = array_filter($input, function ($value) {
      return !is_array($value) || !empty($value);
    });
    // 取出 $input 的 键
    $keys = array_keys($input);
    return [$keys , $input];
  }

  /**
   * 参数过滤
   * @param $param
   * @param bool $filter
   * @return array|string|string[]|null
   */
  public function paramFilter($param, bool $filter = true)
  {
    if (!$param || !$filter || !is_string($param)) return $param;
    // 把数据过滤
    $filter_rule = [
      "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
      "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
      "/select|join|where|drop|like|modify|rename|insert|update|table|database|alter|truncate|\'|\/\*|\.\.\/|\.\/|union|into|load_file|outfile/is"
    ];
    return preg_replace($filter_rule, '', $param);
  }
}
