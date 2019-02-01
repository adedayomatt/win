<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Matto\Feeds;
use Auth;

class UserController extends Controller
{

	public function __construct(){
		$this->middleware('auth')->except(['index','show']);
	}

	protected function find($username){
		return User::where('username',$username)->firstorfail();
	}

    public function index(){
		$users = User::orderby('created_at','asc')->paginate(5);
		return view('user.index')->with('users',$users);
	}
	
	public function show($username){
		$user = $this->find($username);
		$feeds = new Feeds($user->discussions,null,$user->comments);
		return view('user.show')->with(['user'=>$user,'feeds'=>$feeds->feeds()]);
		

	}

	public function createInterests($username){
		$user = $this->find($username);
		return view('user.add-interests')->with('user',$user);
	}

	public function addInterests(Request $request, $username){
		$this->validate(request(), [
            'tags' => 'required',
        ]);
		$user = $this->find($username);
		$user->tags()->attach($request->tags);
		$following = $user->tags->count();
		return redirect()->route('home')->with('success','You are now following '.$following.' tags');
	}


	public function editInterests($username){
		$user = $this->find($username);
		dd($user->tags());
		return view('user.add-interests')->with('user',$user);
	}

	public function updateInterest($username){
		$this->validate(request(), [
            'tags' => 'required',
        ]);
		$user = $this->find($username);
		$user->tags()->sync($request->tags);

		return redirect()->route('profile',$user);
	}



	public function edit($username){
		if(Auth::user()->username !== $username){
			return redirect()->route('user.profile',['username' => $username]);
		}	
		
		return view('users.edit')->with('user',Auth::user());
	}
	
	public function update($username){
		$user = Auth::user();
		
		$this->validate(request(), [
            'name' => 'required|string',
			'avatar' => 'image',
			'bio' => 'string|max:100',
			'username' => 'required|string'
        ]);
		$username = request()->username;
		
		if(User::where('id','!=',$user->id)->where('username',$username)->get()->count() > 0){
			return redirect()->back()->with('error','username '.$username.' already taken');
		}
		if(request()->hasFile('avatar')){
			$prevAvatar = $user->profile->avatar;
			$filename = time().request()->avatar->getClientOriginalName();
			if(request()->avatar->storeAs('public/avatar',$filename)){
				if(is_file('storage/avatar/'.$prevAvatar)){
					unlink('storage/avatar/'.$prevAvatar);//delete the previous avatar
				}
			$user->profile->avatar = $filename;
			}
		}
		
			$user->name = request()->name;
			$user->username = $username;
			$user->profile->username = $username;
			$user->profile->bio = request()->bio;
			$user->save();
			$user->profile->save();
			
			return redirect()->route('user.profile',['username' => $username])->with('success','Profile updated');
	}
}
