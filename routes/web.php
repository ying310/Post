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
Route::get('search', 'ProfileController@search')->name('search');
Route::resource('post', 'PostController')->except(['index', 'create']);
Route::post('/follow/{id}', 'FollowController@follow')->name('follow');
Route::post('/getfollow/{id}', 'FollowController@getFollow')->name('getFollow');
Route::post('replyFollow', 'FollowController@replyFollow')->name('replyFollow');
Route::post('allowFollow', 'FollowController@allowFollow')->name('allowFollow');
Route::post('rejectFollow', 'FollowController@rejectFollow')->name('rejectFollow');
// Route::get('search', 'FirstController@search')->name('search');
