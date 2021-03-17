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

Route::group(['middleware' => 'guest:sanctum'], function () {
    Route::post('register', 'API\Auth\RegisterController')->name('register');
    Route::post('login', 'API\Auth\LoginController@login')->name('login');
});

Route::get('explore', 'API\PublicPostController')->name('posts.explore');
Route::get('posts/{post}', 'API\Post\PostController@show');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', 'API\Auth\LoginController@logout')->name('logout');
    Route::get('me', 'API\Account\MeController')->name('me');

    Route::get('posts', 'API\Post\PostController@index');
    Route::post('posts', 'API\Post\PostController@store');
    Route::put('posts/{post}', 'API\Post\PostController@update')->middleware('can:update,post');
    Route::delete('posts/{post}', 'API\Post\PostController@destroy')->middleware('can:delete,post');

    Route::get('categories', 'API\CategoryController@index');
    Route::post('categories', 'API\CategoryController@store');
    Route::get('categories/{category}', 'API\CategoryController@show');
    Route::put('categories/{category}', 'API\CategoryController@update');
    Route::delete('categories/{category}', 'API\CategoryController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
