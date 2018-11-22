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

Auth::routes(['verify' => 'true']);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index');
Route::resource('/threads', 'ThreadsController');
Route::get('/threads/{thread}/comments', 'CommentsController@index');
Route::post('/threads/{thread}/comments', 'CommentsController@store')->name('comments.store');
Route::post('/threads/{thread}/subscriptions', 'SubscriptionsController@subscribeToThread');
Route::delete('/threads/{thread}/subscriptions', 'SubscriptionsController@unsubscribeFromThread');
//Route::post('/threads/{thread}/lock', 'LockThreads')
Route::patch('/comments/{comment}', 'CommentsController@update');
Route::delete('/comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
Route::post('/comments/{comment}/best', 'BestCommentsController@store');
Route::delete('/comments/{comment}/best', 'BestCommentsController@remove');
Route::resource('/channels', 'ChannelsController');
Route::post('/comments/{comment}/likes', 'LikesController@store')->name("like.store");
Route::delete('/comments/{comment}/likes', 'LikesController@destroy')->name("like.destroy");
Route::get('/profile/{user}', 'ProfilesController@show')->name('profile');
Route::get('/activities/{user}', 'ActivitiesController@show')->name('activities');
Route::get('/notifications', 'NotificationsController@index');
Route::delete('/notifications/{id}', 'NotificationsController@markAsRead');
Route::get('/api/users', 'Api\UsersController@index');

Route::post('/api/users/avatar', 'Api\UsersController@storeAvatar');

Route::group(['middleware' => 'verified'], function(){
    Route::get('/myprofile', 'ProfilesController@index')->name('myprofile');
    Route::patch('/myprofile', 'ProfilesController@updateProfileData')->name('myprofile');
});