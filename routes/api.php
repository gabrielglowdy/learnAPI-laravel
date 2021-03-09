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



Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');

Route::get('users','UserController@users');


Route::middleware('auth:api')->post('/user', 'AuthController@profile');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('user', 'AuthController@profile');
    Route::get('post/{post}', 'PostController@show');
    Route::post('post/create', 'PostController@create');
    Route::put('post/update/{post}', 'PostController@update');
    Route::delete('post/delete/{post}', 'PostController@destroy');


});
