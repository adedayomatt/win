<?php

namespace App\Http\Controllers;

use App\User;
use App\Discussion;
use App\Traits\Resource;
use App\Events\NewDiscussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class DiscussionController extends Controller
{
    use Resource;
    
	public function __construct(){
		 $this->middleware(['auth','verified'])->except(['search','index','show','userDiscussions']);
    }

    public function search(Request $request){
        return Discussion::search($request->get('q'))
                            ->with('user')
                            ->with('forum')
                            ->with('tags')
                            ->with('comments')
                            ->get();
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
        $src = Input::get('src', 'interests');
        if(Auth::check() && ($src == null || $src == 'interests')){
            $discussions = Auth::user()->interestedDiscussions();
        }else{
            $discussions = Discussion::orderBy('created_at','desc');
        }
        return view('discussion.index')->with('discussions',$discussions->paginate(config('app.pagination')))->with('src', $src);
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
        if($request->exists('training')){
            $discussion->training_id = $request->training;
        }
		$discussion->title = $request->discussion_title;
		$discussion->content = $request->content;
		$discussion->forum_id = $request->forum;
		$discussion->slug = $this->generateSlug(Discussion::class,$request->discussion_title);
        $discussion->save();
        $discussion->tags()->attach($request->tags);

        event(new NewDiscussion($discussion));
        
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
        $discussion = $this->getDiscussion($id);
        $contributor = null;
        $comments = $discussion->comments()->where('comment_id',null);
        $count = $discussion->comments->count();
        if(request()->get('contributor') != null){
            $contributor = User::where('username',request()->get('contributor'))->first();
            if($contributor != null){
                $comments = $discussion->comments()->where('user_id', $contributor->id);
                $count = $comments->count();
            }
        }
        return view('discussion.show')->with('discussion', $discussion)
                                        ->with('comments', $comments->orderby('created_at','desc')->paginate(config('app.pagination')))
                                        ->with('count', $count)
                                        ->with('contributor', $contributor);
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
		// $discussion->slug = $this->updateteSlug($discussion,$request->discussion_title);
        $discussion->save();
        
        $discussion->tags()->sync($request->tags);
        
		return redirect()->route('discussion.show',$discussion->slug)->with('success','Discussion updated');
		}

        public function delete($id){
            $discussion = $this->getDiscussion($id);
            if(!$discussion->isMine()){
                return redirect()->route('discussion.show',[$id])->with('error','Not allowed!');
            }
    
            return view('discussion.delete')->with('discussion', $discussion);
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discussion = $this->getDiscussion($id);
        if(!$discussion->isMine()){
			return redirect()->route('discussion.show',[$id])->with('error','Not allowed!');
		}
         $discussion->delete();
		 return redirect()->route('discussions')->with('success', 'Discussion <strong>"'.$discussion->title.'"</strong> deleted successfully');
        }

    public function inviteUsers(Request $request, $id){
        $discussion = $this->getDiscussion($id);
        $discussion->invitedUsers()->attach($request->users);
        return redirect()->back()->with('success', count($request->users).' person(s) invited to the discussion '.$discussion->title);
    }

    public function userDiscussions($username){
        $user = User::where('username',$username)->firstorfail();
        return view('discussion.index')->with('user',$user)->with('discussions', $user->discussions);
	}
}
