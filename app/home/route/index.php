<?php

use Webman\Route;


Route::get('/shop/pay', [app\home\controller\Pay::class, 'pay']);