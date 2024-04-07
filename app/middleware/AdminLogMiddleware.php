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

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use support\Log;
use app\service\log\LogService;

class AdminLogMiddleware implements MiddlewareInterface
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
                (new LogService())->sence('admin')->write($user, $params, $request->path(), $content);
            } catch (\Exception $e) {
                Log::channel('admin')->error($e->getMessage());
            }
        }

        return $response;
    }
}
