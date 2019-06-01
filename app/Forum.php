<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{
	use softDeletes;
	
	protected $fillable = ['user_id','name','description','slug'];
	
    public function discussions(){
		return $this->hasMany('App\Discussion');
	}
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function description($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->description == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No description </small>': str_limit(strip_tags($this->description),50);
		}
		return $this->description == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No description </small>': $this->description;
	}

	public function discussionsId(){
		$discussions = [];
		foreach($this->discussions as $discussion){
			array_push($discussions, $discussion->id);
		}
		return $discussions;
	}

	public function contributions(){
		return	Comment::select(DB::raw('count(user_id) as contributions, user_id'))->whereIn('discussion_id', $this->discussionsId())->groupBy('user_id')->get();
	}

	public function contributors(){
		$contributors =[];
		foreach($this->contributions() as $contribution){
		array_push($contributors, $contribution->user);
		}
		return  collect($contributors);
	}

	public function userDiscussions(){
		return	Discussion::select(DB::raw('count(user_id) as discussions, user_id'))->whereIn('id',$this->discussionsId())->groupBy('user_id')->get();
	}

	public function posters(){
		$posters = [];
		foreach($this->postings() as $post){
			array_push($posters, $post->user);
		}
		return collect($posters);
	}

}
