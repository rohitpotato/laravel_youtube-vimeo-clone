<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos/{video}', 'VideoController@show')->name('video.show');

Route::post('/videos/views/{video}', 'VideoViewController@create');

Route::get('/search', 'SearchController@index');

Route::get('/videos/{video}/comments', 'VideoCommentController@index');

Route::get('/subscription/{channel}', 'ChannelSubscriptionController@show');

Route::get('/trending', 'TrendingController@index')->name('trending');

Route::get('/channel/{channel}', 'ChannelController@show')->name('channel');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/videos/{video}/votes', 'VideoVoteController@show');

Route::post('/webhook/encoding', 'EncodingWebhookController@videoEncoded');

Route::group(['middleware' => ['auth']], function() {


Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit')->name('channel.edit');
	
	Route::get('/upload', 'testerController@index')->name('uploader');

	Route::put('/channel/{channel}/update', 'ChannelSettingsController@update')->name('channel.update');
	Route::post('/upload', 'testerController@store');



	Route::post('/videos', 'VideoController@store');
	Route::put('/videos/{video}', 'VideoController@update');
	Route::get('/videos', 'VideoController@index');

	Route::get('/video/{video}/edit', 'VideoController@edit')->name('video.edit');
	Route::delete('/video/{video}', 'VideoController@delete')->name('video.delete');

	Route::post('/videos/{video}/votes', 'VideoVoteController@create');
	Route::delete('/videos/{video}/votes', 'VideoVoteController@delete');

	Route::post('/videos/{video}/comments', 'VideoCommentController@create');

	Route::delete('/videos/{video}/comments/{comment}', 'VideoCommentController@delete');

	Route::post('/subscription/{channel}', 'ChannelSubscriptionController@create');

	Route::delete('/subscription/{channel}', 'ChannelSubscriptionController@delete');

	Route::get('/user/{user}/notifications', 'UserNotificationController@index');

});