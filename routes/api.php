<?php

use App\Http\Controllers\Api\CafeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmbedController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//tiktok
Route::get('/embed/{url}', [EmbedController::class, 'show']);

//cafe
Route::get('/cafe', [CafeController::class, 'index']);
Route::post('/cafe/fav', [CafeController::class, 'fav']);

//category
Route::post('/category', [CategoryController::class, 'store']);

//menu
Route::get('/menu/{id}', [MenuController::class, 'show']);

//geolocation
Route::prefix('/geo')->group(function () {
    Route::get('/province', [GeoController::class, 'province']);
    Route::get('/city', [GeoController::class, 'city']);
    Route::get('/district', [GeoController::class, 'district']);
});
