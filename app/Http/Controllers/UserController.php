<?php

namespace App\Http\Controllers;
use Auth;
use Image;
use Validator;
use App\User;
use App\Experience;
use App\School;
use App\Education;
use App\Work;
use App\Company;
use App\Matto\Feeds;
use App\Matto\FileUpload;
use Illuminate\Http\Request;
use App\Traits\Resource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Feed as FeedResource;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	use Resource;

	public function __construct(){
		$this->middleware('auth')->except(['search','index','show','feeds','contributions']);
	}

	public function search(Request $request){
        return User::search($request->get('q'))
                            ->get();
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
		$users = User::orderby('created_at','asc')->paginate(config('custom.pagination'));
		return view('user.index')->with('users',$users);
	}
	
	public function show($username){
		$user = $this->find($username);
		if($this->isAPIRequest()){
			return new UserResource($user);
		}
		return view('user.show')->with(['user'=>$user]);
	}
	public function feeds($username){
		$user = $this->find($username);
		if($this->isAPIRequest()){
			$feeds = new Feeds($user->discussions,$user->experiences,$user->comments);
			return FeedResource::collection($feeds->feeds());
		}
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
		if(!$request->has('tags') || count($request->tags) == 0){
			return redirect()->back()->with('info','No tag selected, you will have nothing on your feed');
		}
		$user->tagsFollowing()->attach($request->tags);
		$following = $user->tagsFollowing()->count();
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
			'avatar' => ['required','image','mimes:jpeg,png,jpg,JPG,gif,svg','max:15048']
		]);
		if ($request->hasFile('avatar')){
			$file = $request->file('avatar');
			$user = Auth::user();
			$prev_avatar = $user->avatar;
			$new_avatar = $user->id.'-'.$user->username.'-'.time().'.'.$file->getClientOriginalExtension();
			Image::make($file)->resize(250, 205)->save( public_path('storage/images/users/' . $new_avatar));
			$user->avatar = $new_avatar;
			$user->save();
			if(Storage::exists('public/images/users/'.$prev_avatar)){
				Storage::delete('public/images/users/'.$prev_avatar);
			}
			return redirect()->back()->with('success','profile picture updated!');

		  }
		// if($request->hasFile('avatar')){
		// 	$storage = public_path('storage/images/users/');
		// 	$old_avatar = $user->avatar;
			
		// 	$upload = new FileUpload($request,
		// 							$name='avatar',
		// 							$title=$user->id.'-'.$user->username.'-'.time(),
		// 							$path = 'public/images/users/'
		// 						  );
		// 	if(!empty($upload->files)){
		// 		$user->avatar = $upload->files[0]['slug'];
		// 		$user->save();
		// 		// if(file_exists($storage.$upload->files[0])){//confirm if new avatar is uploaded successfully
		// 		// 	// if(file_exists($storage.$old_avatar)){
		// 		// 	// 	unlink($storage.$old_avatar);
		// 		// 	// }
		// 		// }
		// 	}

		// 	return redirect()->back()->with('success','profile picture updated!');
		// }
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

		$user->firstname = $request->firstname;
		$user->lastname = $request->lastname;
		$user->username = $request->username;
		$user->bio = $request->bio;
		$user->save();
		
		return redirect()->route('user.profile',['username' => $user->username])->with('success','Profile updated');
	}

	public function updateInterests(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}

		if(!$request->has('tags') || count($request->tags) == 0){
			$user->tagsFollowing()->sync([]);
			return redirect()->back()->with('info','No tag selected, you will have nothing on your feed');
		}
		$user->tagsFollowing()->sync($request->tags);

		return redirect()->back()->with('success','interest updated');
	}

	public function updateWork(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		
		$this->validate($request, [
			'company' => 'required',
			// 'started_at' => 'date'
        ]);
		
		if(!$user->hasWork()){
			Work::create([
				'user_id' => $user->id,
				'company_id' => $request->company,
				'position' => $request->position,
				'job_description' => $request->job_description,
				'started_at' => $request->started_at
			]);
		}else{
			$user->work->position = $request->position;
			$user->work->company_id = $request->company;
			$user->work->job_description = $request->job_description;
			$user->work->started_at = $request->started_at;
			$user->work->save();
		}
		
		return redirect()->route('user.profile',['username' => $username])->with('success','Profile updated');
	}

	public function updateEducation(Request $request, $username){
		$user = $this->find($username);
		if(!$this->authorized($user)){
			return $this->bounce($user);
		}
		
		$this->validate($request, [
            'school' => 'required',
			'started_at' => 'date',
			'finished_at' => 'date',
		]);


		if(!$user->hasEducation()){
			Education::create([
				'user_id' => $user->id,
				'school_id' => $request->school,
				'course' => $request->course,
				'started_at' => $request->start,
				'finished_at' => $request->finish,
			]);
		}else{
			$user->education->school_id = $request->school;
			$user->education->course = $request->course;
			$user->education->started_at = $request->start;
			$user->education->finished_at = $request->finish;
			$user->education->save();
		}
		
		return redirect()->route('user.profile',['username' => $username])->with('success','Profile updated');
	}

	public function contributions($username){
		$user = User::where('username',$username)->firstorfail();
        return view('user.contributions')->with('user',$user)->with('contributions', $user->discussionContributions($raw = true)->paginate(config('custom.pagination')));
	}

}
