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

Route::get('/', 'FirstController@index');

Auth::routes();

Route::get('/profile/{id}', 'ProfileController@index')->name('profile');
Route::resource('post', 'PostController')->except(['index', 'create']);
Route::post('/follow/{id}', 'FollowController@follow')->name('follow');
Route::post('/getfollow/{id}', 'FollowController@getFollow')->name('getFollow');
