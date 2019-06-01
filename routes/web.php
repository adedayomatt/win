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

Route::get('/', 'AppController@index')->name('home');
Auth::routes();
Route::get('@{username}','UserController@show')->name('user.profile');
Route::get('@{username}/interests','UserController@createInterests')->name('create.interests');
Route::post('@{username}/interests','UserController@addInterests')->name('add.interests');
Route::get('@{username}/settings','UserController@settings')->name('user.settings');
Route::put('@{username}/settings/avatar','UserController@updateAvatar')->name('update.avatar');
Route::put('@{username}/settings/info','UserController@updateInfo')->name('update.info');
Route::put('@{username}/settings/interests','UserController@updateInterests')->name('update.interests');

Route::resource('tag','TagController');
Route::get('tags', 'TagController@index')->name('tags');
Route::get('tag/{tag}/follow','TagController@follow')->name('tag.follow');
Route::get('tag/{tag}/unfollow','TagController@unfollow')->name('tag.unfollow');
Route::get('search/tag', 'TagController@search')->name('search.tag');

Route::resource('forum','ForumController');
Route::get('forums','ForumController@index')->name('forums');

Route::resource('discussion','DiscussionController');
Route::get('discussions','DiscussionController@index')->name('discussions');
Route::post('discussion/{discussion}/invite/','DiscussionController@inviteUsers')->name('discussion.invite.users');
Route::resource('discussion/{discussion}/comment','CommentController');
Route::post('discussion/{discussion}/comment/{comment}/reply','CommentController@reply')->name('comment.reply');
Route::post('discussion/{discussion}/comment/{comment}/like','CommentController@like')->name('comment.like');
Route::post('discussion/{discussion}/comment/{comment}/unlike/','CommentController@unlike')->name('comment.unlike');


Route::resource('post','PostController');
Route::get('posts','PostController@index')->name('posts');
Route::get('post/{post}/discuss','PostController@discuss')->name('post.discuss');

Route::resource('category','PostCategoryController',['as' => 'post']);
Route::get('categories','PostCategoryController@index')->name('post.categories');




