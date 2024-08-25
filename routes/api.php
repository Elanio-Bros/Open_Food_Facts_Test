<?php

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

Route::post('/login', [App\Http\Controllers\System::class, 'login']);
Route::post('/logout', [App\Http\Controllers\System::class, 'logout']);

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/refresh', [App\Http\Controllers\System::class, 'refresh']);

    Route::get('/products', [App\Http\Controllers\Product::class, 'list_products']);
    Route::get('/products/{code}', [App\Http\Controllers\Product::class, 'get_product']);

    // admin
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\System::class, 'get_info_serve']);
        Route::put('/products/{code}', [App\Http\Controllers\Product::class, 'update_product']);
        Route::delete('/products/{code}', [App\Http\Controllers\Product::class, 'delete_product']);
    });
});
