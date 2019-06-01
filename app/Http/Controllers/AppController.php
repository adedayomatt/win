<?php

namespace App\Http\Controllers;

use DB;
use App\Post;
use App\Comment;
use App\Discussion;
use App\Matto\Feeds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(){
		if(Auth::check()){
			$feeds = new Feeds(Auth::user()->interestedDiscussions(),Auth::user()->interestedPosts(),null);
		}
		else{
			$feeds = new Feeds(Discussion::all(),Post::all(),Comment::all());
		}
		$topContributors = Comment::select(DB::raw('count(user_id) as contributions, user_id'))->groupBy('user_id')->get();
		return view('index')->with('feeds',$feeds->feeds())
												->with('top_contributors', $topContributors);
	}
	
	public function about(){
		return view('about');
	}
	
	public function contact(){
		return view('contact');
	}
}
