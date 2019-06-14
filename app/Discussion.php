<?php

namespace App;

use Auth;
use App\Training;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Discussion extends Model
{
	use softDeletes, SearchableTrait;
	
	protected $fillable = ['user_id', 'forum_id','training_id','title', 'content', 'slug'];

	protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'discussions.title' => 10,
            'discussions.content' => 10
		],
  ];

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
	public function training(){
		if($this->training_id != null){
			return	Training::withTrashed()->where('id', $this->training_id)->first();
		}
		return null;
	}
	public function watchers(){
		return $this->hasMany('App\Watcher');
	}
	public function invitedUsers(){
		return $this->belongsToMany('App\User');
	}
	public function isTrashed(){
		return $this->deleted_at == null ? false : true;
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

	public function fromTraining(){
		return  $this->training() === null ? false : true;
	}
	public function tagIDs(){
		$tags = array();
		foreach($this->tags as $tag){
			array_push($tags, $tag->id);
		}
		return $tags;
	}

	public function relatedDiscussions(){
		$discussion_IDs = array();
		foreach($this->tagIDs() as $tag){//Get other discussion that has the tags
		   $IDs = DB::select("select discussion_id from discussion_tag where tag_id=$tag");
		   foreach($IDs as $id){
			if($this->id !== $id->discussion_id) {
				array_push($discussion_IDs,$id->discussion_id);
			}  
		   }
		}
		 
	return Discussion::whereIn('id',$discussion_IDs)->get();
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
	
	public function content($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': str_limit(strip_tags($this->content),200);
		}
		return $this->content == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No content </small>': $this->content;
	}
	public function isMine(){
		return (Auth::check() && Auth::id() == $this->user_id) ? true : false;
	}
	
}
