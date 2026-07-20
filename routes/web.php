<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.xml', [\App\Http\Controllers\Api\SitemapController::class, 'index']);
Route::get('/robots.txt', [\App\Http\Controllers\Api\SitemapController::class, 'robots']);
