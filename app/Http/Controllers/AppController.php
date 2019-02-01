<?php

namespace App\Http\Controllers;

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
		return view('index')->with('feeds',$feeds->feeds());
	}
	
	public function about(){
		return view('about');
	}
	
	public function contact(){
		return view('contact');
	}
}
