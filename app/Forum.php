<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Forum extends Model
{
	use softDeletes, SearchableTrait;
	
	protected $fillable = ['user_id','name','description','slug'];

	protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'forums.name' => 10,
            'forums.description' => 10
		],
  ];

    public function discussions(){
		return $this->hasMany('App\Discussion');
	}
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function description($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->description == null ? '': str_limit(strip_tags($this->description),50);
		}
		return $this->description == null ? '': $this->description;
	}

	public function otherForums(){
		return Forum::where('id', '!=', $this->id)->orderby('created_at', 'desc')->get();
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

	public function trainingers(){
		$trainingers = [];
		foreach($this->trainingings() as $training){
			array_push($trainingers, $training->user);
		}
		return collect($trainingers);
	}

}
