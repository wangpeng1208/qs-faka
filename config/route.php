<?php
use Webman\Route;

// Route::group('/api', function () {
//   foreach (glob(app_path('/*/route/*.php')) as $filename) {
//     require_once $filename;
//   }
// });
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