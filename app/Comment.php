<?php

namespace App;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use softDeletes;
	
	protected $fillable = ['user_id', 'discussion_id','comment_id','content'];
	protected $appends = ['type','comment_discussion', 'reply_to', 'comment_likes', 'replies_count', 'created_timestamp'];
	

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
	
	public function isLiked(){
		if($this->likes()->where('user_id',Auth::id())->count() > 0){
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
		// I am not returning the model instance because it would keep returning the reply chain and the response size becomes bigger
		$reply_to = null;
		$reply_to = DB::table('comments')->where('id', $this->comment_id)->first();
		if($reply_to !== null){
			$carbon = new \Carbon\Carbon($reply_to->created_at);
			$reply_to->created_timestamp = $carbon->getTimestamp();
			$reply_to->user = User::find($reply_to->user_id);
		}
		return $reply_to;
	}

	public function getRepliesCountAttribute(){
		return $this->replies()->count();
	}

	public function getCommentLikesAttribute(){
		return $this->likes()->orderby('created_at', 'desc')->get();
	}
	public function getCreatedTimestampAttribute(){
		return $this->created_at->getTimestamp();
	}
	
	public function isReply(){
		$this->replies;
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
