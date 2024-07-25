<?php
use Webman\Route;

// 微信支付回调
Route::post('/wxpay/notify/{id}', [app\home\controller\Pay::class, 'notify']);

Route::options('[{path:.+}]', function () {
  return response('');
});

Route::group('/', function () {
  Route::fallback(function () {
    return view(public_path() . '/web/index.html', [
      'title'       => conf('site_subtitle') . ' - ' . conf('site_name'),
      'keywords'    => conf('site_keywords'),
      'description' => conf('site_desc'),
    ]);
  });
});