<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiPostController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'post'
], function () {
    Route::get('list', [ApiPostController::class, 'list'])->name('api.list');
    Route::post('showId', [ApiPostController::class, 'showId'])->name('api.showId');
    Route::post('create', [ApiPostController::class, 'create'])->name('api.create');
    Route::put('update', [ApiPostController::class, 'update'])->name('api.update');
    Route::delete('destroy', [ApiPostController::class, 'destroy'])->name('api.destroy');
});

