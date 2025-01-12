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

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use support\Log;
use app\service\common\LogService;

class MerchantLogMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $response = $handler($request);
        $user = $request->user;
        $action = $request->action;
        $controller = $request->controller;
        $reflection = new \ReflectionMethod($controller, $action);
        $docComment = $reflection->getDocComment();
        $content = '';
        
        // 获取注释里的 @notes后的内容
        if (preg_match('/@notes(.*?)\n/', $docComment, $matches)) {
            $content .= $matches[1];
            
            // 获取响应结果msg
            $exception = $response->exception();
            if ($exception && isset($exception->respone)) {
                $result = $exception->respone;
                $content .= ', 结果：' . $result['msg'];
            }
            
            // 请求信息
            $params = $request->all();
            $params = array_filter($params, function ($value) {
                if (is_array($value)) {
                    return !empty($value);
                } else {
                    return !is_null($value);
                }
            });
            $params = empty($params) ? null : json_encode($params, JSON_UNESCAPED_UNICODE);
            
            try {
                (new LogService())->sence('merchant')->write($user, $params, $request->path(), $content);
            } catch (\Exception $e) {
                Log::channel('merchant')->error($e->getMessage());
            }
        }

        return $response;
    }
}
