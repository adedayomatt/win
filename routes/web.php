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
Route::get('users','UserController@index')->name('users');
Route::get('search/user','UserController@search')->name('search.user');
Route::get('@{username}','UserController@show')->name('user.profile');
Route::get('@{username}/interests','UserController@createInterests')->name('create.interests');
Route::post('@{username}/interests','UserController@addInterests')->name('add.interests');
Route::get('@{username}/settings','UserController@settings')->name('user.settings');
Route::put('@{username}/settings/avatar','UserController@updateAvatar')->name('update.avatar');
Route::put('@{username}/settings/info','UserController@updateInfo')->name('update.info');
Route::put('@{username}/settings/interests','UserController@updateInterests')->name('update.interests');
Route::put('@{username}/settings/work','UserController@updateWork')->name('update.work');
Route::put('@{username}/settings/education','UserController@updateEducation')->name('update.education');

Route::resource('tag','TagController');
Route::get('search/tag', 'TagController@search')->name('search.tag');
Route::get('tags', 'TagController@index')->name('tags');
Route::get('tag/{tag}/discussions','TagController@discussions')->name('tag.discussions');
Route::get('tag/{tag}/trainings','TagController@trainings')->name('tag.trainings');
Route::get('tag/{tag}/followers','TagController@followers')->name('tag.followers');
Route::post('tag/{tag}/follow','TagController@follow')->name('tag.follow');

Route::resource('forum','ForumController');
Route::get('search/forum', 'ForumController@search')->name('search.forum');
Route::get('forums','ForumController@index')->name('forums');

Route::resource('discussion','DiscussionController');
Route::get('search/discussion', 'DiscussionController@search')->name('search.discussion');
Route::get('discussions','DiscussionController@index')->name('discussions');
Route::post('discussion/{discussion}/invite/','DiscussionController@inviteUsers')->name('discussion.invite.users');
Route::resource('discussion/{discussion}/comment','CommentController');
Route::post('discussion/{discussion}/comment/{comment}/reply','CommentController@reply')->name('comment.reply');
Route::post('discussion/{discussion}/comment/{comment}/like','CommentController@like')->name('comment.like');
Route::get('discussion/{discussion}/delete', 'DiscussionController@delete')->name('discussion.delete');

Route::resource('training','TrainingController');
Route::get('search/training', 'TrainingController@search')->name('search.training');
Route::get('trainings','TrainingController@index')->name('trainings');
Route::get('training/{training}/discuss','TrainingController@discuss')->name('training.discuss');
Route::post('training/{training}/media/add','TrainingController@addMedia')->name('training.media.add');
Route::delete('training/{training}/media/remove','TrainingController@removeMedia')->name('training.media.remove');
Route::get('training/{training}/delete', 'TrainingController@delete')->name('training.delete');

Route::resource('company', 'CompanyController');
Route::get('companies', 'CompanyController@index')->name('companies');
Route::get('companies/search', 'CompanyController@search')->name('company.search');

Route::resource('school', 'SchoolController');
Route::get('schools', 'SchoolController@index')->name('schools');
Route::get('schools/search', 'SchoolController@search')->name('school.search');

Route::group(['prefix' => 'async'],function(){

});

