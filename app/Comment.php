<?php

namespace App;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Resource;

class Comment extends Model
{
	use softDeletes, Resource;
	
	protected $fillable = ['user_id', 'discussion_id','comment_id','thread_id','content'];
	protected $appends = ['type','comment_discussion', 'reply_to', 'thread', 'likes_count', 'liked', 'replies_count', 'created_timestamp'];
	
	// sort collection of comments
	static function sort($comments){
		$sorted = [];
		foreach($comments as $comment){
			$thread = [];

		}
	}

	static function topContributors(){
		return Comment::select(DB::raw('count(user_id) as contributions, user_id'))->groupBy('user_id')->get();
	}

   public function user(){
		return $this->belongsTo('App\User');
	}
	public function discussion(){
		return Discussion::withTrashed()->where('id', $this->discussion_id)->first();
	}
	public function likes(){
		return $this->hasMany('App\CommentLike');
	}
	
	public function getLikedAttribute(){
		return $this->isLiked();
	}

	public function isLiked(){
		$user = $this->currentUser();
		if($user !== null){
			return $this->likedByUser($user);
		}
		return false;
	}

	public function likedByUser(User $user){
		if($this->likes()->where('user_id',$user->id)->count() > 0){
			return true;
		}
		return false;
	}
	 
	public function replies(){
		return $this->hasMany('App\Comment');
	}
	public function comment(){
		return $this->belongsTo('App\Comment');
	}

	public function getTypeAttribute(){
		$this->user;
		return 'comment';
	}
	public function getCommentDiscussionAttribute(){
		return $this->discussion();
	}
	public function getReplyToAttribute(){
		$user = $this->currentUser();
		// I am not returning the model instance because it would keep returning the reply chain and the response size becomes bigger
		// $reply_to = $this->find(Comment::class, $this->comment_id);
		$reply_to = $this->comment_id == null ? null : DB::table('comments')->where('id', $this->comment_id)->first();
		if($reply_to !== null){
			$carbon = new \Carbon\Carbon($reply_to->created_at);
			$reply_to->created_timestamp = $carbon->getTimestamp();
			$reply_to->user = User::find($reply_to->user_id);
			$reply_to->likes_count = CommentLike::where('comment_id', $reply_to->id)->count();
			$reply_to->replies_count = Comment::where('comment_id', $reply_to->id)->count();
			$reply_to->liked = $user == null ? false : (DB::table('comment_likes')->where([['comment_id',$reply_to->id],['user_id', $user->id]])->first() == null ? false : true);

		}
		return $reply_to;
	}
	// return other reply to the comment by the comment owner
	public function getThreadAttribute(){
		$user = $this->currentUser();
		return $this->getThread($this, $user, collect([]));
	}

	// A recursive function to get self replies
	public function getThread($comment, $user, $threads)
	{	 
		// if($threads->count() > 2){
		// 	return $threads->paginate(2);
		// }
		$first_reply = DB::table('comments')->where('comment_id',$comment->id)->first();
		if($first_reply == null){
			return $threads;
		}else{
			$carbon = new \Carbon\Carbon($first_reply->created_at);
			$first_reply->user = User::find($first_reply->user_id);
			$first_reply->likes_count = DB::table('comment_likes')->where('comment_id',$first_reply->id)->count();
			$first_reply->replies_count = DB::table('comments')->where('comment_id',$first_reply->id)->count();
			$first_reply->liked = $user == null ? false : (DB::table('comment_likes')->where([['comment_id',$first_reply->id],['user_id', $user->id]])->first() == null ? false : true);
			$first_reply->created_timestamp = $carbon->getTimestamp();
			$newThread = $threads->merge(collect([$first_reply]));
			return $this->getThread($first_reply, $user, $newThread);
		}
	}
	
	public function getRepliesCountAttribute(){
		return $this->replies()->count();
	}

	public function getLikesCountAttribute(){
		$this->likes;
		return $this->likes()->count();
	}

	public function getCommentLikesAttribute(){
		return $this->likes()->orderby('created_at', 'desc')->get();
	}
	public function getCreatedTimestampAttribute(){
		return $this->created_at->getTimestamp();
	}


	public function isReply(){
		return $this->comment == null ? false : true;
	}
	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),50);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}

	public function repliers(){
		$users = [];
		foreach($this->replies()->select(DB::raw('user_id'))->groupBy('user_id')->get() as $reply){
			array_push($users, $reply->user);
		}
		return collect($users);
	}
}
