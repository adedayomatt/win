<?php

namespace App\Http\Controllers;
use Auth;

use Validator;
use App\User;
use App\Post;
use App\Matto\Feeds;
use App\Matto\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

	public function __construct(){
		$this->middleware('auth')->except(['index','show']);
	}

	protected function find($username){
		return User::where('username',$username)->firstorfail();
	}
	protected function authorized($user){
		return $user->id === Auth::id() ? true : false;
	}
	protected function bounce($user){
		return redirect()->route('user.profile',[$user->username]);
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
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		return view('user.add-interests')->with('user',$user);
	}

	public function addInterests(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}

		$this->validate($request, [
            'tags' => 'required',
        ]);
		$user->tags()->attach($request->tags);
		$following = $user->tags->count();
		return redirect()->route('home')->with('success','You are now following '.$following.' tags');
	}




	public function settings($username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		
		return view('user.settings')->with('user',Auth::user())
									->with('tab',Input::get('tab'));
	}

	public function updateAvatar(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		$this->validate($request,[
			'avatar' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:5048']
		]);
		
		if($request->hasFile('avatar')){
			$storage = public_path('storage/images/users/');
			$old_avatar = $user->avatar;
			
			$upload = new FileUpload($request,
									$name='avatar',
									$title=$user->id.'@'.$user->username.'-'.time(),
									$path = 'public/images/users/'
								  );
			if(!empty($upload->slugs)){
				$user->avatar = $upload->slugs[0];
				$user->save();
				if(file_exists($storage.$upload->slugs[0])){//confirm if new avatar is uploaded successfully
					if(file_exists($storage.$old_avatar)){
						unlink($storage.$old_avatar);
					}
				}
			}

			return redirect()->back()->with('success','profile picture updated!');
		}
		return redirect()->back();
	}
	
	public function updateInfo(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		
		$this->validate($request, [
            'firstname' => 'required|string',
			'lastname' => 'required|string',
			'username' => 'required|string',
			'bio' => 'max:100',
			'avatar' => 'image'
        ]);
		
		if(User::where([['id','!=',$user->id],['username',$request->username]])->count() > 0){
			return redirect()->back()->with('error','username '.$request->username.' already taken');
		}
		if($request->hasFile('avatar')){
		
			}

		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->username = $request->username;
		$user->bio = $request->bio;
		$user->save();
		
		return redirect()->route('user.profile',['username' => $username])->with('success','Profile updated');
	}

	public function updateInterests(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}

		$this->validate($request, [
            'tags' => 'required',
        ]);
		$user->tags()->sync($request->tags);

		return redirect()->back()->with('success','interest updated');
	}


}
