<?php

return [
  ''         => [
    // 前端开发时用于跨域的中间件
    app\middleware\CorsMiddleware::class, // 跨域中间件
  ],
  'merchantapi' => [
    app\middleware\MerchantLogMiddleware::class,  // 日志
  ],
  'adminapi'    => [
    app\middleware\AdminLogMiddleware::class,  // 日志
  ],

];