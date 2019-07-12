<?php

namespace App\Http\Controllers;

use Auth;
use App\Tag;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    
    use Resource;

    public function __construct()
    {
        $this->middleware('auth')->except(['search','index', 'show','trainings','discussions','followers']);
        $this->middleware('verified')->except(['search','index', 'show','trainings','discussions','followers','follow']);
    }

    private function getTag($id){
        return $this->find(Tag::class,$id);
    }

    public function search(Request $request){
    return Tag::search($request->get('q'))
                    ->with('trainings')
                    ->with('discussions')
                    ->with('users')
                    ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tag.index')->with('tags',Tag::orderby('name','asc')->paginate(config('app.pagination')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
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
            'name' => 'required|unique:tags',
         ],[
             'unique' => 'Tag already exist'
         ]);
		$tag_format = str_replace('-','_',str_slug($request->name));
		$tag = Tag::create([
            'user_id' => Auth::id(),
            'name' => $tag_format,
            'description' => $request->description,
            'slug' => str_slug($request->name)
        ]);

        Auth::user()->tagsFollowing()->attach($tag->id);

		return redirect()->route('tags')->with('success','Tag '.$tag_format.' created');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = $this->getTag($id);
        $tagActivities = $tag->discussions->merge($tag->trainings)->sortByDesc('created_at')->paginate(config('app.pagination'));
        //dd($tagActivities);
        return view('tag.show')->with('tag', $tag)
                                ->with('activities', $tagActivities);
    }

    public function discussions($id){
        $tag = $this->getTag($id);
        return view('tag.discussions')->with('tag', $tag)
                                    ->with('discussions', $tag->discussions()->orderby('created_at','desc')->paginate(config('app.pagination')));
    }
    public function trainings($id){
        $tag = $this->getTag($id);
        return view('tag.trainings')->with('tag', $tag)
                                ->with('trainings', $tag->trainings()->orderby('created_at','desc')->paginate(config('app.pagination')));
    }

    public function followers($id){
        $tag = $this->getTag($id);
        return view('tag.followers')->with('tag', $tag)
                                ->with('followers', $tag->users()->orderby('created_at','desc')->paginate(config('app.pagination')));
    }

    public function follow(Request $request, $id){
        $tag = $this->getTag($id);
        if(Auth::user()->isFollowing($tag)){ //if already following
            $tagsFollowingId = Auth::user()->interests();
            $interests = [];
            foreach($tagsFollowingId as $id){
                if($id != $tag->id){
                    array_push($interests, $id);
                }
            }
            Auth::user()->tagsFollowing()->sync($interests);
    
            if($request->has('async')){//if submitted via ajax
                return json_encode(['message' => 'You no longer follow #'.$tag->name]);
            }
            return redirect()->route('tag.show',[$tag->slug])->with('success', 'You no longer follow #'.$tag->name);

        }else{ //if not following before
            Auth::user()->tagsFollowing()->attach($tag->id);
            if($request->has('async')){//if submitted via ajax
                return json_encode(['message' => 'You are now following #'.$tag->name]);
            }
            return redirect()->route('tag.show',[$tag->slug])->with('success', 'You are now following #'.$tag->name);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('tag.edit')->with('tag', $this->getTag($id));
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
		// $this->validate($request,[
		// 		'name' => 'required'
		// 		]);
		
		$tag = $this->getTag($id);
        // $tag->name = $request->name;
        $tag->description = $request->description;
        // $tag->slug = str_slug($request->name);
		$tag->save();
		return redirect()->route('tag.show',[$tag->slug])->with('success','Tag '.$request->name.' updated');
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getTag($id)->delete();
		return redirect()->back()->with('success','Tag deleted');
    }
}
