<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Discussion;
use App\CommentLike;
use App\Traits\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use Resource;

    public function __construct(){
        $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->discussion_id = $discussion->id;
        $comment->content = $request->comment;
        $comment->save();

        return redirect()->route('discussion.show',$discussion->slug)->with('success','comment added');

    }

    public function reply(Request $request, $discussion,$comment){
        $this->validate($request,[ 
            'comment' => 'required',
            'parent_comment' => 'required'
        ]);

        $comment = $this->find(Comment::class,$comment);
        $discussion = $this->find(Discussion::class,$discussion);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->comment_id = $request->parent_comment;
        $comment->discussion_id = $discussion->id;
        $comment->content = $request->comment;
        $comment->save();

        return redirect()->back()->with('success','You replied to '.$comment->user->fullname().' comment on '.$comment->discussion->title);
    }


    public function like(Request $request, $discussion,$comment){
        $comment = $this->find(Comment::class,$comment);
        if($comment->isLiked()){ //if already liked
            $like = CommentLike::where([
                ['comment_id',$comment->id],
                ['user_id',Auth::id()]
            ])->firstorfail();
            $like->delete();

            if($request->has('async')){
            return json_encode(['message' => 'you unliked '.$comment->user->firstname.'\' comment', 'count' =>$comment->likes->count()]);
            }

            return redirect()->back()->with('success','You unliked '.$like->comment->user->fullname().' comment on '.$like->comment->discussion->title);

        }else{ //if not liked before
            CommentLike::create([
                'user_id' => Auth::id(),
                'comment_id' => $comment->id
            ]);
            if($request->has('async')){
                return json_encode(['message' => 'you liked '.$comment->user->firstname.'\' comment', 'count' =>$comment->likes->count()]);
            }
            return redirect()->back()->with('success','You liked '.$comment->user->fullname().' comment on '.$comment->discussion->title);
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
        //
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
