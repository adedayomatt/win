<?php

namespace App;

use Auth;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Discussion extends Model
{
	use softDeletes;
	
	protected $fillable = ['user_id', 'forum_id','post_id','title', 'content', 'slug'];
	
	public function type(){
		return 'discussion';
	}

	public function forum(){
		return $this->belongsTo('App\Forum');
	}
	public function user(){
		return $this->belongsTo('App\User');
	}
    public function comments(){
		return $this->hasMany('App\Comment');
	}
	public function tags(){
        return $this->belongsToMany('App\Tag');
	}
	public function post(){
		return $this->belongsTo('App\Post');
	}
	public function watchers(){
		return $this->hasMany('App\Watcher');
	}
	public function invitedUsers(){
		return $this->belongsToMany('App\User');
	}
	public function invitedUsersId(){
		$users = [];
		foreach($this->invitedUsers as $user){
			array_push($users, $user->id);
		}
		return $users;
	}
	public function alreadyInvited($user){
		return in_array($user->id, $this->invitedUsersId()) ? true : false;
	}

	public function fromPost(){
		return  $this->post=== null ? false : true;
	}
	public function tagIDs(){
		$tags = array();
		foreach($this->tags as $tag){
			array_push($tags, $tag->id);
		}
		return $tags;
	}

	public function relatedDiscussions(){
		$discussions = collect([]);
		$related_discussions = $discussions;

		foreach($this->tagIDs() as $tag){//Get other discussion that has the tags
			$discussion_IDs = array();
		   $IDs = DB::select("select discussion_id from discussion_tag where tag_id=$tag");
		   foreach($IDs as $id){
			if($this->id !== $id->discussion_id) {
				array_push($discussion_IDs,$id->discussion_id);
			}  
		   }
			$related_discussions = $discussions->merge(Discussion::whereIn('id',$discussion_IDs)->get());
		}
	return $related_discussions;
	}
	
	public function contributions(){
		return	$this->comments()->select(DB::raw('count(user_id) as contributions, user_id'))->groupBy('user_id');
	}

	public function contributors(){
		$contributors =[];
		foreach($this->contributions()->get() as $contribution){
		array_push($contributors, $contribution->user);
		}
		return  collect($contributors);
	}



















	public function isWatchedByMe(){
		if($this->watchers()->where('user_id',Auth::id())->count() > 0){
			return true;
		}
		return false;
	}	

	public function bestReply(){
	if(!$this->bestReplyExist()){//if there is no best reply
			return null;
		}
		return Reply::find($this->best_reply);
	}
	
	public function bestReplyExist(){
		return ($this->best_reply === null ? false : true);
	}

	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),200);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}
	
}
