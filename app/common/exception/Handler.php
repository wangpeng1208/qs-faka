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

namespace app\common\exception;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\Exception\ExceptionHandler;
use app\common\exception\HttpResponseException;
use taoser\exception\ValidateException;
use think\db\exception\ModelNotFoundException;
use \Exception;

class Handler extends ExceptionHandler
{
    // 不需要记录错误日志
    public $dontReport = [];
    public $responseData = [];
    public $statusCode = 200;
    public $header = [];
    public $errorMessage = '';

    /**
     * @param Throwable $exception
     */
    public function report(Throwable $exception)
    {
        $this->dontReport = [
            HttpResponseException::class,
            ValidateException::class,
            Exception::class,
        ];
        parent::report($exception);
    }

    public function render(Request $request, Throwable $exception): Response
    {
        // 异常处理
        $this->solveAllException($exception);
        // 异常调试
        $this->addDebugInfoToResponse($exception);
        // 返回 Response
        return $this->buildResponse();
    }

    /**
     * 处理异常数据.
     * @param Throwable $e
     */
    protected function solveAllException(Throwable $e)
    {
        // echo 'Class of $e: ' . get_class($e) . PHP_EOL;
        $errorMessage = $e->getMessage();
        if ($e instanceof HttpResponseException) {
            $this->statusCode = $e->statusCode;
            if (property_exists($e, 'respone')) {
                $this->responseData = $e->respone;
            }
        } elseif ($e instanceof ValidateException) {
            $errorMessage = $e->getError();
        } elseif ($e instanceof ModelNotFoundException) {
            $this->statusCode = 404;
            $errorMessage = '数据不存在！';
        } elseif ($e instanceof Exception) {
            $this->statusCode = 200;
        } else {
            $this->statusCode = 500;
        }
        $this->errorMessage = $errorMessage;
    }

    /**
     * 调试模式：错误处理器会显示异常以及详细的函数调用栈和源代码行数来帮助调试，将返回详细的异常信息。
     * @param Throwable $e
     * @return void
     */
    protected function addDebugInfoToResponse(Throwable $e): void
    {
        if (config('app.debug', true)) {
            $this->responseData['error_message'] = $this->errorMessage;
            $this->responseData['error_trace']   = explode("\n", $e->getTraceAsString());
            $this->responseData['file']          = $e->getFile();
            $this->responseData['line']          = $e->getLine();
        }
    }

    /**
     * 构造 Response.
     * @return Response
     */
    protected function buildResponse(): Response
    {
        $responseBody = [
            'code' => $this->responseData['code'] ?? 0,
            'msg'  => $this->responseData['msg'] ?? '系统错误',
            'data' => $this->responseData['data'] ?? [],
        ];
        if(empty($responseBody['data'])){
            unset($responseBody['data']);
        }
        $header = array_merge(['Content-Type' => 'application/json;charset=utf-8'], $this->header);
        if (!empty($this->errorMessage)) {
            $responseBody['msg'] = $this->errorMessage;
            $responseBody        = array_merge($responseBody, $this->responseData);
        }

        return new Response($this->statusCode, $header, json_encode($responseBody));
    }


}
