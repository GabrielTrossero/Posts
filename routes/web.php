<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Rutas de Post
/*Route::get('/', 'PostController@index');
Route::get('create', 'PostController@create');
Route::post('create', 'PostController@store');
Route::get('show/{slug}', 'PostController@getShowId');
Route::get('edit/{slug}', 'PostController@edit');
Route::post('edit', 'PostController@update');
Route::post('delete', 'PostController@destroy');*/

Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('create', [PostController::class, 'create'])->name('post.create');
Route::post('create', [PostController::class, 'store'])->name('post.store');
Route::get('show/{slug}', [PostController::class, 'getShowId'])->name('post.showId');
Route::get('edit/{slug}', [PostController::class, 'edit'])->name('post.edit');
Route::post('edit', [PostController::class, 'update'])->name('post.update');
Route::delete('delete', [PostController::class, 'destroy'])->name('post.destroy');




//Rutas de Mail
/*Route::get('/contact', 'MailController@index');
Route::post('/contact', 'MailController@store');
*/

Route::get('/contact', [MailController::class, 'index'])->name('mail.index');
Route::post('/contact', [MailController::class, 'store'])->name('mail.store');
