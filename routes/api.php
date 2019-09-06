<?php

use Illuminate\Http\Request;

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

Route::get('tags', 'TagController@index');
Route::get('tag/{tag}', 'TagController@show');

Route::get('trainings','TrainingController@index');
Route::get('training/{id}','TrainingController@show');
Route::get('training/{training}/discussions','TrainerController@discussions');

Route::get('discussions','DiscussionController@index');
Route::get('discussion/{id}','DiscussionController@show');
Route::get('discussion/{discussion}/comments','DiscussionController@comments');
Route::get('comments','CommentController@index');
Route::get('comment/{comment}','CommentController@show');
Route::get('/feeds', 'AppController@index');

Route::group(['middleware' => 'auth:api'], function(){
    // return the authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // create a new tag
    Route::post('tag', 'TagController@store');
    // follow/unfollow a tag
    Route::post('tag/{tag}/follow','TagController@follow');
    // all tags the user is following
    Route::get('my_tags',function(Request $request){
        return $request->user()->tagsFollowing;
    });
    // add a comment to a discussion
    Route::post('discussion/{discussion}/comment','CommentController@store');
    // like a comment
    Route::post('comment/{comment}/like','CommentController@like');
    // post a reply to a comment
    Route::post('comment/{comment}/reply','CommentController@reply');
    // check if user is following a tag
    Route::get('tag/{tag}/is_following',function(Request $request,$tag){
        $t = \App\Tag::where('name', $tag)->first();
        return ['follow'=> $request->user()->isFollowing($t), 'tag'=> $t];
    });
    // user tag suggestions
    Route::get('tag_suggestions',function(Request $request){
        // return json_encode($request->user()->tagSuggestions());
        return \App\Tag::all();
    });
    
});



