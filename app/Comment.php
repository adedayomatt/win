<?php

namespace App;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use softDeletes;
	
	protected $fillable = ['user_id', 'discussion_id','content'];
   
	public function type(){
		return 'comment';
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
	
	public function isLiked(){
		if($this->likes()->where('user_id',Auth::id())->count() > 0){
			return true;
		}
		return false;
	}
	 
	public function replies(){
		return $this->hasMany('App\Comment');
	}
	
	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),50);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}
}
