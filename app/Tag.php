<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model
{
	use SearchableTrait;
	
	protected $fillable = ['name','description','slug'];

	  /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'tags.name' => 10,
            'tags.description' => 10
        ],
	];
	
	public function posts(){
		return $this->belongsToMany('App\Post');
    }

    public function discussions(){
		return $this->belongsToMany('App\Discussion');
    }

	public function trainings(){
		return $this->belongsToMany('App\Training');
    }

  public function users(){
		return $this->belongsToMany('App\User');
  }

	public function description($mode = 'snippet'){
		if($mode === 'snippet'){
			return $this->description == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No description </small>': str_limit(strip_tags($this->description),50);
		}
		return $this->description == null ? '<small class="text-danger" ><i class="fa fa-exclamation-triangle"></i> No description </small>': $this->description;
	}
}
