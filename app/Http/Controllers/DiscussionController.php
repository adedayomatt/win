<?php

namespace App\Http\Controllers;

use App\User;
use App\Discussion;
use App\Traits\Resource;
use App\Events\NewDiscussion;
use App\Http\Resources\Discussion as DiscussionResource;
use App\Http\Resources\Comment as CommentResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request as RequestFacade;

class DiscussionController extends Controller
{
    use Resource;
    
	public function __construct(){
        if($this->isAPIRequest()){
            $middleware = ['auth:api','verified'];
        }else{
            $middleware = ['auth','verified'];
        }
        $this->middleware($middleware)->except(['search','index','show','comments','userDiscussions','contributors']);

    }

    public function search(Request $request){
        return Discussion::search($request->get('q'))
                            ->with('user')
                            ->with('forum')
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
        
        if($this->isAPIRequest()){
            return DiscussionResource::collection($discussions->paginate(config('custom.pagination')));
        }

        return view('discussion.index')->with('discussions',$discussions->paginate(config('custom.pagination')))->with('src', $src);
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
        $discussion->user_id = Auth::id();
        if($request->exists('experience')){
            $discussion->experience_id = $request->experience;
        }
		$discussion->title = $request->discussion_title;
		$discussion->content = $request->content;
		$discussion->forum_id = $request->forum;
		$discussion->slug = $this->generateSlug(Discussion::class,$request->discussion_title);
        $discussion->save();
        $discussion->tags()->attach($request->tags);

        event(new NewDiscussion($discussion));
        
        if($this->isAPIRequest()){
            return new DiscussionResource($discussion);
        }
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
        if($this->isAPIRequest()){
            return new DiscussionResource($discussion);
        }
        $contributor = null;
        $comments = $discussion->comments()->where('comment_id',null);
        $count = $discussion->comments->count();
        // if you want to filter out only comments by a a particular contributor
        if(request()->get('contributor') != null){
            $contributor = User::where('username',request()->get('contributor'))->first();
            if($contributor != null){
                $comments = $discussion->comments()->where('user_id', $contributor->id);
                $count = $comments->count();
            }
        }
        return view('discussion.show')->with('discussion', $discussion)
                                        ->with('comments', $comments->orderby('created_at','desc')->paginate(config('custom.pagination')))
                                        ->with('count', $count)
                                        ->with('contributor', $contributor);
    }

    public function comments($discussion_id){
        $discussion = $this->find(Discussion::class,$discussion_id);
        $comments = $discussion->comments();
        if(request()->get('contributor') != null){
            $contributor = User::where('username',request()->get('contributor'))->first();
            if($contributor != null){
                $comments = $comments->where('user_id', $contributor->id);
            }
        }

        if($this->isAPIRequest()){
            return CommentResource::collection($comments->orderby('created_at','desc')->paginate(config('custom.pagination'))->appends(Input::except('page')));
        }

    }

    public function contributors($discussion_id){
        $discussion = $this->find(Discussion::class,$discussion_id);

        if($this->isAPIRequest()){
            return response($discussion->contributors);
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
        $discussion = $this->getDiscussion($id);
        if($this->isAPIRequest()){
            return new DiscussionResource($discussion);
        }
        return view('discussion.edit')->with('discussion', $discussion);
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

        if($this->isAPIRequest()){
            return new DiscussionResource($discussion);
        }

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
        if($this->isAPIRequest()){
            return DiscussionResource::collection($user->discussions->paginate(config('custom.pagination')));
        }

        return view('discussion.index')->with('user',$user)->with('discussions', $user->discussions->paginate(config('custom.pagination')));
	}
}
