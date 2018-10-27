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
    $latestThreads = \App\Thread::latest()->take(8)->get();
    $popularThreads = \App\Thread::withCount('comments')->orderBy('comments_count', 'desc')->take(8)->get();
    return view('welcome', [
        'latestThreads' => $latestThreads,
        'popularThreads' => $popularThreads
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/threads', 'ThreadsController');
Route::resource('/threads/{thread}/comments', 'CommentsController');
Route::resource('/channels', 'ChannelsController');
Route::post('/comments/{comment}/likes', 'LikesController@store')->name("like.store");
Route::get('/profile/{user}', 'ProfilesController@show')->name('profile');
Route::view('test' , 'threads.index');