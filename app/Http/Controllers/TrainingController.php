<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Tag;
use App\Training;
use App\Media;
use App\Matto\FileUpload;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class TrainingController extends Controller
{
	use Resource;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware(['auth','verified'])->except(['search','index', 'show','userTrainings']);//This is to authenticate the user, only training list and single training view is publicly accessible
    }

    public function search(Request $request){
        return Training::search($request->get('q'))
                            ->with('user')
                            ->with('discussions')
                            ->with('tags')
                            ->get();
        }

    private function getTraining($id){
        return $this->find(Training::class,$id);
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
            $trainings = Auth::user()->interestedTrainings();
        }else{
            $trainings = Training::orderBy('created_at','desc');
        }
        return view('training.index')->with('trainings',$trainings->paginate(config('app.pagination')))->with('src', $src);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training.create');
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
			'training_title' => 'required',
        ]);
        
    $training = new Training();
	$training->title = $request->training_title;
 	$training->user_id = auth()->user()->id;
	$training->content = $request->training_content;
    $training->slug = $this->generateSlug(Training::class,$request->training_title);
    $training->save();
    $training->tags()->attach($request->tags);
    if($request->hasFile('media')){
        $upload = new FileUpload(
            $request,
            $name = 'media',
            $title = $training->slug,
            $path = 'public/trainings/media'
        );
        if(count($upload->files) > 0){
            foreach($upload->files as $file){
                Media::create([
                    'training_id' => $training->id,
                    'slug' => $file['slug'],
                    'type' => $file['type']
                ]);
            }
        }
    }
	
	return redirect()->route('training.show',$training->slug)->with('success','Training published!');
		}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = $this->getTraining($id);
		return view('training.show')->with('training',$training);
    }

    public function discuss($training){
        $training = $this->getTraining($training);
        return view('discussion.create')->with('training',$training);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training = $this->getTraining($id);
		return view('training.edit')->with('training',$training);
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
			'training_title' => 'required',
        ]);
        
    $training = $this->getTraining($id);
	$training->title = $request->training_title;
	$training->content = $request->training_content;
    // $training->slug = $this->generateSlug($training,$request->training_title);
	$training->save();
    $training->tags()->sync($request->tags);
    
	return redirect()->route('training.show',$training->slug)->with('success','Training updated!');
    }	
    
    public function addMedia(Request $request, $id){
        $training = $this->getTraining($id);
        if($request->hasFile('media')){
            $upload = new FileUpload(
                $request,
                $name = 'media',
                $title = $training->slug,
                $path = 'public/trainings/media'
            );
            if(count($upload->files) > 0){
                foreach($upload->files as $file){
                    Media::create([
                        'training_id' => $training->id,
                        'slug' => $file['slug'],
                        'type' => $file['type']
                    ]);
                }
            }
            return redirect()->route('training.show',[$training->slug])->with('success', count($upload->files).' media added to training');
        }
        return redirect()->back()->with('info', 'select media to add to training');
    }

    public function removeMedia(Request $request, $id){
        $training = $this->getTraining($id);
        $count = 0;
        if($request->media !== null && count($request->media) > 0){
            foreach($request->media as $m){
                $media = Media::find($m);
                $media->delete();
                $count++;
            }
            return redirect()->route('training.show',[$training->slug])->with('success', $count.' media removed from training');
        }
        return redirect()->back()->with('info', 'No media selected');
    }

    public function delete($id){
        $training = $this->getTraining($id);
        if(!$training->isMine()){
			return redirect()->route('training.show',[$id])->with('error','Not allowed!');
		}
        return view('training.delete')->with('training', $training);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = $this->getTraining($id);
		if(!$training->isMine()){
			return redirect()->route('training.show',[$id])->with('error','Not allowed!');
		}
        // if($training->cover_image !== null && $training->cover_image != 'default_image.jpg'){
        // 	unlink(public_path().'/storage/images/trainings/'.$training->cover);
        // }
		$training->delete();
		return redirect()->route('trainings')->with('success','Training deleted!');
    }

    public function userTrainings($username){
        $user = User::where('username',$username)->firstorfail();
        return view('training.index')->with('user',$user)->with('trainings', $user->trainings);
	}

}
