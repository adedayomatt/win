<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Tag;
use App\Experience;
use App\Media;
use App\Matto\FileUpload;
use App\Traits\Resource;
use App\Events\NewExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

use App\Http\Resources\Experience as ExperienceResource;
use App\Http\Resources\Discussion as DiscussionResource;



class ExperienceController extends Controller
{
	use Resource;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware(['auth','verified'])->except(['search','index', 'show','userExperiences']);//This is to authenticate the user, only experience list and single experience view is publicly accessible
    }

    public function search(Request $request){
        return Experience::search($request->get('q'))
                            ->with('user')
                            ->get();
        }

    private function getExperience($id){
        return $this->find(Experience::class,$id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $src = Input::get('src', 'interests');
        if(Auth::check() && ($src == null || $src == 'interests')){
            $experiences = Auth::user()->interestedExperiences();
        }else{
            $experiences = Experience::orderBy('created_at','desc');
        }
        return view('experience.index')->with('experiences',$experiences->paginate(config('custom.pagination')))->with('src', $src);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('experience.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
			'experience_title' => 'required',
        ]);
        
    $experience = new Experience();
	$experience->title = $request->experience_title;
 	$experience->user_id = auth()->user()->id;
	$experience->content = $request->experience_content;
    $experience->slug = $this->generateSlug(Experience::class,$request->experience_title);
    $experience->save();
    $experience->tags()->attach($request->tags);
    if($request->hasFile('media')){
        $upload = new FileUpload(
            $request,
            $name = 'media',
            $title = $experience->slug,
            $path = 'public/experiences/media'
        );
        if(count($upload->files) > 0){
            foreach($upload->files as $file){
                Media::create([
                    'experience_id' => $experience->id,
                    'slug' => $file['slug'],
                    'type' => $file['type']
                ]);
            }
        }
    }
    
    event(new NewExperience($experience));

	return redirect()->route('experience.show',$experience->slug)->with('success','Experience published!');
		}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $experience = $this->getExperience($id);
        if($this->isAPIRequest()){
            return new ExperienceResource($experience);
        }

		return view('experience.show')->with('experience',$experience);
    }

    public function discuss($experience){
        $experience = $this->getExperience($experience);
        return view('discussion.create')->with('experience',$experience);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $experience = $this->getExperience($id);
		return view('experience.edit')->with('experience',$experience);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[ 
			'experience_title' => 'required',
        ]);
        
    $experience = $this->getExperience($id);
	$experience->title = $request->experience_title;
	$experience->content = $request->experience_content;
    // $experience->slug = $this->generateSlug($experience,$request->experience_title);
	$experience->save();
    $experience->tags()->sync($request->tags);
    
	return redirect()->route('experience.show',$experience->slug)->with('success','Experience updated!');
    }	
    
    public function addMedia(Request $request, $id){
        $experience = $this->getExperience($id);
        if($request->hasFile('media')){
            $upload = new FileUpload(
                $request,
                $name = 'media',
                $title = $experience->slug,
                $path = 'public/experiences/media'
            );
            if(count($upload->files) > 0){
                foreach($upload->files as $file){
                    Media::create([
                        'experience_id' => $experience->id,
                        'slug' => $file['slug'],
                        'type' => $file['type']
                    ]);
                }
            }
            return redirect()->route('experience.show',[$experience->slug])->with('success', count($upload->files).' media added to experience');
        }
        return redirect()->back()->with('info', 'select media to add to experience');
    }

    public function removeMedia(Request $request, $id){
        $experience = $this->getExperience($id);
        $count = 0;
        if($request->media !== null && count($request->media) > 0){
            foreach($request->media as $m){
                $media = Media::find($m);
                $media->delete();
                $count++;
            }
            return redirect()->route('experience.show',[$experience->slug])->with('success', $count.' media removed from experience');
        }
        return redirect()->back()->with('info', 'No media selected');
    }

    public function delete($id){
        $experience = $this->getExperience($id);
        if(!$experience->isMine()){
			return redirect()->route('experience.show',[$id])->with('error','Not allowed!');
		}
        return view('experience.delete')->with('experience', $experience);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experience = $this->getExperience($id);
		if(!$experience->isMine()){
			return redirect()->route('experience.show',[$id])->with('error','Not allowed!');
		}
        // if($experience->cover_image !== null && $experience->cover_image != 'default_image.jpg'){
        // 	unlink(public_path().'/storage/images/experiences/'.$experience->cover);
        // }
		$experience->delete();
		return redirect()->route('experiences')->with('success','Experience deleted!');
    }

    public function userExperiences($username){
        $user = User::where('username',$username)->firstorfail();
        return view('experience.index')->with('user',$user)->with('experiences', $user->experiences);
	}

}
