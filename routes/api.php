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

Route::get('/', function () {
    // phpinfo()
    return response()->json([''],200);
});

Route::get('/products', [App\Http\Controllers\Product::class, 'list_products']);
Route::get('/products/{code}', [App\Http\Controllers\Product::class, 'get_product']);
Route::put('/products/{code}', [App\Http\Controllers\Product::class, 'update_product']);
Route::delete('/products/{code}', [App\Http\Controllers\Product::class, 'delete_product']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
