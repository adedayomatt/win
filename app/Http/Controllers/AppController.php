<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Training;
use App\Comment;
use App\Discussion;
use App\Matto\Feeds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index(){
		if(Auth::check()){
			$feeds = new Feeds(Auth::user()->interestedDiscussions(),Auth::user()->interestedTrainings(),null);
		}
		else{
			$feeds = new Feeds(Discussion::orderby('created_at','desc')->get(),Training::orderby('created_at','desc')->get(),null);
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
