<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'PostController@index');
Route::get('create', 'PostController@create');
Route::post('create', 'PostController@store');
Route::get('show/{id}', 'PostController@getShowId');
Route::get('edit/{id}', 'PostController@edit');
Route::post('edit', 'PostController@update');
Route::post('delete', 'PostController@destroy');

//Rutas de Mail
Route::get('/contact', 'MailController@index');
Route::post('/contact', 'MailController@store');
