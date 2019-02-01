<?php

namespace App\Http\Controllers;

use App\Watcher;
use App\Discussion;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    use Resource;
    
	public function __construct(){
		// $this->middleware('auth')->except(['index','show']);
    }
    
    private function getDiscussion($id){
        return $this->find(Discussion::class,$id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {		
        return view('discussion.index')->with('discussions',Discussion::Orderby('created_at','desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discussion.create');
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
			'discussion_title' => 'required',
			'content' => 'required',
			'forum' => 'required',
        ]);
        
        $discussion = new Discussion();
        $discussion->user_id = auth()->user()->id;
        if($request->exists('post')){
            $discussion->post_id = $request->post;
        }
		$discussion->title = $request->discussion_title;
		$discussion->content = $request->content;
		$discussion->forum_id = $request->forum;
		$discussion->slug = $this->generateSlug(Discussion::class,$request->discussion_title);
        $discussion->save();
        $discussion->tags()->attach($request->tags);

		return redirect()->route('discussion.show',$discussion->slug)->with('success', 'Discussion '.$request->title.' started');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('discussion.show')->with('discussion', $this->getDiscussion($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('discussion.edit')->with('discussion',$this->getDiscussion($id));
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
			'discussion_title' => 'required',
			'content' => 'required',
			'forum' => 'required'
		]);
		
		$discussion = $this->find(Discussion::class,$id);
		$discussion->title = $request->discussion_title;
		$discussion->content = $request->content;
		$discussion->forum_id = $request->forum;
		$discussion->slug = $this->updateteSlug($discussion,$request->discussion_title);
        $discussion->save();
        
        $discussion->tags()->sync($request->tags);
        
		return redirect()->route('discussion.show',$discussion->slug)->with('success','Discussion updated');
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getDiscussion($id)->delete();
		 return redirect()->back()->with('success', 'Discussion deleted');

    }
}
