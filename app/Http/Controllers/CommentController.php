<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Discussion;
use App\CommentLike;
use App\Traits\Resource;
use App\Events\NewComment;
use App\Events\NewCommentReply;
use App\Events\NewCommentLike;

use App\Http\Resources\Comment as CommentResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use Resource;

    public function __construct(){
        //$this->middleware('verified')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->isAPIRequest()){
            return CommentResource::collection(Comment::orderby('created_at','desc')->paginate(config('custom.pagination')));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$discussion)
    {
        $this->validate($request,[ 
			'comment' => 'required',
        ]);

        $discussion = $this->find(Discussion::class,$discussion);
        $user = $request->user();
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->discussion_id = $discussion->id;
        $comment->content = $request->comment;
        $comment->save();

        event(new NewComment($comment));

        if($this->isAPIRequest()){
           return response(['message' => 'You commented on '.$discussion->title, 'comment' => $comment]);
        }

        return redirect()->route('discussion.show',$discussion->slug)->with('success','comment added');

    }

    public function reply(Request $request ,$comment){
        $this->validate($request,[ 
            'comment' => 'required',
            'parent_comment' => 'required'
        ]);

        $comment = $this->find(Comment::class,$request->parent_comment);
        $user = $request->user();
        $reply = new Comment();
        $reply->user_id = $user->id;
        $reply->comment_id = $comment->id;
        $reply->discussion_id = $comment->discussion()->id;
        $reply->content = $request->comment;
        if($comment->user_id == $user->id){ //if it's a self reply, form a thread
            $reply->thread_id = $comment->id;
        }
        $reply->save();

        event(new NewCommentReply($reply));

        if($this->isAPIRequest()){
            return response(['message' => 'You replied to '.$comment->user->fullname, 'comment' => $reply]);
        }

        return redirect()->back()->with('success','You replied to '.$comment->user->fullname().' comment on '.$comment->discussion()->title);
    }


    public function like(Request $request, $comment){
        $comment = $this->find(Comment::class,$comment);
        $user = $request->user();
        if($comment->isLiked()){ //if already liked
            $like = CommentLike::where([
                ['comment_id',$comment->id],
                ['user_id',$user->id]
            ])->firstorfail();
            $like->delete();
    
            if($this->isAPIRequest()){
                return json_encode(['message' => 'you unliked '.$comment->user->firstname.'\' comment', 'like' => $like, 'count' =>$comment->likes->count(),  'like' => $like, 'action' => 'unlike']);
            }

            return redirect()->back()->with('success','You unliked '.$like->comment->user->fullname().' comment on '.$like->comment->discussion()->title);

        }else{ //if not liked before
           $like =  CommentLike::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id
            ]);
            event(new NewCommentLike($like));

            if($this->isAPIRequest()){
                return json_encode(['message' => 'you liked '.$comment->user->firstname.'\' comment', 'count' =>$comment->likes->count(), 'like' => $like, 'action' => 'like']);
            }
            return redirect()->back()->with('success','You liked '.$comment->user->fullname().' comment on '.$comment->discussion()->title);
            }
        }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->isAPIRequest()){
            $comment = $this->find(Comment::class,$id);
            return response(['comment' => $comment]);
        }
        $comment = Comment::findorfail($id);
        return view('comment.show')->with('comment',$comment);
    }

    public function engagements($id){
        if($this->isAPIRequest()){
            $comment = $this->find(Comment::class,$id);
            return response(['likes' => $comment->likes, 'replies' => $comment->replies]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($discussion,$id)
    {
        $discussion = $this->find(Discussion::class,$discussion);
        $comment = $this->find(Comment::class,$id);
        if(!$comment->isMine()){
            return redirect()->route('discussion.show',$discussion->slug)->with('warning', 'You cannot edit that comment');
        }
        return view('comment.edit')->with('comment');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$discussion,$id)
    {
        $discussion = $this->find(Discussion::class,$discussion);
        $comment = $this->find(Comment::class,$id);
        if(!$comment->isMine()){
            return redirect()->route('discussion.show',$discussion->slug)->with('warning', 'You cannot update that comment');
        }
        $this->validate($request,[ 
			'comment' => 'required',
        ]);
        $comment->content = $request->comment;
        $comment->save();

        return redirect()->back()->with('success','comment updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($discussion, $id)
    {
        $discussion = $this->find(Discussion::class,$discussion);
        $comment = $this->find(Comment::class,$id);
        if(!$comment->isMine()){
            return redirect()->route('discussion.show',$discussion->slug)->with('warning', 'You cannot delete that comment');
        }
        $comment->delete();
        return redirect()->back()->with('success','comment deleted');
    }
}
