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
//個人頁面
Route::get('/profile/{id}', 'ProfileController@index')->name('profile');
//搜尋
Route::get('search', 'ProfileController@search')->name('search');
//搜尋自動完成
Route::post('namecomplete', 'ProfileController@nameComplete')->name('nameComplete');
//文章
Route::resource('post', 'PostController')->except('create');
//追蹤
Route::post('/follow/{id}', 'FollowController@follow')->name('follow');
//顯示粉絲或追蹤的人
Route::post('/getfollow/{id}', 'FollowController@getFollow')->name('getFollow');
//是否有追蹤
Route::post('replyFollow', 'FollowController@replyFollow')->name('replyFollow');
//允許追蹤
Route::post('allowFollow', 'FollowController@allowFollow')->name('allowFollow');
//拒絕追蹤
Route::post('rejectFollow', 'FollowController@rejectFollow')->name('rejectFollow');
//顯示按讚的人
Route::get('like/{id}', 'LikeController@show')->name('like.show');
//顯示讚資訊
Route::post('likeInformation/{id}', 'LikeController@likeInformation')->name('like.information');

Route::post('like', 'LikeController@like')->name('like');
//顯示留言
Route::get('comment/{id}', 'CommentController@show')->name('comment.show');
//建立留言
Route::post('comment/{id}', 'CommentController@store')->name('comment.store');
