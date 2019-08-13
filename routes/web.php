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
Route::get('mail',function(){
    return view('mail.password-reset-mail',['token' => 1234]);
});
Route::get('/', 'AppController@index')->name('home');
Auth::routes(['verify' => true]);
// search routes
Route::group(['prefix' => 'search'], function(){
    Route::get('user','UserController@search')->name('search.user');
    Route::get('tag', 'TagController@search')->name('search.tag');
    Route::get('discussion', 'DiscussionController@search')->name('search.discussion');
    Route::get('training', 'TrainingController@search')->name('search.training');
    Route::get('company', 'CompanyController@search')->name('search.company');
    Route::get('school', 'SchoolController@search')->name('search.school');
});

Route::get('users','UserController@index')->name('users');
Route::get('@{username}','UserController@show')->name('user.profile');
Route::get('@{username}/trainings','TrainingController@userTrainings')->name('user.trainings');
Route::get('@{username}/forums','ForumController@userForums')->name('user.forums');
Route::get('@{username}/discussions','DiscussionController@userDiscussions')->name('user.discussions');
Route::get('@{username}/contributions','UserController@contributions')->name('user.contributions');
Route::get('@{username}/interests','UserController@createInterests')->name('create.interests');
Route::post('@{username}/interests','UserController@addInterests')->name('add.interests');
Route::get('@{username}/settings','UserController@settings')->name('user.settings');
Route::put('@{username}/settings/avatar','UserController@updateAvatar')->name('update.avatar');
Route::put('@{username}/settings/info','UserController@updateInfo')->name('update.info');
Route::put('@{username}/settings/interests','UserController@updateInterests')->name('update.interests');
Route::put('@{username}/settings/work','UserController@updateWork')->name('update.work');
Route::put('@{username}/settings/education','UserController@updateEducation')->name('update.education');

Route::resource('tag','TagController');
Route::get('tags', 'TagController@index')->name('tags');
Route::get('tag/{tag}/discussions','TagController@discussions')->name('tag.discussions');
Route::get('tag/{tag}/trainings','TagController@trainings')->name('tag.trainings');
Route::get('tag/{tag}/followers','TagController@followers')->name('tag.followers');
Route::post('tag/{tag}/follow','TagController@follow')->name('tag.follow');

Route::resource('forum','ForumController');
Route::get('search/forum', 'ForumController@search')->name('search.forum');
Route::get('forums','ForumController@index')->name('forums');

Route::resource('discussion','DiscussionController');
Route::get('discussions','DiscussionController@index')->name('discussions');
Route::post('discussion/{discussion}/invite/','DiscussionController@inviteUsers')->name('discussion.invite.users');
Route::resource('discussion/{discussion}/comment','CommentController');
Route::post('discussion/{discussion}/comment/{comment}/reply','CommentController@reply')->name('comment.reply');
Route::post('discussion/{discussion}/comment/{comment}/like','CommentController@like')->name('comment.like');
Route::get('discussion/{discussion}/delete', 'DiscussionController@delete')->name('discussion.delete');

Route::resource('training','TrainingController');
Route::get('trainings','TrainingController@index')->name('trainings');
Route::get('training/{training}/discuss','TrainingController@discuss')->name('training.discuss');
Route::post('training/{training}/media/add','TrainingController@addMedia')->name('training.media.add');
Route::delete('training/{training}/media/remove','TrainingController@removeMedia')->name('training.media.remove');
Route::get('training/{training}/delete', 'TrainingController@delete')->name('training.delete');

Route::resource('company', 'CompanyController');
Route::get('companies', 'CompanyController@index')->name('companies');

Route::resource('school', 'SchoolController');
Route::get('schools', 'SchoolController@index')->name('schools');

Route::group(['prefix' => 'async'],function(){

});

