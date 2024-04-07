<?php

return [
  ''         => [
    app\middleware\CorsMiddleware::class, // 跨域中间件
  ],
  'merchantapi' => [
    app\middleware\MerchantLogMiddleware::class,  // 日志
  ],
  'adminapi'    => [
    app\middleware\AdminLogMiddleware::class,  // 日志
  ],

];