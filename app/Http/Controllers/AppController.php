<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Experience;
use App\Comment;
use App\Discussion;
use App\Matto\Feeds;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Feed as FeedResource;

class AppController extends Controller
{
	use Resource;

	public function search(Request $request){
		$query = $request->get('q');
		$discussions = app('App\Http\Controllers\DiscussionController')->search($request);
		$experiences = app('App\Http\Controllers\ExperienceController')->search($request);
		$tags = app('App\Http\Controllers\TagController')->search($request);
		$experiences = app('App\Http\Controllers\ExperienceController')->search($request);
		$users = app('App\Http\Controllers\UserController')->search($request);

		return response(['query' => $query, 'tags' => $tags, 'discussions' => $discussions, 'experiences' => $experiences, 'users' => $users]);
								
	}
    public function index(Request $request){
		if($request->user()){
			$feeds = new Feeds($request->user()->interestedDiscussions(),$request->user()->interestedExperiences(),$request->user()->commentsOnContributions());
		}
		else{
			$feeds = new Feeds(Discussion::all(),Experience::all(),Comment::all());
		}
		if($this->isAPIRequest()){
			return  FeedResource::collection($feeds->feeds());
		}
		return view('index')->with('feeds',$feeds->feeds()->sortByDesc('created_at'));
	}	
	public function about(){
		return view('about');
	}
	
	public function contact(){
		return view('contact');
	}
}
